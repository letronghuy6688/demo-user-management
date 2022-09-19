<?php
if (!defined('_INCODE')) die('Access Deined....');

$body = getBody();

if (!empty($body['id'])) {
    $userId = $body['id'];

    $queryLogin_token = getRows("SELECT id FROM login_token WHERE userID = '$userId'");

    $queryUser = getRows("SELECT id FROM user WHERE id = '$userId'");

    if ($queryUser || $queryLogin_token) {

        if ($queryUser && $queryLogin_token) {
            $deleteLogin_token = delete('login_token', "userID = '$userId'");

            if ($deleteLogin_token) {
                $deleteUser = delete('user', "id = '$userId'");
                if ($deleteUser) {
                    setFlashData('msg', '消しました！');
                    setFlashData('msg-type', 'success');
                    redirect('?module=user');
                }
            }
        } else {
            $deleteUser = delete('user', "id = '$userId'");
            if ($deleteUser) {
                setFlashData('msg', '消しました！');
                setFlashData('msg-type', 'success');
                redirect('?module=user');
            }
        }
    } else {
        setFlashData('msg', 'ユーザー保存していません');
        setFlashData('msg-type', 'danger');
        redirect('?module=user');
    }
}