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

    $check = get_data('users',['id' => $_POST['rowid']]);
    if( count($check) == 0 ) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'No data provided']);
        exit;
    }

    $oldusername = $check[0]['username'];

    if( empty($_POST['username']) ) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Username is required!']);
        exit;
    }

    $check = get_data('users',['username' => $_POST['username']]);
    if( count($check) > 0 ) {
        if( $oldusername !== $check[0]['username'] ) {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Username Exists!']);
            exit;
        }
    }
    
    $data = [
        'username' => $_POST['username'],
    ];

    if( !empty($_POST['password']) ) {
       $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    $update = update_data('users',$data,['id' => $_POST['rowid']]);
    echo json_encode(['message' => 'Updated successfully!']);
    exit;

?>
