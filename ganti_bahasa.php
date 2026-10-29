<?php
require_once 'includes/init.php';

$pilihan = $_GET['lang'] ?? 'id';

switch ($pilihan) {
    case 'en':
        $_SESSION['lang'] = 'en';
        break;
    case 'id':
    default:
        $_SESSION['lang'] = 'id';
        break;
}


$tujuan = 'index.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $host_asal = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    if ($host_asal === ($_SERVER['SERVER_NAME'] ?? '') || $host_asal === parse_url('http://' . $_SERVER['HTTP_HOST'], PHP_URL_HOST)) {
        $tujuan = $_SERVER['HTTP_REFERER'];
    }
}

header("Location: " . $tujuan);
exit;
