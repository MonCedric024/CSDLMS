<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>CSD-Learning Management System</title>

    <link rel="stylesheet" href="CSS/stdRegistration.css">

</head>
<body>

<form id="validateForm" method="POST">
        <h1 style="text-align: center;">Instructor Registration</h1>
        <img src="CSD.png" alt="Logo" class="logo">
        <div>
            <label for="name">Full Name </label>
            <input type="text" placeholder="Enter your Full Name" name="fullname" id="fullname" oninput="this.value = this.value.replace(/[^A-Za-z ,.]/g, '');" maxlength="20">
            <span id="fullname_error" style="color: red;"></span>
        </div>
        <div>
            <label for="contact_no">Enter Contact Number</label>
            <input type="text" placeholder="Enter your Contact No." name="contact_no" id="contact_no" oninput="formatContactNo()" maxlength="12" required>
            <span id="contact_no_error" style="color: red;"></span>
        </div>
        <div>
            <label for="studend_id">Instructor ID </label>
            <input type="number" placeholder="Enter your Instructor ID" name="instructor_id" id="instructor_id" required>
            <span id="instructor_id_error" style="color: red;"></span>
        </div>
        <div>
            <label for="email">Email </label>
            <input type="email" placeholder="Enter your Email" name="email_id" id="email_id" required>
            <span id="email_id_error" style="color: red;"></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" placeholder="Enter your Password" name="password" id="password" required>
            <span id="password_error" style="color: red;"></span>
        </div>
        <br>
        <div>
            <input type="submit" value="Register" name="register" onclick="return validateForm()">
        </div>
        <br>
        <div style="text-align: center; color:black;">
            <a href="index.php" style="color: black; text-decoration:none;">Home</a>
        </div>
    </form>


    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    include('connect.php');
    if (isset($_POST['fullname']) && isset($_POST['contact_no']) && isset($_POST['email_id']) && isset($_POST['instructor_id']) && isset($_POST['password'])) {
        $fullname =  $_POST['fullname'];
        $contact_no =  $_POST['contact_no'];
        $email_id =  $_POST['email_id'];
        $instructor_id =  $_POST['instructor_id'];
        $password =  $_POST['password'];
        $sql = mysqli_query($conn, "select* from instructor where email_id = '$email_id'");

        if (mysqli_num_rows($sql)) {
            echo '<script>alert("Email Already Exists");</script>';
            exit;
        } else {

            $query = "INSERT INTO instructor (contact_no, instructor_name, email_id, instructor_id, password) VALUES ('$contact_no', '$fullname', '$email_id', '$instructor_id', '$password')";
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
    <script src="instructorRegister.js"></script>
</body>
</html>
