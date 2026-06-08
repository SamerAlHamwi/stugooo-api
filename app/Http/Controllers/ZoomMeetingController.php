<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoomMeetingController extends Controller
{
    private $clientId = "YnTKqZVLRcyYS367cg73tQ";

    private $clientSecret = "x0ybh8ziIYjmLLus9lUbDZQHFrYtmF0O";

    private $redirectUri = "https://stugooo.com/auth/zoom/redirect";

    // =========================================================
    // LOGIN
    // =========================================================
    public function login(Request $request)
    {
        $userId = $request->query('userId');

        $isStageMethod = ($request->query('isStageMethod') ?? 'yes');

        $locale = ($request->query('locale') ?? 'en');

        if (empty($userId)) {

            return response()->json([
                "success" => false,
                "message" => "User ID required."
            ]);
        }

        if (!$this->checkUserId($userId, $isStageMethod)) {

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

        $url = "https://zoom.us/oauth/authorize?" . http_build_query([

            'response_type' => 'code',

            'client_id' => $this->clientId,

            'redirect_uri' => $this->redirectUri,

            'state' => $state,
        ]);

        return redirect($url);
    }

    // =========================================================
    // HANDLE REDIRECT
    // =========================================================
    public function handleRedirect(Request $request)
    {
        try {

            $code = $request->get('code');

            $state = $request->get('state');

            $decoded = json_decode(base64_decode($state), true);

            $userId = $decoded['userId'] ?? null;

            $isStageMethod = $decoded['isStageMethod'] ?? 'yes';

            $locale = $decoded['locale'] ?? 'en';

            if (!$userId) {

                return redirect()->away(
                    "https://stugooo.com/auth/zoom/zoom-status?success=false"
                );
            }

            // =========================================================
            // GET TOKEN
            // =========================================================

            $response = Http::withBasicAuth(
                $this->clientId,
                $this->clientSecret
            )->asForm()->post(
                'https://zoom.us/oauth/token',
                [
                    'grant_type' => 'authorization_code',

                    'code' => $code,

                    'redirect_uri' => $this->redirectUri,
                ]
            );

            $data = $response->json();

            if (!isset($data['access_token'])) {

                return redirect()->away(
                    "https://stugooo.com/auth/zoom/zoom-status?success=false"
                );
            }

            // =========================================================
            // GET USER INFO
            // =========================================================

            $userInfo = Http::withToken($data['access_token'])
                ->get('https://api.zoom.us/v2/users/me')
                ->json();

            // =========================================================
            // SAVE TOKENS
            // =========================================================

            Http::post(
                'https://updateZoomMeetingTokens-ysuk6o3iia-uc.a.run.app/',
                [

                    'userId' => $userId,

                    'isStageMethod' => $isStageMethod,

                    'accessToken' => $data['access_token'] ?? null,

                    'refreshToken' => $data['refresh_token'] ?? null,

                    'expiresIn' => $data['expires_in'] ?? null,

                    'tokenType' => $data['token_type'] ?? 'Bearer',

                    'zoomEmail' => $userInfo['email'] ?? null,

                    'zoomName' => $userInfo['first_name'] ?? null,

                    'zoomUserId' => $userInfo['id'] ?? null,

                    'requestUpdate' => 'save',
                ]
            );

            return redirect()->away(
                "https://stugooo.com/auth/zoom/zoom-status?success=true&locale=$locale"
            );

        } catch (\Exception $e) {

            return redirect()->away(
                "https://stugooo.com/auth/zoom/zoom-status?success=false&message=" . urlencode($e->getMessage())
            );
        }
    }

    // =========================================================
    // REFRESH TOKEN
    // =========================================================
    private function refreshToken($refreshToken)
    {
        try {

            $response = Http::withBasicAuth(
                $this->clientId,
                $this->clientSecret
            )->asForm()->post(
                'https://zoom.us/oauth/token',
                [
                    'grant_type' => 'refresh_token',

                    'refresh_token' => $refreshToken,
                ]
            );

            $data = $response->json();

            if (!isset($data['access_token'])) {

                return [
                    "success" => false,
                    "message" => "Failed refresh token.",
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
    // CREATE MEETING
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

            $zoomMeeting = $userData['zoomMeeting'] ?? null;

            if (!$zoomMeeting) {

                return response()->json([
                    "success" => false,
                    "message" => "Zoom account not connected."
                ]);
            }

            $accessToken = $zoomMeeting['zoomAccessToken'] ?? null;

            $refreshToken = $zoomMeeting['zoomRefreshToken'] ?? null;

            if (empty($accessToken)) {

                return response()->json([
                    "success" => false,
                    "message" => "No Zoom access token."
                ]);
            }

            // =========================================================
            // REFRESH TOKEN
            // =========================================================

            if ($this->checkTokenAge($zoomMeeting)) {

                $refresh = $this->refreshToken($refreshToken);

                if (!$refresh['success']) {

                    return response()->json([
                        "success" => false,
                        "message" => $refresh['message']
                    ]);
                }

                $accessToken = $refresh['data']['access_token'];

                Http::post(
                    'https://updateZoomMeetingTokens-ysuk6o3iia-uc.a.run.app/',
                    [

                        'userId' => $userId,

                        'isStageMethod' => $isStageMethod,

                        'accessToken' => $accessToken,

                        'refreshToken' => $refresh['data']['refresh_token'] ?? null,

                        'expiresIn' => $refresh['data']['expires_in'] ?? 3600,

                        'requestUpdate' => 'update',
                    ]
                );
            }

            // =========================================================
            // CREATE ZOOM MEETING
            // =========================================================

            $meetingData = [

                'topic' => $request->input(
                    'summary',
                    'Class Meeting'
                ),

                'type' => 2,

                'start_time' => $request->input('start'),

                'duration' => $request->input('duration', 60),

                'timezone' => 'Europe/Istanbul',

                'agenda' => $request->input(
                    'description',
                    'Zoom Session'
                ),

                'settings' => [

                    'host_video' => true,

                    'participant_video' => true,

                    'join_before_host' => false,

                    'mute_upon_entry' => true,

                    'waiting_room' => false,

                    'approval_type' => 0,
                ]
            ];

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->post(
                    'https://api.zoom.us/v2/users/me/meetings',
                    $meetingData
                );

            if ($response->failed()) {

                return response()->json([
                    "success" => false,
                    "message" => $response->body()
                ]);
            }

            $data = $response->json();

            return response()->json([

                "success" => true,

                "meetingId" => $data['id'] ?? null,

                "meetingPassword" => $data['password'] ?? null,

                "startUrl" => $data['start_url'] ?? null,

                "joinUrl" => $data['join_url'] ?? null,

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

            $meetingId = $request->query('meetingId');

            $isStageMethod = ($request->query('isStageMethod') ?? 'yes');

            if (empty($meetingId)) {

                return response()->json([
                    "success" => false,
                    "message" => "Meeting ID required."
                ]);
            }

            $userData = $this->getUserId($userId, $isStageMethod);

            if (empty($userData)) {

                return response()->json([
                    "success" => false,
                    "message" => "User not found."
                ]);
            }

            $zoomMeeting = $userData['zoomMeeting'] ?? null;

            if (!$zoomMeeting) {

                return response()->json([
                    "success" => false,
                    "message" => "Zoom account not connected."
                ]);
            }

            $accessToken = $zoomMeeting['zoomAccessToken'] ?? null;

            $response = Http::withToken($accessToken)
                ->delete(
                    "https://api.zoom.us/v2/meetings/$meetingId"
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
    private function checkTokenAge($zoomMeeting)
    {
        if (!isset($zoomMeeting['zoomExpiredAt'])) {
            return true;
        }

        return now()->timestamp >=
            intval($zoomMeeting['zoomExpiredAt'] / 1000) - 300;
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
    public function handleZoomStatus(Request $request)
    {
        return view('zoom-status');
    }
}