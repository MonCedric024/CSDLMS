<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$contact_no = "";
$instructor_id = "";
$email = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST["name"];
    $contact_no = $_POST["contact_no"];
    $instructor_id = $_POST["instructor_id"];
    $email = $_POST["email"];

    if (empty($name) || empty($contact_no) || empty($instructor_id) || empty($email)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "INSERT INTO instructor (instructor_name, contact_no, instructor_id, email_id) " . 
               "VALUES ('$name', '$contact_no', '$instructor_id', '$email')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Added Successfully";
            header("location: /LMS/admin/admininstructor.php");
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
        <h2>Insert Instructor</h2>

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
                    <input type="text" class="form-control" name="contact_no" value="<?php echo $contact_no ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Instructor ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="instructor_id" value="<?php echo $instructor_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email ?>" >
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="admininstructor.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
