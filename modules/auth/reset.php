<?php

// file xác thực mật khẩu đặt lại  
if (!defined('_INCODE')) die('Access Deined....');

$data = [
    'pageTile' => 'パスワード リセット ページ'
];


layout('header-login');
echo '<div class="container text-center "><br/>';

if (getBody()['token']) {
    $token = getBody()['token'];

    $QueryReset = firstRaw("SELECT id,email,fullname FROM user WHERE forgotToken='$token'");

    if ($QueryReset) {
        $name = $QueryReset['fullname'];
        $email = $QueryReset['email'];
        $userId = $QueryReset['id'];
        $error = [];

        if (isPost()) {
            $body = getBody();
            if (empty(trim($body['password']))) {
                $error['password']['required'] = 'パスワード　🔑　入力して下さい! ';
            } else {
                if (strlen(trim($body['password'])) < 5) {
                    $error['password']['min'] = '8桁入力して下さい!';
                }
            }

            if (empty(trim($body['confirm-password']))) {
                $error['confirm-password']['required'] = '確認パスワード入力して下さい。';
            } else {
                if (trim($body['password']) != trim($body['confirm-password'])) {
                    $error['confirm-password']['match'] = '再入力して下さい';
                }
            }

            if (empty($error)) {
                $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);

                $data = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'updateAt' => date('Y-m-d H:i:s')
                ];

                $updateStatus = updateData('user', $data, "id='$userId'");

                if ($updateStatus) {
                    setFlashData('msg', 'パスワード変更しました');
                    setFlashData('msg-type', 'success');
                    $linkLogin = _WEB_HOST_ROOT . '?module=auth&action=login';
                    $subject = ' 【お知らせ】' . $name . 'パスワード変更しました! ';
                    $contentEmail = 'ご利用いただき、ありがとうございます。 <br/>';
                    $contentEmail .= '<br/>';
                    $contentEmail .= '下記のURLをクリックして、ログインしてください。 <br/>';
                    $contentEmail .= $linkLogin . '<br/>';
                    $contentEmail .= 'どうも有難う御座います。';

                    sendMail($email, $subject, $contentEmail);
                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', 'システム障害、後で戻ってください。 Sorry ');
                    setFlashData('msg-type', 'danger');
                }
            } else {
                setFlashData('msg', 'もう一度入力して下さい！');
                setFlashData('msg-type', 'danger');

                setFlashData('error', $error);
                redirect('?module=auth&action=reset&token=' . $token);
            }
        }


        $msg = getFlashData('msg');
        $msgType = getFlashData('msg-type');
        $error = getFlashData('error');

?>

<div class="row text-left">
    <div class="col-6" style="margin: 50px auto; ">

        <h2 class="text-center"><?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : ''; ?></h2>

        <?php getMsg($msg, $msgType);
                ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="">新しい　パスワード</label>
                <input type="password" class="form-control" name="password" placeholder="新しいパスワード入力して下さい..." />
                <?php echo (!empty($error['password'])) ? ' <span class="error">' . reset($error['password']) . '</span>' : false; ?>
            </div>

            <div class="form-group">
                <label for="">確認　パスワード</label>
                <input type="password" class="form-control" name="confirm-password" placeholder="確認パスワード入力して下さい..." />
                <?php echo (!empty($error['confirm-password'])) ? ' <span class="error">' . reset($error['confirm-password']) . '</span>' : false; ?>
            </div>

            <button type="submit" class="btn btn-primary btn-block"> 送信 </button>

            <input type="hidden" name="token" value="<?php echo $token; ?>" />

        </form>

    </div>

</div>
<?php

    } else {
        getMsg('URLの期限を切れました!. <br/> パスワード リセット ページからやり直して下さい. ', 'danger');
    }
} else {
    getMsg('URLの期限を切れました!. <br/> パスワード リセット ページからやり直して下さい. ', 'danger');
}


echo '</div>';
layout('footer-login');