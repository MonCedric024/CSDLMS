<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);

$contact_no = "";
$instructor_name = "";
$instructor_id = "";
$email_id = "";
$password = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact_no = htmlspecialchars($_POST["contact_no"]);
    $instructor_name = htmlspecialchars($_POST["instructor_name"]);
    $instructor_id = htmlspecialchars($_POST["instructor_id"]);
    $email_id = htmlspecialchars($_POST["email_id"]);
    $password = htmlspecialchars($_POST["password"]);

    if (empty($contact_no) || empty($instructor_name) || empty($instructor_id) || empty($email_id) || empty($password)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "UPDATE instructor SET contact_no=?, instructor_name=?, email_id=?, password=? WHERE instructor_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $contact_no, $instructor_name, $email_id, $password, $instructor_id);
        if ($stmt->execute()) {
            $successMessage = "Instructor updated successfully";
            header("location: ../admin/admininstructor.php");
            exit;
        } else {
            $errorMessage = "Error updating Instructor: " . $stmt->error;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: ../admin/index.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM instructor WHERE instructor_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row) {
        header("location: ../admin2/admininstructor.php");
        exit;
    }

    $contact_no = $row["contact_no"];
    $instructor_name = $row["instructor_name"];
    $instructor_id = $row["instructor_id"];
    $email_id = $row["email_id"];
    $password = $row["password"]; 

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
        <h2>Edit Student</h2>

        <?php if (!empty($errorMessage)) : ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type = "hidden" name = "course_id" value = "<?php echo $course_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_no" value="<?php echo $contact_no ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Instructor Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="instructor_name" value="<?php echo $instructor_name ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Instructor ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="instructor_id" value="<?php echo $instructor_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email_id" value="<?php echo $email_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="password" value="<?php echo $password ?>" >
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
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../admin/admininstructor.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>