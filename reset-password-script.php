<?php
ob_start();
if (isset($_POST['resetPassword'])) {
    $email = $_POST['CustEmail'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if passwords match
    if ($newPassword !== $confirmNewPassword) {
        echo "Error: The new passwords do not match.";
        exit;
    }

    // Connect to database
    require './connection/connect.inc.php';

    // Prepare SQL query to update password
    $stmt = $conn->prepare("UPDATE visitors SET password = ? WHERE CustEmail = ?");

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Bind parameters and execute query
    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // If password reset was successful, redirect to success page
        header("Location: reset-password-success.php");
        exit;
    } else {
        echo "Error: Failed to reset password.";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>a




