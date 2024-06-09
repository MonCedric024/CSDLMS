<?php
// Include necessary files, initialize database connection, etc.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(16)); // You can use any method to generate a token

    // Store the token in the database, associate it with the user's email

    // Send email with reset link
    $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
    $to = $email;
    $subject = "Password Reset Link";
    $message = "Click the following link to reset your password: $reset_link";
    $headers = "From: your@example.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Reset link sent successfully. Please check your email.";
    } else {
        echo "Error sending reset link.";
    }
}
?>
