<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$contactno = "";
$age = "";
$address = "";
$email_id = "";
$dob = "";
$password = "";
$gender = "";
$student_id = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST["name"];
    $contactno = $_POST["contactno"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $email_id = $_POST["email_id"];
    $dob = $_POST["dob"];
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $student_id = $_POST["student_id"];

    if (empty($name) || empty($contactno) || empty($age) || empty($address) || empty($email_id) || empty($dob) || empty($password) || empty($gender) || empty($student_id)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "INSERT INTO student (name, contactno, age, address, email_id, dob, password, gender, student_id) " . 
               "VALUES ('$name', '$contactno', '$age', '$address', '$email_id', '$dob', '$password', '$gender', '$student_id')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Added Successfully";
            header("location: /LMS/admin/adminstudent.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ADMIN</title>
    <link rel = "stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">    
        <h2>Insert Student</h2>

        <?php
        if (!empty($errorMessage))  {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactno" value="<?php echo $contactno ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="age" value="<?php echo $age ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email_id" value="<?php echo $email_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date of Birth</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="dob" value="<?php echo $dob ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="password" value="<?php echo $password ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender" value="<?php echo $gender ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="student_id" value="<?php echo $student_id ?>" >
                </div>
            </div>

            <?php
        if (!empty($successMessage)) {
            echo "
            <div class='row mb-3'>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                </div>
            </div>";
        }
        ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="adminstudent.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>