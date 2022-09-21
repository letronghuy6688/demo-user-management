<?php

// file đăng nhập 
if (!defined('_INCODE')) die('Access Deined....');

$data = [
    'pageTile' => 'ログイン ページ'
];

layout('header-login', $data);

// check Login Status
if (isLogin()) {
    redirect('?module=user');
}

if (isPost()) {
    $body = getBody();

    $error = [];

    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        $email = $body['email'];
        $password = $body['password'];

        // user information = email
        $userQuery = firstRaw("SELECT id, password FROM user WHERE email ='$email' AND status=1");

        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];

            // check password and password hash in database
            if (password_verify($password, $passwordHash)) {

                $tokenLogin = sha1(uniqid() . time());

                $data_updateLoginToken = [
                    'userID' => $userId,
                    'token' => $tokenLogin,
                    'reateAt' => date('Y-m-d H:i:s')
                ];

                $insertTokenStatus = insert('login_token', $data_updateLoginToken);

                if ($insertTokenStatus) {
                    // save  session 
                    setSession('logintoken', $tokenLogin);
                    redirect('?module=user');
                } else {
                    setFlashData('msg', 'システム障害、後で戻ってください。 Sorry ');
                    setFlashData('msg-type', 'danger');
                }
            } else {
                setFlashData('msg', 'パスワード間違えました. もう一度入力して下さい。');
                setFlashData('msg-type', 'danger');
            }
        } else {
            setFlashData('msg', 'メールアドレス　未登録です！　あるいはアクティブ化されていません！');
            setFlashData('msg-type', 'danger');
        }
    } else {
        setFlashData('msg', '入力してください');
        setFlashData('msg-type', 'danger');
    }

    redirect('?module=auth&action=login');
}


$msg = getFlashData('msg');
$msgType = getFlashData('msg-type');


?>
<div class="row-login">
    <div class="col-6" style="margin: 60px auto; ">

        <h2 class="text-center"><?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : ''; ?></h2>

        <?php getMsg($msg, $msgType); ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="">メールアドレス</label>
                <input type="text" class="form-control" name="email" placeholder="メールアドレス入力して下さい..." />
            </div>

            <div class="form-group">
                <label for="">パスワード</label>
                <input type="password" class="form-control" name="password" placeholder="パスワード入力して下さい..." />
            </div>

            <button type="submit" class="btn btn-primary btn-block"> ログイン </button>

            <hr />
            <p class="text-center"><a href="?module=auth&action=forgot">パスワード忘れた!</a></p>
            <p class="text-center"><a href="?module=auth&action=register"> 新規登録　</a></p>


        </form>

    </div>

</div>
<?php

layout('footer-login');