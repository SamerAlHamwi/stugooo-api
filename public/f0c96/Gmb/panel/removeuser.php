<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    include_once 'inc/app.php';

    if( !is_superadmin() ) {
        echo 'error';
        exit();
    }
    
    $check = get_data('users',['id' => $_POST['id']]);
    if( count($check) == 0 ) {
        echo 'error';
        exit();
    }

    $delete = delete_data('users',['id' => $_POST['id']]);
    echo 'success';
    exit;

?>