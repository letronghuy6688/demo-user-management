<?php

// file đăng xuất 
if (!defined('_INCODE')) die('Access Deined....');

if (isLogin()) {

    $token = getSession('logintoken');

    if (!empty($token)) {

        $TokenId = firstRaw("SELECT userID FROM login_token WHERE token='$token'");

        $userID = $TokenId['userID'];

        if (!empty($TokenId)) {
            $deleteToken = delete('login_token', "userID='$userID'");


            if ($deleteToken) {
                removeSession('logintoken');
                redirect('?module=auth&action=login');
            }
        }
    }
}