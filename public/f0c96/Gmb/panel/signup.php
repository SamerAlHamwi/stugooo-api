<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    require_once "inc/app.php";

    if( is_logged() ) {
        header("location: index.php");
        exit();
    }

    $get_users = get_data('users');
    if( count($get_users) > 1 ) {
        header('Location: index.php');
        exit;
    }
    
    if( $_POST ) {
        $username    = $_POST['username'];
        $password    = $_POST['password'];
        $add     = insert_user($username,$password,1);
        if( $add == false ) {
            header("Location: signup.php?error=1");
            exit();
        } else {
            header("Location: index.php?success=1");
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/helpers.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <title>ADD</title>
    </head>

    <body>

        <main id="main" class="pt-5 pb-5">
            <div class="container">
                <div class="login-area" style="max-width: 500px; margin: 0 auto;">
                    <div class="logo text-center mb-5">
                        <img style="max-width: 130px; border-radius: 100%;" src="assets/images/logo.jpg">
                    </div>

                    <div class="card">
                        <h3 class="card-header pt-3 pb-3 text-center" style="font-weight: 700;">Z0N51PANEL <span class="badge bg-warning text-dark" style="font-size: 12px; vertical-align: super;">Create new admin</span></h3>
                        <div class="card-body">

                            <?php
                                if( isset($_GET['success']) ) {
                                    echo '<div class="alert alert-success" role="alert">Success!</div>';
                                } else if( isset($_GET['error']) ) {
                                    echo '<div class="alert alert-danger" role="alert">Error!</div>';
                                }
                            ?>

                            <form action="" method="POST" autocomplete="off" class="install-form">
                                <input type="hidden" name="new_admin" value="1">
                                <div class="form-group mb-4">
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" required>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary d-block w-100">CREATE</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer id="footer">
            <div class="container" style="max-width: 700px;">
                <h3 class="mb-4">Z0N51PANEL <i style="color: red;" class="fa-solid fa-heart"></i></h3>
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
            
        </script>

    </body>

</html>