<?php
if (!defined('_INCODE')) die('Access Deined....');

$data = [
    'pageTile' => ' ユーザー 追加'
];

layout('header', $data);

// old database
$body = getBody();

if (!empty($body['id'])) {
    $userId = $body['id'];


    $userDetail = firstRaw("SELECT * FROM user WHERE id='$userId'");

    if ($userDetail) {
        setFlashData('userDetail', $userDetail);
    } else {
        redirect('?module=user');
    }
} else {
    redirect('?module=user');
}

// validate form 
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
            $sql = "SELECT id FROM user WHERE email='$email' AND id<>$userId";

            if (getRows($sql) > 0) {
                $error['email']['unique'] = 'このメールに存在しています！　他のメールを入力して下さい。';
            }
        }
    }


    if (!empty(trim($body['password']))) {
        if (empty(trim($body['confirm-password']))) {
            $error['confirm-password']['required'] = '確認パスワード入力して下さい。';
        } else {
            if (trim($body['password']) != trim($body['confirm-password'])) {
                $error['confirm-password']['match'] = '再入力して下さい';
            }
        }
    }


    if (empty($error)) {

        $dataUpdate = [
            'fullname' => $body['fullname'],
            'phone' => $body['phone'],
            'email' => $body['email'],
            'status' => $body['status'],
            'updateAt' => date('Y-m-d H:i:s')
        ];

        if (!empty(trim($body['password']))) {
            $dataUpdate['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
        }

        $condition = 'id=' . $userId;
        $Update = updateData('user', $dataUpdate, $condition);

        if ($Update) {
            setFlashData('msg', '修正できました！');
            setFlashData('msg-type', 'success');
            redirect('?module=user');
        } else {
            setFlashData('msg', 'エラー');
            setFlashData('msg-type', 'danger');
            redirect('?module=user');
        }
    } else {
        setFlashData('msg', 'もう一度確認してください。');
        setFlashData('msg-type', 'danger');

        setFlashData('error', $error);
        setFlashData('old', $body);
        redirect('?module=user&action=edit&id=' . $userId);
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg-type');
$error = getFlashData('error');

$old = getFlashData('old');

$userDetail = getFlashData('userDetail');
if (!empty($userDetail)) {
    $old = $userDetail;
}

?>

<div class="container">
    <hr />
    <h3 class="text-center"><?php echo  $data['pageTile']; ?></h3>
    <form action="" method="post">
        <div class="row">

            <div class="col">
                <div class="form-group">
                    <label for="">名前</label>
                    <input type="text" class="form-control" name="fullname" placeholder="名前入力して下さい..."
                        value="<?php echo (!empty($old['fullname'])) ? $old['fullname'] : null ?>" />
                    <?php echo (!empty($error['fullname'])) ? ' <span class="error">' . reset($error['fullname']) . '</span>' : false ?>
                </div>
                <div class="form-group">
                    <label for="">電話番号</label>
                    <input type="text" class="form-control" name="phone" placeholder="電話番号入力して下さい..."
                        value="<?php echo (!empty($old['phone'])) ? $old['phone'] : null ?>" />
                    <?php echo (!empty($error['phone'])) ? ' <span class="error">' . reset($error['phone']) . '</span>' : false ?>
                </div>
                <div class="form-group">
                    <label for="">メールアドレス</label>
                    <input type="text" class="form-control" name="email" placeholder="メール入力して下さい..."
                        value="<?php echo (!empty($old['email'])) ? $old['email'] : null ?>" />
                    <?php echo (!empty($error['email'])) ? ' <span class="error">' . reset($error['email']) . '</span>' : false ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="">パスワード</label>
                    <input type="password" class="form-control" name="password" placeholder="パスワード入力して下さい..." />
                    <?php echo (!empty($error['password'])) ? ' <span class="error">' . reset($error['password']) . '</span>' : false ?>
                </div>
                <div class="form-group">
                    <label for="">確認　パスワード</label>
                    <input type="password" class="form-control" name="confirm-password"
                        placeholder="確認　パスワード入力して下さい..." />
                    <?php echo (!empty($error['confirm-password'])) ? ' <span class="error">' . reset($error['confirm-password']) . '</span>' : false ?>

                </div>
                <div class="form-group">
                    <label for="">状態　選択</label>
                    <select class="form-control" name="status">
                        <option value="0" <?php echo (old('status', $old) == 0) ? 'selected' : false ?>>Offline</option>
                        <option value="1" <?php echo (old('status', $old) == 1) ? 'selected' : false ?>>Online</option>
                    </select>
                </div>
            </div>

        </div>
        <hr />
        <button type="submit" class="btn  btn-primary"> 保存 </button>
        <a href="?module=user" class="btn btn-success"> 戻す </a>
        <input type="hidden" name="id" value="<?php echo $userId; ?>" />

    </form>
</div>

<?php

layout('footer');