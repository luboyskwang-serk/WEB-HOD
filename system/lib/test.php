<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = '27.254.96.247';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@yosiket.rest';
    $mail->Password = 'k6CWCsQeEQYmMb6Fvd6W';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ),
    );

    $mail->setFrom('noreply@yosiket.rest', 'Yosiket');
    $mail->addAddress('tunpisittune@gmail.com', 'Customer');

    $mail->isHTML(true);
    $mail->Subject = 'title';
    $mail->Body = 'body';

    $mail->send();
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
