<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);

$course_duration = "";
$course_id = "";
$course_name = "";
$instructor_id = "";
$course_description = "";
$starting_time = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $course_duration = $_POST["course_duration"];
    $course_id = $_POST["course_id"];
    $course_name = $_POST["course_name"];
    $instructor_id = $_POST["instructor_id"];
    $course_description = $_POST["course_description"];
    $starting_time = $_POST["starting_time"];


    if (empty($course_duration) || empty($course_id) || empty($course_name) || empty($instructor_id) || empty($course_description) || empty($starting_time)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "INSERT INTO course (course_duration, course_id, course_name, instructor_id, course_description, starting_time) " . 
               "VALUES ('$course_duration', '$course_id', '$course_name', '$instructor_id', '$course_description', '$starting_time')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $successMessage = "Added Successfully";
            header("location: /LMS/admin/admincourses.php");
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
        <h2>Insert Course</h2>

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
                <label class="col-sm-3 col-form-label">Course Duration</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course_duration" value="<?php echo $course_duration ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Course ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course_id" value="<?php echo $course_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Course Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course_name" value="<?php echo $course_name ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Instructor ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="instructor_id" value="<?php echo $instructor_id ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Course Description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course_description" value="<?php echo $course_description ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Starting Time</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="starting_time" value="<?php echo $starting_time ?>" >
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
                    <a class="btn btn-outline-primary" href="admincourses.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>