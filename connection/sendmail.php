<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //retrieve and sanitize the form data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    //set the recipient email address
    $to = "konateallamanhamed@gmail.com";
    
    //set the email subject
    $subject = "$subject";
   // $subject = "New message from $name: $subject";
    
    //set the email message
    $message = "Name: $name\n\nEmail: $email\n\nMessage:\n$message";
    
    //set the email headers
    $headers = "From: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Mailer: PHP/".phpversion();
    
    //send the email
    if(mail($to, $subject, $message, $headers)){
        $success = "Your message has been sent successfully.";
    }else{
        $error = "There was a problem sending your message. Please try again.";
    }
}

?>
