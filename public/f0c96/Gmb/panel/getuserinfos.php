<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    include_once 'inc/app.php';

    if( !is_superadmin() ) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'No data provided']);
        exit;
    }
    
    $check = get_data('users',['id' => $_POST['id']]);
    if( count($check) == 0 ) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'No data provided']);
        exit;
    }

    $data = $check[0];
    echo json_encode($data);
    exit;
?>
