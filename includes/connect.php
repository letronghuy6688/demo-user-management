<?php
if (!defined('_INCODE')) die('Access Deined....');

try {

    if (class_exists('PDO')) { // check tồn tại 

        $dsn = _DRIVER . ':dbname=' . _DB . ';host=' . _HOST;




        $conn = new PDO($dsn, _USER, _PASS);
    }
} catch (Exception $exception) {
    require_once 'modules/error/database.php';
    die(); // nếu kết nối thất bại thì ngừng luôn 
}