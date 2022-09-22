<?php
if (!defined('_INCODE')) die('Access Deined....');

autoLogout(); //　１５分後　自動ログアウト

saveActivity(); // 最後　稼働


//check Login Status
if (!isLogin()) {

    $user = isLogin()['userID'];


    redirect('?module=auth&action=login');
}


?>

<html>

<head>
    <title> ユーザー　運営　ホームページ</title>
    <meta charset="UTF-8">

    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet"
        href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css?ver=<?php echo rand(); ?>">
    <link type="text/css" rel="stylesheet"
        href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>">
</head>

<body>
    <header>
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo _WEB_HOST_ROOT . '?module=user'; ?>">Home <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Contact<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown profile ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                Hi, xin chao
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">プロファイル</a>
                                <a class="dropdown-item" href="#">設定</a>
                                <a class="dropdown-item"
                                    href="<?php echo _WEB_HOST_ROOT . '?module=auth&action=logout'; ?>">ログアウト</a>
                            </div>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
    </header>