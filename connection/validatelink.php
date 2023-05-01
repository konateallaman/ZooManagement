<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['Visitor_registration'])) {
    require_once "./connection/connect.inc.php";
    $Fname = $_POST['CustFname'];
    $Lname = $_POST['CustLname'];
    $Email = $_POST['CustEmail'];
    $Password = $_POST['password'];
    $DOB = $_POST['CustDOB'];
    $Vdate = $_POST['visit_date'];
    $id = mt_rand(100000, 999999);

    if (empty($Fname) || empty($Lname) || empty($Email) || empty($Password) || empty($DOB) || empty($Vdate)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please, fill up all the fields !</h4></div>';
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please enter a valid email address.</h4></div>';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $DOB)) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Please enter a date in the format YYYY-MM-DD.</h4></div>';
    } elseif (strlen($Password) < 8) {
        echo '<div style="background-color:white;"><h4 style="color:red;">Password must be at least 8 characters long.</h4></div>';
    } else {
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO temp_visitors (CustID,CustFname,CustLname,CustEmail,password,CustDOB,visit_date) VALUES(?,?,?,?,?,?,?)";
        if (isset($conn)) {
            $stmt = $conn->prepare($sql);
        }
        $stmt->bind_param("sssssss", $id, $Fname, $Lname, $Email, $hashedPassword, $DOB, $Vdate);
        $result = $stmt->execute();
        if ($result) {
            // Create a validation link with the ID
            $validationLink = "http://zoomanagement.safarihaven.com/validate.php?id=$id";

            // Send the validation link in an email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'konateallamanhamed@gmail.com';
                $mail->Password   = 'escqsezqzbyvuisz';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                
                $mail->setFrom('konateallamanhamed@gmail.com', 'Welcome  to safarihaven !');
                $mail->addAddress($Email, $Fname . ' ' . $Lname);
                
                $mail->isHTML(true);
                $mail->Subject = 'Confirm your registration';
                $mail->Body    = "Please click the following link to confirm your registration: <a href='$validationLink'>$validationLink</a>";
$mail->AltBody = "Please click the following link to confirm your registration: $validationLink";
$mail->send();
echo '<div style="background-color:white;"><h4 style="color:green;">Registration successful! Please check your email to confirm your registration.</h4></div>';
} catch (Exception $e) {
echo '<div style="background-color:white;"><h4 style="color:red;">Registration failed. Please try again later.</h4></div>';
}
} else {
echo '<div style="background-color:white;"><h4 style="color:red;">Registration failed. Please try again later.</h4></div>';
}
}
} else {
header("Location: index.php");
exit();
}
?>
