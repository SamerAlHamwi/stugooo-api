<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZohoController extends Controller
{
    private $clientId = "1000.UZ5W629KC0G4LZVTA79J2IWCKSX88H";
    private $clientSecret = "93c6e260af98ace805a6fe48e6fa264d2ec6742a71";
    private $redirectUri = "https://stugooo.com/auth/zoho/redirect";
	
  	public function initilizationView()
    {
        return view('zoho-initilization'); 
    }

    public function login(Request $request)
    {
        $userId = $request->query('userId');
        $isStageMethod = ($request->query('isStageMethod') ?? 'yes');
        $locale = ($request->query('locale') ?? 'en');
      
        if (empty($userId)) {
            $message = $this->getZohoStatusMessageError("USER_ID_REQUIRED_TO_COMPLETE_DATA", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }

        if (!$this->checkUserId($userId, $isStageMethod)) {
            $message = $this->getZohoStatusMessageError("USER_NOT_EXISTS_IN_DATABASE", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }

        $state = base64_encode(json_encode(['userId' => $userId, 'isStageMethod' => $isStageMethod, 'locale' => $locale]));

        // Use US data center since your OAuth client is from US (.com)
        // Based on your earlier error with location=us
        $url = "https://accounts.zoho.com/oauth/v2/auth?" . http_build_query([
            "scope" => "ZohoMeeting.meeting.ALL,ZohoMeeting.manageOrg.READ",
            "client_id" => $this->clientId,
            "response_type" => "code",
            "access_type" => "offline",
            "redirect_uri" => $this->redirectUri,
            "state" => $state,
        ]);

        Log::info('Zoho Login Redirect', ['url' => $url]);
        return redirect($url);
    }

    public function handleRedirect(Request $request)
    {
        $code = $request->get('code');
        $accountsServer = $request->get('accounts-server', 'https://accounts.zoho.com');
        $state = $request->get('state');
        $decoded = json_decode(base64_decode($state), true);
        
        $userId = $decoded['userId'] ?? null;
        $isStageMethod = $decoded['isStageMethod'] ?? 'yes';
        $locale = ($decoded['locale'] ?? 'en');
        
        Log::info('Zoho Redirect Handler', [
            'userId' => $userId,
            'accountsServer' => $accountsServer,
            'hasCode' => !empty($code)
        ]);
        
        if (!$userId) {
            $message = $this->getZohoStatusMessageError("USER_ID_NOT_EXISTS_IN_STATUS", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }

        if (!$isStageMethod) {
            $message = $this->getZohoStatusMessageError("STAGE_METHOD_NOT_EXISTS", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }
      
        if (!$this->checkUserId($userId, $isStageMethod)) {
            $message = $this->getZohoStatusMessageError("USER_ID_NOT_EXISTS_IN_DB", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }
      
        // Exchange code for token
        $response = Http::asForm()->post("$accountsServer/oauth/v2/token", [
            "grant_type" => "authorization_code",
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "redirect_uri" => $this->redirectUri,
            "code" => $code,
        ]);

        $data = $response->json();
        
        Log::info('Zoho Token Response', [
            'success' => isset($data['access_token']),
            'hasRefreshToken' => isset($data['refresh_token']),
            'responseStatus' => $response->status()
        ]);

        if (!isset($data['access_token'])) {
            Log::error('Zoho Token Error', ['response' => $data]);
            $message = $this->getZohoStatusMessageError("ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }
        
        // FIXED: Determine meeting API base URL from accounts server
        $host = parse_url($accountsServer, PHP_URL_HOST);
        $meetingApiBase = $this->getMeetingApiBaseFromHost($host);
        
        Log::info('Zoho API URLs', [
            'accountsServer' => $accountsServer,
            'meetingApiBase' => $meetingApiBase
        ]);
        
        // Get user details from Zoho Meeting API
        $dataUserDetails = Http::withHeaders([
            "Authorization" => "Zoho-oauthtoken {$data['access_token']}",
            "Content-Type"  => "application/json"
        ])->get("$meetingApiBase/api/v2/user.json");
        
        $zsoid = "";
        $zuid = "";
        $redirectionServer = "";

        if ($dataUserDetails->successful() && isset($dataUserDetails['userDetails'])) {
            $userDetails = $dataUserDetails['userDetails'];
            $zsoid = $userDetails['zsoid'] ?? '';
        	$zuid = $userDetails['zuid'] ?? $userDetails['superAdminZuid'] ?? '';
         	$redirectionServer = $userDetails['redirectionServer'] ?? '';
        } else {
            // Log the error for debugging
            Log::error('Zoho User Info Fetch Failed', [
                'status' => $dataUserDetails->status(),
                'body' => $dataUserDetails->body()
            ]);
        }
        
        Log::info('Zoho User Details', [
            'zsoid' => $zsoid,
            'zuid' => $zuid,
            'redirectionServer' => $redirectionServer,
            'successful' => $dataUserDetails->successful()
        ]);
      
        if (empty($zsoid) || empty($zuid)) {
            Log::error('Missing Zoho meeting data', [
                'zsoid' => $zsoid,
                'zuid' => $zuid,
                'response' => $dataUserDetails->json()
            ]);
            $message = $this->getZohoStatusMessageError("ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER_2", $locale);
            return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=false&locale=$locale&message=" . urlencode($message));
        }

        // Save to Firestore
        $save = Http::post('https://updateZohoMeetingTokens-ysuk6o3iia-uc.a.run.app/', [
            'userId' => $userId,
            'isStageMethod' => $isStageMethod,
            'accessToken' => $data['access_token'],
            'refreshToken' => $data['refresh_token'] ?? null,
            'apiDomain' => $data['api_domain'] ?? null,
            'apiDomainServer' => $accountsServer ?? null,
            'apiDomainMeetingServer' => $redirectionServer ?? null,
            'apiZSOID' => $zsoid,
            'apiZUID' => $zuid,
            'tokenType' => $data['token_type'] ?? 'Bearer',
            'expiresIn' => $data['expires_in'] ?? now()->timestamp,
            'requestUpdate' => 'save',
        ]);

        Log::info('Zoho Tokens Saved', ['userId' => $userId]);
        return redirect()->away("https://stugooo.com/auth/zoho/zoho-status?success=true&locale=$locale");        
    }
    
    private function getMeetingApiBaseFromHost($host)
    {
        if (strpos($host, 'zoho.eu') !== false) {
            return "https://meeting.zoho.eu";
        } elseif (strpos($host, 'zoho.com') !== false) {
            return "https://meeting.zoho.com";
        } elseif (strpos($host, 'zoho.in') !== false) {
            return "https://meeting.zoho.in";
        } elseif (strpos($host, 'zoho.com.cn') !== false) {
            return "https://meeting.zoho.com.cn";
        } elseif (strpos($host, 'zoho.jp') !== false) {
            return "https://meeting.zoho.jp";
        }
        return "https://meeting.zoho.com";
    }
    
    public function handleZohoStatus(Request $request)
    {
        return view('zoho-status'); 
    }
  
  	private function refreshToken($userId, $baseAPI, $refreshToken, $isStageMethod)
    {
      // check the userId
      if (empty($userId) || empty($baseAPI) || empty($refreshToken) || empty($isStageMethod)) {
        return (
        	array(
            	'success' => false,
              	'message' => 'User ID or refresh token or api url is required or not exists in database.',
            )
        );
      }
      
      if (!$this->checkUserId($userId, $isStageMethod)) {
      	return array( "success" => false, "message" => "No user exists in database, please make sure you are signed in." );
      }

      try {
          // Requets a new access token.
          $response = \Http::asForm()->post("$baseAPI/oauth/v2/token", [
              'refresh_token' => $refreshToken,
              'client_id' => $this->clientId,
              'client_secret' => $this->clientSecret,
              'grant_type' => 'refresh_token',
          ]);

          $data = $response->json();
        
          Log::info('Zoho Token Full Response', $data);

          if (!$response->successful() || !isset($data['access_token'])) {
            return array( "success" => false, "message" => "Failed to refresh access token, please make re-signed again to update the refresh token.", "data-error" => $refreshToken );
          }
        
          // Call 'Cloud Functions' to save the tokens in database.
          $save = \Http::post('https://updateZohoMeetingTokens-ysuk6o3iia-uc.a.run.app/', [
              'userId' => $userId,
              'accessToken' => $data['access_token'],
              'isStageMethod'=> $isStageMethod,
              'apiDomain' => $data['api_domain'] ?? null,
              'tokenType' => $data['token_type'] ?? 'Bearer',
              'expiresIn' => $data['expires_in'] ?? now()->timestamp,
              'requestUpdate' => 'update',
          ]);

          $saveResult = $save->json();
			
          return array( 
            "success" => ($saveResult['success'] ?? false),
            "message" => ($saveResult['message'] ?? 'Unknown error'),
            "data" => $data
          );          
      } catch (\Exception $e) {
        return array( 
            "success" => false,
            "message" => 'Error refreshing token: ' . $e->getMessage(),
         );
      }
    }
  
  	public function revokeToken(Request $request)
    {
      // check the userId
      $userId = $request->query('userId');
      $isStageMethod = ($request->query('isStageMethod') ?? 'yes');
      if (empty($userId)) {
        return (
        	array(
            	'success' => false,
              	'message' => 'User ID or refresh token or api url is required or not exists in database.',
            )
        );
      }
      
      if (!$this->checkUserId($userId, $isStageMethod)) {
      	return array( "success" => false, "message" => "No user exists in database, please make sure you are signed in." );
      }

      try {
          $userData = $this->getUserId($userId, $isStageMethod);
          if (empty($userData)) {
                return response()->json([
                  "success" => false,
                  "message" => "FB-DATA: No user exists in database, please make sure and try again.",
                ]);
          }
          $baseAPI = $userData["zohoApiDomainServer"];
          $refreshToken = $userData["zohoRefreshToken"];
          // Requets a new access token.
          $response = \Http::asForm()->get("$baseAPI/oauth/v2/token/revoke?token=$refreshToken");		  
          // Whatever the request response returened that means is true.
          $data = $response->json();
          // Return the success of true.
          return response()->json([ "success" => true ], 200);                    
      } catch (\Exception $e) {
        return array( 
            "success" => false,
            "message" => 'Error refreshing token: ' . $e->getMessage(),
         );
      }
    }
  
    public function createMeeting(Request $request)
    {
      	$accessToken = "";
      
      
        $userId = $request->query('userId');
        $isStageMethod = ($request->query('isStageMethod') ?? 'yes');
        if (empty($userId)) {
              return response()->json([
                "success" => false,
                 "error" => true,
                 "status" => "User id not provided",
              ]);
        }
        $userData = $this->getUserId($userId, $isStageMethod);
        if (empty($userData)) {
              return response()->json([
                "success" => false,
                 "error" => true,
                 "status" => "User id not exists in database.",
                "userData"=>$userData,
              ]);
        }
      
      
      
      	if ($this->checkTokenAge($userData)) {
          
          // Here we need to update the access token to new using refresh token.
          if (isset($userData["zohoRefreshToken"]) && isset($userData["zohoApiDomainServer"]) ) {
            $baseAPI = $userData["zohoApiDomainServer"];
            $refreshToken = $userData["zohoRefreshToken"];
            // Now, if every thing is ok, then refresh it.
            if (isset($baseAPI) && isset($refreshToken) && !empty($baseAPI) && !empty($refreshToken)) {
              $data = $this->refreshToken($userId, $baseAPI, $refreshToken, $isStageMethod);
              // Make refreshToken function and update the accessToken, otherwise return error.
              if (isset($data['success']) && isset($data['data']) && $data['success']) {
                $accessToken = $data['data']['access_token'];
              } else {
                // If any errors happend in refreshToken function.
                return response()->json([
                  "success" => false,
                  "message" => "No access token generated from 'refreshToken', please re-sign again!.",
              	]);
              }
            } else {
              	// If no data in database or missing data, so we need to re-sign again.
             	return response()->json([
                   "success" => false,
                   "message" => "Something went wrong, please re-signin with zoho meeting.",
            	]); 
            }
          } else {
            // If no data (zohoRefreshToken, zohoApiDomainServer)  in database or missing data, so we need to re-sign again.
            return response()->json([
                 "success" => false,
                 "message" => "No refresh token for user exists to can genearete new access token, make sure to sign in again.",
            ]);
          }
        } else {
          
          $accessToken = $userData["zohoAccessToken"];
          
        }
          $zohoApiDomainMeetingServer = $userData["zohoApiDomainMeetingServer"];
          $zohoApiZSOID = $userData["zohoApiZSOID"];
          $zohoApiZUID = $userData["zohoApiZUID"];
          
          // Check if any errors...
          if (empty($accessToken) || empty($zohoApiDomainMeetingServer) || empty($zohoApiZSOID) || empty($zohoApiZUID)) {
           return response()->json([
                 "success" => false,
                 "message" => "Something went wrong, some variables required to create meeting, please resign again with Zoho Meeting.",
            ]); 
          }
          // That means create the meeting now.
          $meetingData = [
            "topic"     => $request->input('summary', 'Default Lesson'),
            "agenda"    => $request->input('description', 'Class Session'),
            "presenter" => $zohoApiZUID,
            "startTime" => $request->input('start', "Nov 10, 2025 02:30 AM"),
            "duration"  => $request->input('duration', (1 * 60 * 60 * 1000)),
            "timezone"  => "Europe/Istanbul",
            
          ];

          $response = Http::withHeaders([
              "Authorization" => "Zoho-oauthtoken {$accessToken}",
              "Content-Type"  => "application/json"
          ])->post("https://$zohoApiDomainMeetingServer/api/v2/$zohoApiZSOID/sessions.json", array( 'session' => $meetingData ));
          
          if ($response->failed()) {
            return response()->json([
                "success" => false,
                "message" => $response->body()
            ]);
          }
		  
          
          
          $data = $response->json();
          // return response of create of this meeting.
          return response()->json([ "success" => true, "data" => $data ], 201);
        
    }
  	
  	public function updateMeeting(Request $request)
    {
      	$accessToken = "";
      
      
        $userId = $request->query('userId');
        $isStageMethod = ($request->query('isStageMethod') ?? 'yes');
        if (empty($userId)) {
              return response()->json([
                "success" => false,
                 "error" => true,
                 "status" => "User id not provided",
              ]);
        }
        $userData = $this->getUserId($userId, $isStageMethod);
        if (empty($userData)) {
              return response()->json([
                "success" => false,
                 "error" => true,
                 "status" => "User id not exists in database.",
                "userData"=>$userData,
              ]);
        }
      
      	if ($this->checkTokenAge($userData)) {
          // Here we need to update the access token to new using refresh token.
          if (isset($userData["zohoRefreshToken"]) && isset($userData["zohoApiDomainServer"]) ) {
            $baseAPI = $userData["zohoApiDomainServer"];
            $refreshToken = $userData["zohoRefreshToken"];
            // Now, if every thing is ok, then refresh it.
            if (isset($baseAPI) && isset($refreshToken) && !empty($baseAPI) && !empty($refreshToken)) {
              $data = $this->refreshToken($userId, $baseAPI, $refreshToken, $isStageMethod);
              // Make refreshToken function and update the accessToken, otherwise return error.
              if (isset($data['success']) && isset($data['data']) && $data['success']) {
                $accessToken = $data['data']['access_token'];
              } else {
                // If any errors happend in refreshToken function.
                return response()->json([
                  "success" => false,
                  "message" => "No access token generated from 'refreshToken', please re-sign again!.",
              	]);
              }
            } else {
              	// If no data in database or missing data, so we need to re-sign again.
             	return response()->json([
                   "success" => false,
                   "message" => "Something went wrong, please re-signin with zoho meeting.",
            	]); 
            }
          } else {
            // If no data (zohoRefreshToken, zohoApiDomainServer)  in database or missing data, so we need to re-sign again.
            return response()->json([
                 "success" => false,
                 "message" => "No refresh token for user exists to can genearete new access token, make sure to sign in again.",
            ]);
          }
        } else {
          $accessToken = $userData["zohoAccessToken"];
        }
          $zohoApiDomainMeetingServer = $userData["zohoApiDomainMeetingServer"];
          $zohoApiZSOID = $userData["zohoApiZSOID"];
          $zohoApiZUID = $userData["zohoApiZUID"];
          
          // Check if any errors...
          if (empty($accessToken) || empty($zohoApiDomainMeetingServer) || empty($zohoApiZSOID) || empty($zohoApiZUID)) {
           return response()->json([
                 "success" => false,
                 "message" => "Something went wrong, some variables required to create meeting, please resign again with Zoho Meeting.",
            ]); 
          }
          // That means create the meeting now.
          $meetingKey = $request->input('meetingKey', '123456789');
          $meetingData = [
            "topic"     => $request->input('summary', 'Default Lesson'),
            "agenda"    => $request->input('description', 'Class Session'),
            "presenter" => $zohoApiZUID,
            "startTime" => $request->input('start', "Nov 1, 2025 00:00 AM"),
            "duration"  => $request->input('duration', ((0.5) * 60 * 60 * 1000)),
            "timezone"  => "Europe/Istanbul",
          ];

          $response = Http::withHeaders([
              "Authorization" => "Zoho-oauthtoken {$accessToken}",
              "Content-Type"  => "application/json"
          ])->put("https://$zohoApiDomainMeetingServer/api/v2/$zohoApiZSOID/sessions/$meetingKey.json", array( 'session' => $meetingData ));
          
          if ($response->failed()) {
            return response()->json([
                "success" => false,
                "message" => $response->body()
            ]);
          }

          // return response of create of this meeting.
          return response()->json([ "success" => true ], 201);
        
    }
  
  	public function deleteMeeting(Request $request)
    {
      	$accessToken = "";
      
      
        $userId = $request->query('userId');
        $isStageMethod = ($request->query('isStageMethod') ?? 'yes');
        if (empty($userId)) {
              return response()->json([
                "success" => false,
                "message" => "User id not provided",
              ]);
        }
      
      
        $userData = $this->getUserId($userId, $isStageMethod);
        if (empty($userData)) {
              return response()->json([
                "success" => false,
                "message" => "User id not exists in database."
              ]);
        }
      
      
      	if ($this->checkTokenAge($userData)) {
          // Here we need to update the access token to new using refresh token.
          if (isset($userData["zohoRefreshToken"]) && isset($userData["zohoApiDomainServer"]) ) {
            $baseAPI = $userData["zohoApiDomainServer"];
            $refreshToken = $userData["zohoRefreshToken"];
            // Now, if every thing is ok, then refresh it.
            if (isset($baseAPI) && isset($refreshToken) && !empty($baseAPI) && !empty($refreshToken)) {
              $data = $this->refreshToken($userId, $baseAPI, $refreshToken, $isStageMethod);
              // Make refreshToken function and update the accessToken, otherwise return error.
              if (isset($data['success']) && isset($data['data']) && $data['success']) {
                $accessToken = $data['data']['access_token'];
              } else {
                // If any errors happend in refreshToken function.
                return response()->json([
                  "success" => false,
                  "message" => "No access token generated from 'refreshToken', please re-sign again!.",
                  "data" => isset($data['data-error']) ? json_encode($data['data-error']) : 'no',
              	]);
              }
            } else {
              	// If no data in database or missing data, so we need to re-sign again.
             	return response()->json([
                   "success" => false,
                   "message" => "Something went wrong, please re-signin with zoho meeting.",
            	]); 
            }
          } else {
            // If no data (zohoRefreshToken, zohoApiDomainServer)  in database or missing data, so we need to re-sign again.
            return response()->json([
                 "success" => false,
                 "message" => "No refresh token for user exists to can genearete new access token, make sure to sign in again.",
            ]);
          }
        } else {
          $accessToken = $userData["zohoAccessToken"];
        }
          $zohoApiDomainMeetingServer = $userData["zohoApiDomainMeetingServer"];
          $zohoApiZSOID = $userData["zohoApiZSOID"];
          $zohoApiZUID = $userData["zohoApiZUID"];
          
          // Check if any errors...
          if (empty($accessToken) || empty($zohoApiDomainMeetingServer) || empty($zohoApiZSOID) || empty($zohoApiZUID)) {
           return response()->json([
                 "success" => false,
                 "message" => "Something went wrong, some variables required to create meeting, please resign again with Zoho Meeting.",
            ]); 
          }
          // That means create the meeting now.
          $meetingKey = $request->input('meetingKey', '123456789');

          $response = Http::withHeaders([
              "Authorization" => "Zoho-oauthtoken {$accessToken}",
              "Content-Type"  => "application/json"
          ])->delete("https://$zohoApiDomainMeetingServer/api/v2/$zohoApiZSOID/sessions/$meetingKey.json");
          
          if ($response->failed()) {
            return response()->json([
                "success" => false,
                "message" => json_decode($response->body())['message'],
            ], $response->status());
          }
          
          if ($response->status() === 204) {
            return response()->json([
                 "success" => true
            ], 200); 
          } else {
            return response()->json([
                "success" => false,
                "status" => $response->status(),
                "message" => json_decode($response->body())['message'],
            ], $response->status());
          }
        
    }
  	
  	private function getZohoRegion($url)
    {
      $host = parse_url($url, PHP_URL_HOST);

      if (!$host || !str_contains($host, 'zoho')) {
          return null;
      }

      $parts = explode('.', $host);
      $tld = end($parts);

      return $tld;
    }

  	private function checkTokenAge($userData)
    {
      
      if (!isset($userData['zohoExpiresIn']) || !isset($userData['updatedAt'])) {
        return false; // ما في بيانات كافية
      }

      $updatedAt = $userData['updatedAt'];
      $updatedTime = \Carbon\Carbon::createFromTimestamp($updatedAt['_seconds']);

      $minutesSinceUpdate = $updatedTime->diffInMinutes(now());

      // اعتبر التوكن منتهي إذا مر أكتر من ساعة من وقت التحديث
      return $minutesSinceUpdate >= 55; 
    }
  
  	private function getUserId($userId, $isStageMethod = 'yes')
    {
      if (empty($userId) || $userId === 'null' || $userId === 'undefined') {
         return array( 'id' => 1, "accessToken" => "1" );
      }
      try {
            // 🔹 نستخدم رابط الـ API يلي انت عاملُه
            $apiUrl = "https://getpublicuserinfo-ysuk6o3iia-uc.a.run.app/?userId={$userId}&isStageMethod={$isStageMethod}";
            $response = Http::timeout(15)->get($apiUrl);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            // 🔹 إذا success = true والمستخدم موجود، نرجع true
            if (isset($data['success']) && $data['success'] === true && isset($data['user']['zohoMeeting'])) {
                return $data['user']['zohoMeeting'];
            }

            return null;
       } catch (\Exception $e) {
          return null;
       }
    }
  	private function checkUserId($userId, $isStageMethod = 'yes'): bool
    {
        if (empty($userId) || $userId === 'null' || $userId === 'undefined') {
            return false;
        }

        try {
            // Use the API URL that you created
            $apiUrl = "https://getpublicuserinfo-ysuk6o3iia-uc.a.run.app/?userId={$userId}&isStageMethod={$isStageMethod}";
            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                return false;
            }

            $data = $response->json();

            // If success = true and the user exists, return true
            if (isset($data['success']) && $data['success'] === true && isset($data['user']['fullname'])) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getZohoStatusMessageError($message, $locale)
    {
      $messagesEN = [
        "USER_ID_REQUIRED_TO_COMPLETE_DATA" => "User ID is required to complete data. Please try again.",
        "USER_NOT_EXISTS_IN_DATABASE" => "User not exists in database. Please try again. If you still have this problem, please contact the support.",
        "USER_ID_NOT_EXISTS_IN_STATUS" => "User not exists in status. Please try again. If you still have this problem, please contact the support.",
        "STAGE_METHOD_NOT_EXISTS" => "Stage method not exists. Please try again. If you still have this problem, please contact the support.",
        "USER_ID_NOT_EXISTS_IN_DB" => "User ID not exists in database. Please try again. If you still have this problem, please contact the support.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER" => "Access token not avaible from zoho server. Please try again. If you still have this problem, please contact the support.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER_2" => "Access token not avaible from zoho server or some data is missing. Please try again. If you still have this problem, please contact the support.",
        "somethingWentWrong" => "Something went wrong. Please try again. If you still have this problem, please contact the support.",
      ];
      $messagesTR = [
        "USER_ID_REQUIRED_TO_COMPLETE_DATA" => "Kullanıcı ID'si tamamlanması gerekiyor. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "USER_NOT_EXISTS_IN_DATABASE" => "Kullanıcı veritabanında bulunamadı. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "USER_ID_NOT_EXISTS_IN_STATUS" => "Kullanıcı durumunda bulunamadı. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "STAGE_METHOD_NOT_EXISTS" => "Stage method bulunamadı. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "USER_ID_NOT_EXISTS_IN_DB" => "Kullanıcı ID'si veritabanında bulunamadı. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER" => "Zoho sunucudan erişim tokeni alınamadı. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER_2" => "Zoho sunucudan erişim tokeni alınamadı veya bazı veriler eksik. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
        "somethingWentWrong" => "Bir şeyler ters gitti. Lütfen tekrar deneyin. Bu problem devam ederse, lütfen desteğe başvurun.",
      ];
      $messagesAR = [
        "USER_ID_REQUIRED_TO_COMPLETE_DATA" => "يجب عليك إدخال رقم المستخدم لإكمال البيانات. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "USER_NOT_EXISTS_IN_DATABASE" => "المستخدم غير موجود في قاعدة البيانات. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "USER_ID_NOT_EXISTS_IN_STATUS" => "المستخدم غير موجود في الحالة. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "STAGE_METHOD_NOT_EXISTS" => "طريقة المرحلة غير موجودة. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "USER_ID_NOT_EXISTS_IN_DB" => "رقم المستخدم غير موجود في قاعدة البيانات. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER" => "لا يمكن الحصول على رمز التحقق من الهوية من خادم زوهو. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "ACCESS_TOKEN_NOT_AVALIABLE_FROM_ZOHO_SERVER_2" => "لا يمكن الحصول على رمز التحقق من الهوية من خادم زوهو أو يوجد بيانات مفقودة. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
        "somethingWentWrong" => "حدث خطأ. يرجى المحاولة مرة أخرى. إذا لم يتم حل المشكلة، يرجى الاتصال بالدعم.",
      ];
      $messages = [
        "en" => $messagesEN,
        "tr" => $messagesTR,
        "ar" => $messagesAR,
      ];

      return $messages[$locale][$message] ?? $messages["en"][$message];
    }
}
