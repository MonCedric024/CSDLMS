<?php
include('connect.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (isset($_POST['fullname']) && isset($_POST['contact_no']) && isset($_POST['address']) && isset($_POST['email_id']) && isset($_POST['student_id']) && isset($_POST['dob']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['category'])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $verify_token = md5(rand());

    $sql = mysqli_query($conn, "SELECT * FROM student WHERE email_id = '$email_id'");
    if (mysqli_num_rows($sql) > 0) {
        echo '<script>alert("Email Already Exists");</script>';
        echo "<script>location.replace('student_register.php')</script>";
        exit;
    } else {

        $query = "INSERT INTO student (name, contactno, address, email_id, dob, password, gender, student_id, verify_token, course) VALUES ('$fullname', '$contact_no', '$address', '$email_id', '$dob', '$password', '$gender', '$student_id', '$verify_token', '$category')";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            // Get the last inserted ID
            $last_insert_id = mysqli_insert_id($conn);

            // Send verification email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'qcujournal@gmail.com';
                $mail->Password = 'txtprxrytyqmloth';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('from@example.com', 'Your Name');
                $mail->addAddress($email_id, $fullname); 

                $mail->isHTML(true); 
                $mail->Subject = 'Verify Your Email Address';
                $mail->Body    = 'Please click the following link to verify your email address: <a href="http://localhost/CSDLMS/verify.php?id='.$last_insert_id.'">Verify Email</a>';

                $mail->send();
                echo '<script>alert("Registration Successful. Verification email sent.");</script>';
                echo "<script>location.replace('index.php')</script>";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            die("Couldn't Perform Query: " . mysqli_error($conn));
        }
    }
}
unset($_POST);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/stdRegistration.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<style>
    .centered-div {
        text-align: center;   
    }
    .centered-div a {
        display: inline-block;
        text-decoration: none;
        color: black;
    }
</style>

<body>
    <form action="student_register.php" method="POST">
        <h1>Student Registration</h1>
        <img src="CSD.png" alt="Logo" class="logo">
        <div>
            <label for="student_id">Student ID</label>
            <input type="text" name="student_id" id="student_id" placeholder="Enter Student ID" required maxlength="50" onkeyup="capitalizeInput('student_id')">
            <span id="student_id_error" style="color: red;"></span>
        </div>
        <div>
            <label for="name">Full Name</label>
            <input type="text" name="fullname" id="fullname" placeholder="Enter Fullname (Lastname, Firstname M.I)" onkeyup="capitalizeInput('fullname')" oninput="this.value = this.value.replace(/[^A-Za-z ,.]/g, '');" maxlength="50" required>
            <span id="fullname_error" style="color: red;"></span>
        </div>
        <div>
            <label for="category">Course</label>
            <select name="category" id="category" required>
                <option value="select">Select course</option>
                <option value="bsis">BSIS</option>
                <option value="bsit">BSIT</option>
                <option value="bscs">BSCS</option>
                <option value="bsemc">BSEMC</option>
            </select>
            <span id="category_error" style="color: red;"></span>
        </div>
        <div>
            <label for="contact">Contact Number</label>
            <input type="text" name="contact_no" id="contact_no" placeholder="Enter Contact No." oninput="formatContactNo()" maxlength="12" required>
            <span id="contact_no_error" style="color: red;"></span>
        </div>
        <div>
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="Enter Address" maxlength="100" required>
            <span id="address_error" style="color: red;"></span>
        </div>
        <div>
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" placeholder="Enter Date of Birth" required>
            <span id="dob_error" style="color: red;"></span>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email_id" id="email_id" placeholder="Enter Email" maxlength="50" required>
            <span id="email_id_error" style="color: red;"></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password" maxlength="20" required onkeyup="checkPasswordStrength(this.value)">
            <span id="password_error" style="color: red;"></span>
            <span id="password_length_indicator" style="color: blue;"></span>
        </div>
        <div class="gender-selection">
            <label for="gender">Select Your Gender</label>
            <input type="radio" id="male" name="gender" value="Male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female" required>
            <label for="female">Female</label>
            <span id="gender_error" style="color: red;"></span>
        </div>
        <div>
            <input type="submit" value="Register" name="register" onclick="return validateForm()">
        </div>
        <br>
        <div class="centered-div">
            <a href="signup.php">Back</a>
        </div>
    </form>

    <script src="stdRegisterss.js"></script>
</body>

</html>
