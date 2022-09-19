<?php
if (!defined('_INCODE')) die('Access Deined....');

?>

<h2 style="text-align: center "> DATABASE ERROR..

    <p><?php echo $exception->getmessage(); ?></p>
    <p><?php echo $exception->getfile(); ?></p>
    <p><?php echo $exception->getline(); ?></p>


</h2>