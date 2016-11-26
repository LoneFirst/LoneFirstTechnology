<?php
require_once 'vendor/autoload.php';

function sendMail($email,$subject,$body) {
global $send;
$mail = new PHPMailer;

$mail->isSMTP();                 
$mail->CharSet = 'utf-8';
$mail->Encoding = 'base64';
$mail->Host = $send['host']; 
$mail->SMTPAuth = true;
$mail->Username = $send['username'];
$mail->Password = $send['password'];
$mail->SMTPSecure = 'ssl';
$mail->setFrom($send['from']);
$mail->addAddress($email);
$mail->IsHTML(true);
$mail->Subject = $subject;
$mail->Body    = $body;

return $mail->send();
}