<?php

	function get_client_ip() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        if( $ip == '::1' ) {
            return '127.0.0.1';
        }
        return  $ip;
    }

    function visitors($ip_infos,$detection) {
        $Browser = new foroco\BrowserDetection();
        $useragent       = $_SERVER['HTTP_USER_AGENT'];
        $result = $Browser->getAll($useragent, 'JSON');
        $ip              = get_client_ip();
        $date            = date("Y-m-d H:i:s", time());
        $result          = json_decode($result,true);
        $os_type         = $result['os_type'];
        $os_name         = $result['os_name'];
        $device_type     = $result['device_type'];
        $browser_name    = $result['browser_name'];
        $browser_version = $result['browser_version'];
        $browser_version = $result['browser_version'];
        $country         = ( $ip_infos['country'] ) ? $ip_infos['country'] : '';

        $str = " <tr><th scope='row'>$ip ($country)</th><td>$date</td><td>$detection</td><td>[$device_type] $browser_name $browser_version</td></tr>";
        file_put_contents('visitors.html', $str  , FILE_APPEND | LOCK_EX);
    }

    function block_user_agent($useragents) {
    	if( !is_array($useragents) )
    		return false;
	    $cur_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        foreach ($useragents as $agent) {
            if (stripos($cur_agent,trim($agent))) {
                return true;
            }
        }
	    return false;
	}

    function ip_filter($ips) {
        if( !is_array($ips) )
            return false;
        foreach ($ips as $ip) {
            if (preg_match('/' . trim($ip) . '/',get_client_ip())) {
                return true;
            }
        }
        return false;
    }

    function allow_mobile_only() {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (!empty($userAgent) && preg_match('/(android|iphone|ipod|ipad|windows phone)/i', $userAgent)) {
            return true;
        } else {
            return false;
        }
    }

    function allow_desktop_only() {
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (!empty($userAgent) && preg_match('/(android|iphone|ipod|ipad|windows phone)/i', $userAgent)) {
            return false;
        } else {
            return true;
        }
    }

    function allow_device($device) {
        if( $device == 'all' ) {
            return false;
        }
        if( $device == 'mobile' ) {
            if( !allow_mobile_only() )
                return true;
        }
        if( $device == 'desktop' ) {
            if( !allow_desktop_only() )
                return true;
        }
        return false;
    }

    function one_time_access() {
        $filePath = 'one_time_access.txt';
        $clientIP = get_client_ip();
        $ips = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (in_array($clientIP, $ips)) {
            return true;
        }
        file_put_contents($filePath, $clientIP . PHP_EOL, FILE_APPEND | LOCK_EX);
        return false;
    }

	function dump($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

?>