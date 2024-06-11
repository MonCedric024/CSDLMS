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
$user_password = ""; // Renamed to avoid conflict
$gender = "";
$student_id = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST["name"]);
    $contactno = htmlspecialchars($_POST["contactno"]);
    $age = htmlspecialchars($_POST["age"]);
    $address = htmlspecialchars($_POST["address"]);
    $email_id = htmlspecialchars($_POST["email_id"]);
    $dob = htmlspecialchars($_POST["dob"]);
    $password = htmlspecialchars($_POST["password"]); // Renamed to avoid conflict
    $gender = htmlspecialchars($_POST["gender"]);
    $student_id = htmlspecialchars($_POST["student_id"]);

    if (empty($name) || empty($contactno) || empty($age) || empty($address) || empty($email_id) || empty($dob) || empty($password) || empty($gender) || empty($student_id)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "UPDATE student SET name=?, contactno=?, age=?, address=?, email_id=?, dob=?, password=?, gender=? WHERE student_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssisssssi", $name, $contactno, $age, $address, $email_id, $dob, $password, $gender, $student_id);
        if ($stmt->execute()) {
            $successMessage = "Student updated successfully";
            header("location: ../admin/adminstudent.php");
            exit;
        } else {
            $errorMessage = "Error updating student: " . $stmt->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: ../admin/index.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM student WHERE student_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row) {
        header("location: ../admin2/adminstudent.php");
        exit;
    }

    $name = $row["name"];
    $contactno = $row["contactno"];
    $age = $row["age"];
    $address = $row["address"];
    $email_id = $row["email_id"];
    $dob = $row["dob"];
    $password = $row["password"]; 
    $gender = $row["gender"];
    $student_id = $row["student_id"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>ADMIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        function validatePhoneNumber(input) {
            const phoneNumber = input.value.trim();
            const phoneNumberPattern = /^09\d{9}$/; // Phone number must start with "09" and be exactly 11 digits

            if (!phoneNumberPattern.test(phoneNumber)) {
                alert("Invalid phone number. Please enter a valid phone number starting with '09' and containing only digits.");
                input.value = "";
                input.focus();
            }
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Student</h2>
        <?php if (!empty($errorMessage)) : ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contactno" value="<?php echo $contactno ?>" onblur="validatePhoneNumber(this)">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Age</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="age" value="<?php echo $age ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email_id" value="<?php echo $email_id ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date of Birth</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="dob" value="<?php echo $dob ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="password" value="<?php echo $password ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender" value="<?php echo $gender ?>">
                </div>
            </div>
            <?php if (!empty($successMessage)) : ?>
                <div class='row mb-3'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong><?php echo $successMessage; ?></strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../admin/adminstudent.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
