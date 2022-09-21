<?php
if (!defined('_INCODE')) die('Access Deined....');


autoLogout(); //　１５分後　自動ログアウト
?>

<html>

<head>
    <title> <?php echo (!empty($data['pageTile'])) ? $data['pageTile'] : ''; ?></title>
    <meta charset="UTF-8">

    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet"
        href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>">
</head>

<body>