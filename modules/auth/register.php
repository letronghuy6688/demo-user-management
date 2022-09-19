<?php

// file đăng ký tài khoản
if (!defined('_INCODE')) die('Access Deined....');
$data = [
    'pageTile' => '新規登録'
];
layout('header-login', $data);

if (isPost()) {
    $body = getBody();
    $error = [];

    if (empty(trim($body['fullname']))) {
        $error['fullname']['required'] = '名前入力して下さい!';
    } else {
        if (mb_strlen(trim($body['fullname'])) < 5) {
            $error['fullname']['min'] = 'ローマ字で入力して下さい!';
        }
    }

    if (empty(trim($body['phone']))) {
        $error['phone']['required'] = '電話番号入力して下さい。';
    } else {
        if (!isPhone(trim($body['phone']))) {
            $error['phone']['isPhone'] = '電話番号が間違いました！　もう一度確認してください。';
        }
    }

    if (empty(trim($body['email']))) {
        $error['email']['required'] = 'メール入力して下さい。';
    } else {
        if (!isEmail(trim($body['email']))) {
            $error['email']['isEmail'] = 'メール　間違いました!';
        } else {
            $email = trim($body['email']);
            $sql = "SELECT id FROM user WHERE email='$email'";

            if (getRows($sql) > 0) {
                $error['email']['unique'] = 'このメールに存在しています！　他のメールを入力して下さい。';
            }
        }
    }

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
        $activeToken = sha1(uniqid() . time());

        $dataInsert = [
            'email' => $body['email'],
            'fullname' => $body['fullname'],
            'phone' => $body['phone'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'createAt' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('user', $dataInsert);

        if ($insertStatus) {

            $linkactiveToken = _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $activeToken;
            $subject = ' 【重要】会員登録の手続きを完了してください! ';
            $contentEmail = 'ご利用いただき、ありがとうございます。 <br/>';
            $contentEmail .= '下記のURLをクリックして、会員登録の手続きを完了してください。 <br/>';
            $contentEmail .= '<br/>';
            $contentEmail .= ' ▼ 会員登録の手続きを完了する <br/>';
            $contentEmail .= $linkactiveToken . '<br/>';
            $contentEmail .= 'どうも有難う御座います。';

            $sendmail =  sendMail($body['email'], $subject, $contentEmail);

            if ($sendmail) {
                setFlashData('msg', '登録完了しました！ メール確認してください。');
                setFlashData('msg-type', 'success');
            } else {
                setFlashData('msg', 'システム障害、後で戻ってください。 Sorry ');
                setFlashData('msg-type', 'danger');
            }
            redirect('?module=auth&action=register');
        }
    } else {
        setFlashData('msg', 'もう一度確認してください。');
        setFlashData('msg-type', 'danger');

        setFlashData('error', $error);
        setFlashData('old', $body);
        redirect('?module=auth&action=register');
    }
}



$msg = getFlashData('msg');
$msgType = getFlashData('msg-type');
$error = getFlashData('error');

// dữ lại thông tin vừa nhập vào 
$old = getFlashData('old');

?>

<div class="row-register">
    <div class="col-6" style="margin: 0px auto; ">

        <h2 class="text-center"><?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : false; ?> </h2>

        <?php
        getMsg($msg, $msgType);
        ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="">名前</label>
                <input type="text" class="form-control" name="fullname" placeholder="名前入力して下さい..."
                    value="<?php echo (!empty($old['fullname'])) ? $old['fullname'] : null; ?>" />
                <?php echo (!empty($error['fullname'])) ? ' <span class="error">' . reset($error['fullname']) . '</span>' : false; ?>

            </div>

            <div class="form-group">
                <label for="">電話番号</label>
                <input type="text" class="form-control" name="phone" placeholder="07x-xxxx-xxxx"
                    value="<?php echo old('phone', $old); ?>" />
                <?php echo form_error('phone', $error, '<span class="error">', '</span>'); ?>

            </div>

            <div class="form-group">
                <label for="">メールアドレス</label>
                <input type="text" class="form-control" name="email" placeholder="メールアドレス入力して下さい..."
                    value="<?php echo (!empty($old['email'])) ? $old['email'] : null; ?>" />
                <?php echo (!empty($error['email'])) ? ' <span class="error">' . reset($error['email']) . '</span>' : false; ?>

            </div>

            <div class="form-group">
                <label for="">パスワード</label>
                <input type="password" class="form-control" name="password" placeholder="パスワード入力して下さい..." />
                <?php echo (!empty($error['password'])) ? ' <span class="error">' . reset($error['password']) . '</span>' : false; ?>

            </div>

            <div class="form-group">
                <label for="">確認　パスワード</label>
                <input type="password" class="form-control" name="confirm-password" placeholder="パスワードもう一度入力して下さい..." />
                <?php echo (!empty($error['confirm-password'])) ? ' <span class="error">' . reset($error['confirm-password']) . '</span>' : false; ?>

            </div>

            <button type="submit" class="btn btn-primary btn-block"> 送信 </button>

            <hr />
            <p class="text-center"><a href="?module=auth&action=forgot">パスワード忘れた!</a></p>
            <p class="text-center"><a href="?module=auth&action=login"> ログイン</a></p>
        </form>

    </div>

</div>

<?php

layout('footer-login');