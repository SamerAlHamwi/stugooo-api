<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleMeetController extends Controller
{
    private $clientId = "750160257836-soof0aqo24pfgfu2qlkcll7kk13vcpdq.apps.googleusercontent.com";

    private $clientSecret = "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";

    private $redirectUri = "https://stugooo.com/auth/google/redirect";

    // =========================================================
    // LOGIN
    // =========================================================
    public function login(Request $request)
    {
        try {

            Log::info('GOOGLE LOGIN START', [
                'full_url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'query' => $request->query(),
            ]);

            $userId = $request->query('userId');

            $isStageMethod = ($request->query('isStageMethod') ?? 'yes');

            $locale = ($request->query('locale') ?? 'en');

            if (empty($userId)) {

                Log::warning('GOOGLE LOGIN FAILED: USER ID EMPTY');

                return response()->json([
                    "success" => false,
                    "message" => "User ID required."
                ]);
            }

            if (!$this->checkUserId($userId, $isStageMethod)) {

                Log::warning('GOOGLE LOGIN FAILED: USER NOT FOUND', [
                    'userId' => $userId,
                    'isStageMethod' => $isStageMethod,
                ]);

                return response()->json([
                    "success" => false,
                    "message" => "User not exists in database."
                ]);
            }

            $state = base64_encode(json_encode([
                'userId' => $userId,
                'isStageMethod' => $isStageMethod,
                'locale' => $locale
            ]));

            Log::info('GOOGLE LOGIN STATE CREATED', [
                'decoded_state' => [
                    'userId' => $userId,
                    'isStageMethod' => $isStageMethod,
                    'locale' => $locale
                ],
                'encoded_state' => $state
            ]);

            $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([

                'client_id' => $this->clientId,

                'redirect_uri' => $this->redirectUri,

                'response_type' => 'code',

                'access_type' => 'offline',

                'prompt' => 'consent',

                'scope' => implode(' ', [

                    'https://www.googleapis.com/auth/calendar',

                    'https://www.googleapis.com/auth/userinfo.email',

                    'https://www.googleapis.com/auth/userinfo.profile'

                ]),

                'state' => $state,
            ]);

            Log::info('GOOGLE LOGIN REDIRECTING TO GOOGLE', [
                'google_oauth_url' => $url
            ]);

            return redirect($url);

        } catch (\Exception $e) {

            Log::error('GOOGLE LOGIN EXCEPTION', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    // =========================================================
    // HANDLE REDIRECT
    // =========================================================
    public function handleRedirect(Request $request)
    {
        try {

            Log::info('GOOGLE REDIRECT START', [
                'full_url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'query' => $request->query(),
            ]);

            $code = $request->get('code');

            $state = $request->get('state');

            Log::info('GOOGLE REDIRECT RAW DATA', [
                'has_code' => !empty($code),
                'state' => $state,
            ]);

            if (empty($code)) {

                Log::warning('GOOGLE REDIRECT FAILED: CODE MISSING');

                return redirect()->away(
                    "https://stugooo.com/auth/google/google-status?success=false&message=missing_code"
                );
            }

            $decoded = json_decode(base64_decode($state), true);

            Log::info('GOOGLE STATE DECODED', [
                'decoded' => $decoded
            ]);

            $userId = $decoded['userId'] ?? null;

            $isStageMethod = $decoded['isStageMethod'] ?? 'yes';

            $locale = $decoded['locale'] ?? 'en';

            if (!$userId) {

                Log::warning('GOOGLE REDIRECT FAILED: USER ID NOT FOUND IN STATE');

                return redirect()->away(
                    "https://stugooo.com/auth/google/google-status?success=false&message=missing_user_id"
                );
            }

            // =========================================================
            // EXCHANGE CODE
            // =========================================================

            Log::info('GOOGLE TOKEN EXCHANGE START');

            $response = Http::asForm()->post(
                'https://oauth2.googleapis.com/token',
                [
                    'code' => $code,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri' => $this->redirectUri,
                    'grant_type' => 'authorization_code',
                ]
            );

            Log::info('GOOGLE TOKEN RESPONSE', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            $data = $response->json();

            if (!isset($data['access_token'])) {

                Log::error('GOOGLE TOKEN FAILED', [
                    'response' => $data
                ]);

                return redirect()->away(
                    "https://stugooo.com/auth/google/google-status?success=false&message=no_access_token"
                );
            }

            // =========================================================
            // USER INFO
            // =========================================================

            Log::info('GOOGLE USER INFO REQUEST START');

            $userInfoResponse = Http::withToken($data['access_token'])
                ->get('https://www.googleapis.com/oauth2/v2/userinfo');

            Log::info('GOOGLE USER INFO RESPONSE', [
                'status' => $userInfoResponse->status(),
                'body' => $userInfoResponse->json(),
            ]);

            $userInfo = $userInfoResponse->json();

            // =========================================================
            // SAVE TOKENS
            // =========================================================

            Log::info('GOOGLE SAVE TOKENS START', [
                'userId' => $userId,
                'googleEmail' => $userInfo['email'] ?? null,
            ]);

            $saveResponse = Http::post(
                'https://updateGoogleMeetTokens-ysuk6o3iia-uc.a.run.app/',
                [

                    'userId' => $userId,

                    'isStageMethod' => $isStageMethod,

                    'accessToken' => $data['access_token'] ?? null,

                    'refreshToken' => $data['refresh_token'] ?? null,

                    'expiresIn' => $data['expires_in'] ?? null,

                    'tokenType' => $data['token_type'] ?? 'Bearer',

                    'googleEmail' => $userInfo['email'] ?? null,

                    'googleName' => $userInfo['name'] ?? null,

                    'requestUpdate' => 'save',
                ]
            );

            Log::info('GOOGLE SAVE TOKENS RESPONSE', [
                'status' => $saveResponse->status(),
                'body' => $saveResponse->body(),
            ]);

            $finalRedirect =
                "https://stugooo.com/auth/google/google-status?success=true&locale=$locale";

            Log::info('GOOGLE FINAL REDIRECT', [
                'redirect_to' => $finalRedirect
            ]);

            return redirect()->away($finalRedirect);

        } catch (\Exception $e) {

            Log::error('GOOGLE REDIRECT EXCEPTION', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->away(
                "https://stugooo.com/auth/google/google-status?success=false&message=" . urlencode($e->getMessage())
            );
        }
    }

    // =========================================================
    // REFRESH TOKEN
    // =========================================================
    private function refreshToken($refreshToken)
    {
        try {

            $response = Http::asForm()->post(
                'https://oauth2.googleapis.com/token',
                [
                    'client_id' => $this->clientId,

                    'client_secret' => $this->clientSecret,

                    'refresh_token' => $refreshToken,

                    'grant_type' => 'refresh_token',
                ]
            );

            $data = $response->json();

            if (!isset($data['access_token'])) {

                return [
                    "success" => false,
                    "message" => "Failed to refresh token.",
                    "data" => $data
                ];
            }

            return [
                "success" => true,
                "data" => $data
            ];

        } catch (\Exception $e) {

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    // =========================================================
    // CREATE GOOGLE MEET
    // =========================================================
    public function createMeeting(Request $request)
    {
        try {

            $userId = $request->query('userId');

            $isStageMethod = ($request->query('isStageMethod') ?? 'yes');

            if (empty($userId)) {

                return response()->json([
                    "success" => false,
                    "message" => "User ID required."
                ]);
            }

            $userData = $this->getUserId($userId, $isStageMethod);

            if (empty($userData)) {

                return response()->json([
                    "success" => false,
                    "message" => "User not found."
                ]);
            }

            // =========================================================
            // TOKENS
            // =========================================================

            $accessToken = $userData['googleCalendarAccessToken'] ?? null;

            $refreshToken = $userData['googleCalendarRefreshToken'] ?? null;

            if (empty($accessToken)) {

                return response()->json([
                    "success" => false,
                    "message" => "No Google access token found."
                ]);
            }

            // =========================================================
            // REFRESH TOKEN IF EXPIRED
            // =========================================================

            if ($this->checkTokenAge($userData)) {

                if (empty($refreshToken)) {

                    return response()->json([
                        "success" => false,
                        "message" => "Refresh token missing. Please login again."
                    ]);
                }

                $refresh = $this->refreshToken($refreshToken);

                if (!$refresh['success']) {

                    return response()->json([
                        "success" => false,
                        "message" => $refresh['message'],
                        "data" => $refresh['data'] ?? null
                    ]);
                }

                $accessToken = $refresh['data']['access_token'];

                // =========================================================
                // UPDATE FIREBASE
                // =========================================================

                Http::post(
                    'https://updateGoogleMeetTokens-ysuk6o3iia-uc.a.run.app/',
                    [

                        'userId' => $userId,

                        'isStageMethod' => $isStageMethod,

                        'accessToken' => $accessToken,

                        'expiresIn' => $refresh['data']['expires_in'] ?? 3600,

                        'requestUpdate' => 'update',
                    ]
                );
            }

            // =========================================================
            // CREATE EVENT
            // =========================================================

            $start = $request->input('start');

            $end = $request->input('end');

            if (empty($start) || empty($end)) {

                return response()->json([
                    "success" => false,
                    "message" => "Start and end dates are required."
                ]);
            }

            $event = [

                'summary' => $request->input(
                    'summary',
                    'Class Meeting'
                ),

                'description' => $request->input(
                    'description',
                    'Google Meet Session'
                ),

                'start' => [
                    'dateTime' => $start,
                    'timeZone' => 'Europe/Istanbul',
                ],

                'end' => [
                    'dateTime' => $end,
                    'timeZone' => 'Europe/Istanbul',
                ],

                'conferenceData' => [

                    'createRequest' => [

                        'requestId' => uniqid(),

                        'conferenceSolutionKey' => [
                            'type' => 'hangoutsMeet'
                        ]
                    ]
                ]
            ];

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post(
                    'https://www.googleapis.com/calendar/v3/calendars/primary/events?conferenceDataVersion=1',
                    $event
                );

            if ($response->failed()) {

                return response()->json([
                    "success" => false,
                    "message" => $response->body()
                ]);
            }

            $data = $response->json();

            $meetLink = $data['hangoutLink']
                ?? $data['conferenceData']['entryPoints'][0]['uri']
                ?? null;

            return response()->json([

                "success" => true,

                "meetLink" => $meetLink,

                "eventId" => $data['id'] ?? null,

                "data" => $data

            ]);

        } catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    // =========================================================
    // DELETE MEETING
    // =========================================================
    public function deleteMeeting(Request $request)
    {
        try {

            $userId = $request->query('userId');

            $eventId = $request->query('eventId');

            $isStageMethod = ($request->query('isStageMethod') ?? 'yes');

            if (empty($eventId)) {

                return response()->json([
                    "success" => false,
                    "message" => "Event ID required."
                ]);
            }

            $userData = $this->getUserId($userId, $isStageMethod);

            if (empty($userData)) {

                return response()->json([
                    "success" => false,
                    "message" => "User not found."
                ]);
            }

            $accessToken = $userData['googleCalendarAccessToken'] ?? null;

            $refreshToken = $userData['googleCalendarRefreshToken'] ?? null;

            if (empty($accessToken)) {

                return response()->json([
                    "success" => false,
                    "message" => "No Google access token."
                ]);
            }

            // =========================================================
            // REFRESH TOKEN IF EXPIRED
            // =========================================================

            if ($this->checkTokenAge($userData)) {

                if (empty($refreshToken)) {

                    return response()->json([
                        "success" => false,
                        "message" => "Refresh token missing. Please login again."
                    ]);
                }

                $refresh = $this->refreshToken($refreshToken);

                if (!$refresh['success']) {

                    return response()->json([
                        "success" => false,
                        "message" => $refresh['message'],
                        "data" => $refresh['data'] ?? null
                    ]);
                }

                $accessToken = $refresh['data']['access_token'];

                Http::post(
                    'https://updateGoogleMeetTokens-ysuk6o3iia-uc.a.run.app/',
                    [
                        'userId' => $userId,
                        'isStageMethod' => $isStageMethod,
                        'accessToken' => $accessToken,
                        'expiresIn' => $refresh['data']['expires_in'] ?? 3600,
                        'requestUpdate' => 'update',
                    ]
                );
            }

            $response = Http::withToken($accessToken)
                ->delete(
                    "https://www.googleapis.com/calendar/v3/calendars/primary/events/$eventId"
                );

            if ($response->failed()) {

                return response()->json([
                    "success" => false,
                    "message" => $response->body()
                ]);
            }

            return response()->json([
                "success" => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    // =========================================================
    // CHECK TOKEN AGE
    // =========================================================
    private function checkTokenAge($userData)
    {
        if (!isset($userData['googleCalendarExpiredAt'])) {
            return true;
        }

        return now()->timestamp >=
            intval($userData['googleCalendarExpiredAt'] / 1000) - 300;
    }

    // =========================================================
    // GET USER
    // =========================================================
    private function getUserId(
        $userId,
        $isStageMethod = 'yes'
    )
    {
        try {

            if (
                empty($userId) ||
                $userId === 'null' ||
                $userId === 'undefined'
            ) {
                return null;
            }

            $apiUrl =
                "https://getpublicuserinfo-ysuk6o3iia-uc.a.run.app/?userId={$userId}&isStageMethod={$isStageMethod}";

            $response = Http::timeout(15)->get($apiUrl);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            if (
                isset($data['success']) &&
                $data['success'] === true &&
                isset($data['user'])
            ) {
                return $data['user'];
            }

            return null;

        } catch (\Exception $e) {

            return null;
        }
    }

    // =========================================================
    // CHECK USER
    // =========================================================
    private function checkUserId(
        $userId,
        $isStageMethod = 'yes'
    ): bool
    {
        try {

            if (
                empty($userId) ||
                $userId === 'null' ||
                $userId === 'undefined'
            ) {
                return false;
            }

            $apiUrl =
                "https://getpublicuserinfo-ysuk6o3iia-uc.a.run.app/?userId={$userId}&isStageMethod={$isStageMethod}";

            $response = Http::timeout(10)->get($apiUrl);

            if (!$response->successful()) {
                return false;
            }

            $data = $response->json();

            return (
                isset($data['success']) &&
                $data['success'] === true &&
                isset($data['user']['fullname'])
            );

        } catch (\Exception $e) {

            return false;
        }
    }

    // =========================================================
    // STATUS VIEW
    // =========================================================
    public function handleGoogleStatus(Request $request)
    {
        return view('google-status');
    }
}