<?php
// file kích hoạt tài khoản 
if (!defined('_INCODE')) die('Access Deined....');

layout('header-login');

echo '<div class="container text-center "><br/>';

if (getBody()['token']) {
    $activeToken = getBody()['token'];
    $tokenQuery = firstRaw("SELECT id,email FROM user WHERE activeToken ='$activeToken'");

    if (!empty($tokenQuery)) {
        $email = $tokenQuery['email'];
        $userId = $tokenQuery['id'];

        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus =   updateData('user', $dataUpdate, "id='$userId'");

        if ($updateStatus) {
            setFlashData('msg', '会員登録完了しました！');
            setFlashData('msg-type', 'success');

            $linklogin = _WEB_HOST_ROOT . '?module=auth&action=login';
            $subject = '会員登録の手続きを完了しました';
            $contentEmail = 'ご利用いただき、ありがとうございます。 <br/>';
            $contentEmail .= '下記のURLをクリックして、ログインして下さい。 <br/>';
            $contentEmail .= '<br/>';
            $contentEmail .= $linklogin . '<br/>';
            $contentEmail .= 'どうも有難う御座います。';

            sendMail($email, $subject, $contentEmail);
        } else {
            setFlashData('msg', '会員登録完了できません！');
            setFlashData('msg-type', 'danger');
        }
        redirect('?module=auth&action=login');
    } else {
        getMsg('URLの期限を切れました!. <br/> 会員登録からやり直して下さい. ', 'danger');
    }
} else {
    getMsg('URLが存在していません!', 'danger');
}

echo '</div>';
layout('footer-login');