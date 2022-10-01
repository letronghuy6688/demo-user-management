<?php

date_default_timezone_set('Asia/Tokyo');

const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'lists';


//hàm chặn đăng nhập trực tiếp 
const _INCODE = true;


// thiết lập host 
define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/PHP7.4.28/demo'); // địa chỉ trang chủ 
define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT . '/template'); // địa chỉ đến file css 


//thiết lập path 
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT . '/template');

// thiết lập kết nối database
const _HOST = 'db-mysql-huy-do-user-12553158-0.b.db.ondigitalocean.com:25060';
const _USER = 'doadmin';
const _PASS = 'AVNS_bRNHRi0t5hD76ygF3xO';
const _DB = 'users_management_demo';
// const _PORT = 25060;
const _DRIVER = 'mysql';