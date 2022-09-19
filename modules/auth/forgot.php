<?php
// file yêu cầu đặt lại  mật khẩu 
if (!defined('_INCODE')) die('Access Deined....');

$data = [
    'pageTile' => 'パスワード リセット ページ'
];

layout('header-login', $data);

if (isLogin()) {
    redirect('?module=user');
}

if (isPost()) {
    $body = getBody();
    if (!empty($body['phone']) && !empty($body['email'])) {

        $email = $body['email'];
        $phone = $body['phone'];

        $QueryUser = firstRaw("SELECT id,email,fullname  FROM user WHERE email='$email' AND phone='$phone'");

        if (!empty($QueryUser)) {
            $userId = $QueryUser['id'];
            $name = $QueryUser['fullname'];

            $forgotToken = sha1(uniqid() . time());

            $dataForgotToken = [
                'forgotToken' => $forgotToken,
                'updateAt' => date('Y-m-d H:i:s')
            ];
            $UpdataStatus = updateData('user', $dataForgotToken, "id= '$userId'");

            if ($UpdataStatus) {

                $lickResetPass = _WEB_HOST_ROOT . '?module=auth&action=reset&token=' . $forgotToken;

                $subject = '【重要】' . $name . '様　パスワード回復 メール です！';
                $contentEmail = $email . 'いつもご利用いただき、ありがとうございます。 <br/>';
                $contentEmail .= '下記のURLをクリックして、パスワード再設定してください。 <br/>';
                $contentEmail .= '<br/>';
                $contentEmail .= ' ▼ パスワード再設定の手続きを完了してください <br/>';
                $contentEmail .= $lickResetPass . '<br/>';
                $contentEmail .= 'どうも有難う御座います。';

                $sendMailResetPass = sendMail($email, $subject, $contentEmail);

                if ($sendMailResetPass) {
                    setFlashData('msg', 'メール確認してください！');
                    setFlashData('msg-type', 'success');
                } else {
                    setFlashData('msg', 'システム障害、後で戻ってください。 Sorry ');
                    setFlashData('msg-type', 'danger');
                }
            } else {
                setFlashData('msg', 'システム障害、後で戻ってください。 Sorry ');
                setFlashData('msg-type', 'danger');
            }
        } else {
            setFlashData('msg', 'アカウント保存していません！');
            setFlashData('msg-type', 'danger');
        }
    } else {

        if (empty($body['phone']) && !empty($body['email'])) {
            setFlashData('msg', '電話番号入力して下さい！');
            setFlashData('msg-type', 'danger');
        } else if (empty($body['email']) && !empty($body['phone'])) {
            setFlashData('msg', 'メール入力して下さい！');
            setFlashData('msg-type', 'danger');
        } else {
            setFlashData('msg', '入力して下さい！');
            setFlashData('msg-type', 'danger');
        }
    }

    redirect('?module=auth&action=forgot');
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg-type');

?>

<div class="row">
    <div class="col-6" style="margin: 50px auto; ">

        <h2 class="text-center"><?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : ''; ?></h2>

        <?php getMsg($msg, $msgType);
        ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="">電話番号</label>
                <input type="text" class="form-control" name="phone" placeholder="電話番号入力して下さい..." />
            </div>

            <div class="form-group">
                <label for="">メールアドレス</label>
                <input type="text" class="form-control" name="email" placeholder="メール入力して下さい..." />
            </div>

            <button type="submit" class="btn btn-primary btn-block"> 送信 </button>

            <hr />
            <p class="text-center"><a href="?module=auth&action=login">ログイン</a></p>
            <p class="text-center"><a href="?module=auth&action=register"> 新規登録　</a></p>


        </form>

    </div>

</div>

<?php

layout('footer-login');