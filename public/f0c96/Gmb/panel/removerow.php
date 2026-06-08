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
    
    $check = get_data('data',['id' => $_POST['id']]);
    if( count($check) == 0 ) {
        echo 'error';
        exit();
    }

    $delete = delete_data('data',['id' => $_POST['id']]);
    echo 'success';
    exit;

?>