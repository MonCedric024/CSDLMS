<?php
include('connect.php');
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD Learning Management System</title>


    <link rel="stylesheet" href="CSS/signup.css">

    <style>
        .error-input {
            border: 3px solid #cc0000 !important; /* Pula na border */
        }

        .checkbox-container {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<body>
<form action="" method="POST">
        <img src="CSD.png" alt="Logo" class="logo">
<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email_id =  $_POST['email'];
    $password =  $_POST['password'];
    $_SESSION['email'] = $email_id;
    $sql = "select *from instructor where email_id = '$email_id' and password = '$password  and status = 1'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // echo $count;
    if (mysqli_num_rows($result) === 1) {
        $flag = true;
        $_SESSION['name'] = $row['instructor_name'];
        $_SESSION['ins_id'] = $row['instructor_id'];
        unset($row);
        unset($result);
        echo "<script>location.replace('new_instructor_profile.php')</script>";
    } else {
        $sql = "select * from student where email_id = '$email_id' and password = '$password' and status = 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if (mysqli_num_rows($result) === 1) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['student_id'] = $row['student_id'];
            unset($row);
            unset($result);
            echo "<script>location.replace('new_student_profile.php')</script>";
        } else {
            echo "<h1 style='text-align: center; font-size: 20px; color: #cc0000;'>Login failed. Invalid username or password</h1>";
        }
    }
}
?>
    
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="<?php if(isset($_POST['email']) && mysqli_num_rows($result) !== 1) echo 'error-input'; ?>" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" class="<?php if(isset($_POST['password']) && mysqli_num_rows($result) !== 1) echo 'error-input'; ?>" required>
            <div class="checkbox-container">
                <input type="checkbox" id="show-password" onclick="togglePassword()">
                <label for="show-password" style="margin-top: 4px; margin-left: 5px;"> Show Password</label>
            </div>
        </div>

        <div>
            <br>
            <input type="submit" value="Login" name="login">
        </div>
        <p><a href="forgotPass.php" style="color: black; text-decoration:none;">Forgot Password?</a></p>
       
        <br>
        
        <div><a href="student_register.php" class="button"> Register As Student</a></div>
        <div><a href="index.php" class="button"> Home</a></div>
    </form>
    
    <script src= "signup.js"></script>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
