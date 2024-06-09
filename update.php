<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/admin.css">
        
    <title>Password Confirmation Form</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
<?php
session_start();

include("connection.php");

if ($_POST) {
    $email=$_POST['email_id'];
    $password = $_POST['password'];

    $sql = "UPDATE student
    SET email_id = $email , password = $password
    WHERE email_id = $email;"
  
} else {
    $error = '3';
}

header("location: employee.php?action=add&error=" . $error);
?>

    
   

</body>
</html>