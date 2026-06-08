<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    require_once "inc/app.php";

    if( !is_logged() ) {
        header("location: index.php");
        exit();
    }

    $id = intval($_GET['id']);
    if( !$id ) {
        header("location: index.php");
        exit();
    }

    if( $id !== $_SESSION['id'] ) {
        header("location: index.php");
        exit();
    }
    
    $cur_user = get_data('users',['id' => $_SESSION['id']]);
    if( count($cur_user) == 0 ) {
        header("location: index.php");
        exit();
    }

    if( $_POST ) {
        $username    = $_POST['username'];
        $password    = $_POST['password'];
        $check       = get_data('users',['username' => $_POST['username']]);

        if( count($check) > 0 && $check[0]['username'] !== $_SESSION['name'] ) {
            header("Location: profile.php?id=". $_SESSION['id'] ."&error=1");
        exit();
        }

        $data = [
            'username' => $_POST['username'],
        ];

        if( !empty($password) ) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $update = update_data('users',$data,['id' => $_SESSION['id']]);
        header("Location: profile.php?id=". $_SESSION['id'] ."&success=1");
        exit();
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

        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Z0N51PANEL</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="visitors.php">Visitors</a>
                            </li>
                            <?php if( is_superadmin() ) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Users
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="users.php">List</a></li>
                                    <li><a class="dropdown-item" href="createuser.php">Create</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Weclome <?php echo $_SESSION['name']; ?></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="profile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main" class="pt-5 pb-5">
            <div class="container">
                <div class="login-area" style="max-width: 500px; margin: 0 auto;">
                    <div class="logo text-center mb-5">
                        <img style="max-width: 130px; border-radius: 100%;" src="assets/images/logo.jpg">
                    </div>

                    <div class="card">
                        <h3 class="card-header pt-3 pb-3 text-center" style="font-weight: 700;">Z0N51PANEL <span class="badge bg-warning text-dark" style="font-size: 12px; vertical-align: super;">Edit your profile</span></h3>
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
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" value="<?php echo $cur_user[0]['username']; ?>" required>
                                </div>
                                <div class="form-group mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary d-block w-100">EDIT</button>
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