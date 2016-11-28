<?php
require_once "vendor/autoload.php";

$email = "realsharma.arjun@gmail.com";
$password = "iamrealarjun";
$to_id = "pulkitkumar190@gmail.com";
$message = "Hello ";
$subject = "Hi";
$fromName = "Arjun";
$image = $_POST['barCode'];

// Configuring SMTP server settings
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $email;
$mail->Password = $password;

// Email Sending Details
$mail->addAddress($to_id);
$mail->addAttachment($image);
$mail->Subject = $subject;
$mail->msgHTML($message);
$mail->FromName = $fromName;

$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
// Success or Failure
if (!$mail->send()) {
$error = "Mailer Error: " . $mail->ErrorInfo;
echo '<p id="para">'.$error.'</p>';
}
else {
echo '<p id="para">Message sent!</p>';
}
