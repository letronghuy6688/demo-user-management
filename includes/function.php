<?php
if (!defined('_INCODE')) die('Access Deined....');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layout($layoutName = 'header', $data = [])
{
    if (file_exists(_WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATE . '/layout/' . $layoutName . '.php';
    }
}

function sendMail($to, $subject, $content)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lenguyentronghuy6688@gmail.com';                     //SMTP username
        $mail->Password   = 'dktqieynhwsuikjt';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('lenguyentronghuy6688@gmail.com', 'user_management demo product');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML


        $mail->CharSet = 'UTF-8'; // set utf8 cho email gửi đi 
        $mail->Subject = $subject;
        $mail->Body    = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // hiển thị nội dung này khi mạng yếu 


        $mail->SMTPOptions = array(   //fix error sendMail 
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// check post 
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// check get 
function isGet()
{

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// lấy dữ liệu  POST, GET 
function getBody()
{
    $BodyArr = [];

    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $values) {
                $key = strip_tags($key);

                if (is_array($values)) {
                    $BodyArr[$key] =  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // chấp nhận input array 

                } else {
                    $BodyArr[$key] =  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS); // loại bỏ ký tự đặc biết 
                }
            }
        }
    }

    if (isPost()) {

        if (!empty($_POST)) {
            foreach ($_POST as $key => $values) {
                $key = strip_tags($key);

                if (is_array($values)) {
                    $BodyArr[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY); // chấp nhận input array 

                } else {
                    $BodyArr[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $BodyArr;
}

// check email 
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

// check number 
function isNumberInt($number, $range = [])
{
    if (!empty($range)) {
        $option = ['option' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $option);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}

// check float 
function isNumberFloat($number, $range = [])
{ // range = ['min_range' => 1, 'max_range' => 10]

    if (!empty($range)) {
        $option = ['option' => $range];

        $checkNumberFloat = filter_var($number, FILTER_VALIDATE_FLOAT, $option);
    } else {
        $checkNumberFloat = filter_var($number, FILTER_VALIDATE_FLOAT);
    }

    return $checkNumberFloat;
}

// check phone 
function isPhone($phone)
{
    $checkFistZero = false;
    if ($phone[0] == 0) {
        $checkFistZero = true;
        $phone = substr($phone, 1);
    }
    $checkNumberLast = false;

    if (isNumberInt($phone) && strlen($phone) == 10) {
        $checkNumberLast = true;
    }

    if ($checkFistZero && $checkNumberLast) {
        return true;
    }

    return false;
}

// output error message
function getMsg($msg, $type = 'success')
{
    if (!empty($msg)) {
        echo '<div class="alert alert-' . $type . '">';
        echo $msg;
        echo '</div>';
    }
}

// // hàm chuyển hướng 
function redirect($path = 'index.php')
{
    header("location: $path");
    exit;
}

// output error requets
function form_error($fieldName, $error, $beforeHtml, $afterHtml)
{
    return (!empty($error[$fieldName])) ? $beforeHtml . reset($error[$fieldName]) . $afterHtml : false;
}

//hàm hiển thị dữ liệu cũ.. 
function old($fieldName, $oldDatabse, $default = null)
{

    return (!empty($oldDatabse[$fieldName])) ? $oldDatabse[$fieldName] : $default;
}

// check login 
function isLogin()
{
    $checkLogin = false;
    if (getSession('logintoken')) {
        $tokenLogin = getSession('logintoken');
        $queryToken = firstRaw("SELECT userID FROM login_token WHERE token= '$tokenLogin'");
        if (!empty($queryToken)) {
            $checkLogin = true;
        } else {
            removeSession('logintoken');
        }
    }

    return $checkLogin;
}