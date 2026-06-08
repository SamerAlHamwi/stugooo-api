<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    include_once 'inc/app.php';
    if( !is_superadmin() ) {
        header("location: index.php");
        exit();
    }

    $users = get_data("users",['role' => 2]);

?>

<!DOCTYPE html>
<html style="display: flex; flex-direction: column; height: 100%;">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="assets/css/helpers.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Data</title>
</head>
<body style="display: flex; flex-direction: column; height: 100%;">

    <div class="loader">
        <div class="inner">
            <div class="spinner-border text-secondary" role="status"></div>
        </div>
    </div>

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

    <main id="main" class="pt50 pb50">
        <div class="container">
            <div class="table-responsive"></div>
                <table id="table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Options</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if( $users ) {
                            foreach($users as $user) {
                                ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td>
                                        <span id="edit" data-id="<?php echo $user['id']; ?>" class="badge text-bg-success mr5 mb-1"><i class="fa-solid fa-pen"></i></span>
                                        <span id="remove" data-id="<?php echo $user['id']; ?>" class="badge text-bg-danger mr5 mb-1"><i class="fa-solid fa-trash"></i></span>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Options</th>
                        </tr>
                    </tfoot>
                </table>
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

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="infos" enctype="multipart/form-data">
                    <input type="hidden" id="rowid" name="rowid" value="">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">User Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        var table = $('#table').DataTable( {
            responsive: true,
        });

        var myModal = new bootstrap.Modal(document.getElementById('modal'));

        $("body").on("click", "#edit", function(event){
            var id = $(this).data('id');
            $('#rowid').val(id);
            formData = {
                'id' : id,
            }

            $.ajax({
                type: 'POST',
                url: 'getuserinfos.php',
                data: formData,
                dataType: 'json',
                beforeSend: function(){
                    $('.alert').remove();
                    $('.loader').css("display","flex");
                },
                success: function(response){
                    $('.alert').remove();
                    $('.loader').css("display","none");

                    if (response !== null) {
                        if( response.username !== null ) {
                            $('#username').val(response.username);
                        }
                    }
                    
                    myModal.show();

                },
                error: function (request, status, error) {
                    alert('Error');
                }
            });
        });

        $("#infos").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'edituser.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.alert').remove();
                    $('.loader').css("display","flex");
                },
                success: function(response){
                    $('.loader').css("display","none");
                    $('.alert').remove();
                    $('.modal-body').prepend('<div class="alert alert-success">'+ response.message +'</div>');
                },
                error: function (request, status, error) {
                    $('.loader').css("display","none");
                    $('.alert').remove();
                    $('.modal-body').prepend('<div class="alert alert-danger">'+ request.responseJSON.message +'</div>');
                }
            });

        });

        $("body").on("click", '[data-to]', function(event){
            
            $('.loader').css("display","flex");

            formData = {
                'ip' : $(this).data('ip'),
                'to' : $(this).data('to'),
            }
            $.post( "to.php", formData )
                .done(function( data ) {
                if( data == "success" ) {
                    $('.loader').css("display","none");
                }
            });
        });

        $("body").on("click", '#remove', function(event){
            
            $('.loader').css("display","flex");

            var tt = $(this);

            formData = {
                'id' : $(this).data('id'),
            }
            $.post( "removeuser.php", formData )
                .done(function( data ) {
                if( data == "success" ) {
                    tt.closest('tr').hide(500);
                    $('.loader').css("display","none");
                }
            });
        });

        $("#modal").on("hidden.bs.modal", function () {
            $('#rowid').val('');
            $('#full_name').val('');
            $('#message').val('');
        });
    </script>

</body>
</html>