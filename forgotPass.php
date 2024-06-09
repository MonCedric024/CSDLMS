<?php
session_start();

include("connect.php");

$error = "";
$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email_id'];
    $password = $_POST['password'];

    $sql1 = "UPDATE student
            SET email_id = ?, password = ?
            WHERE email_id = ?";
            
    $sql2 = "UPDATE instructor
            SET email_id = ?, password = ?
            WHERE email_id = ?";

    if ($stmt = $conn->prepare($sql1)) {
        $stmt->bind_param("sss", $email, $password, $email);
        if ($stmt->execute()) {
            $notification .= "Student information updated successfully. ";
        } else {
            $error = "Error updating student record: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Error preparing student statement: " . $conn->error;
    }

    if ($stmt = $conn->prepare($sql2)) {
        $stmt->bind_param("sss", $email, $password, $email);
        if ($stmt->execute()) {
            $notification .= "Instructor information updated successfully.";
        } else {
            $error .= " Error updating instructor record: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error .= " Error preparing instructor statement: " . $conn->error;
    }

    if (empty($error)) {
        echo '<script>alert("Password Changing is Successful!"); window.location.href = "signup.php?action=add&success=1";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Confirmation Form</title>
<link rel="stylesheet" href="CSS/forgotPass.css">
<script>
function checkPassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
        document.getElementById("passwordWarning").style.display = "block";
    } else {
        document.getElementById("passwordWarning").style.display = "none";
    }
}
</script>
</head>
<body>
<form method="post">
<h1>Forgot Password</h1>
    <img src="CSD.png" alt="Logo" class="logo">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email_id" placeholder="Enter your Email:" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" placeholder="Enter your password:" required><br><br>

    <label for="confirmPassword">Confirm Password:</label><br>
    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password:" required onkeyup="checkPassword();"><br>
    <span id="passwordWarning" style="color: red; display: none;">Passwords do not match!</span><br><br>

    <input type="submit" value="Submit">
    
    <br><br>
        <div style="text-align: center; color:black;">
        <a href="signup.php" style="color: black; text-decoration:none;">Home</a>
    </div>
</form>

</body>
</html>
