<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form inputs
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'konateallamanhamed@gmail.com'; // Replace with your email address
    $mail->Password = 'escqsezqzbyvuisz'; // Replace with your email password or app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('konateallamanhamed@gmail.com'); // Replace with your email address

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Send email
    $mail->send();
    $success = "Your message has been sent successfully!";
} catch (Exception $e) {
    $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
?>