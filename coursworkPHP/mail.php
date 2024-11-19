<?php
$title = $_POST['title'];
$message = $_POST['message'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer();
try {
    //Sender
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'duylnvgcd220076@fpt.edu.vn';
    $mail->Password = 'aety tlog kaso nsos'; // Make sure this is your correct app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    //Recipient
    $mail->addAddress('lenguyenvuduy123456@gmail.com');
    // Content
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body    = $message;
    //Send mail
    $mail->send();
    echo 'Message has been sent';
    header('Location: support.php');
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}