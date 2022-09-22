<?php
if (!defined('_INCODE')) die('Access Deined....');

?>

<html>

<head>
    <title> システム　管理</title>
    <meta charset="UTF-8">

    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet"
        href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>">
</head>

<body>

    <div class="container"
        style="display:flex; align-items: center; flex-direction:column; height: 100vh; justify-content: center;">
        <h2 class="text-center"> システム　管理　</h2>
        <p class="text-center"><a href="?module=user" class="btn btn-success btn-lg">ユーザー　運営 管理</a></p>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/custom.js"></script>
</body>

</html>