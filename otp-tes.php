<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mbkmpolibatam24@gmail.com';                     //SMTP username
    $mail->Password   = 'adgklbdmqywplolz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Ridho MBKM Polibatam2t5');   
    $mail->addAddress('sridho254@gmail.com', 'User');     //Add a recipient
    $mail->addReplyTo('no-reply@example.com', 'Information');
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $email_template = "
                <h2> Kamu Telah Melakukan Pendaftaran MBKM POLIBATAM </h2>
                <h4> Verifikasi Email Anda Agar Dapat Login, Klik Tautan Berikut ! </h4>
                <a href='#'> [ Klik Disinii ] </a>
    ";
    $mail->Subject = 'Verifikasi Email MBKM POLIBATAM';
    $mail->Body    = $email_template;

    $mail->send();
    echo 'Email Terkirim';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}