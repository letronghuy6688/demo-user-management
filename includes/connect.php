<?php
if (!defined('_INCODE')) die('Access Deined....');

try {

    if (class_exists('PDO')) { // check tồn tại 

        $dsn = _DRIVER . ':dbname=' . _DB . ';host=' . _HOST;


        // khai báo phần hỗ trợ utf8;
        $option = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' //set utf8
            , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // đẩy lỗi vào ngoại lệ khi truy vấn.nếu sai sẽ hiện ra lỗi cụ thể.. cái này cần phải có 
        ];

        $conn = new PDO($dsn, _USER, _PASS, $option);
    }
} catch (Exception $exception) {
    require_once 'modules/error/database.php';
    die(); // nếu kết nối thất bại thì ngừng luôn 
}