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
    $course_duration = htmlspecialchars($_POST["course_duration"]);
    $course_id = htmlspecialchars($_POST["course_id"]);
    $course_name = htmlspecialchars($_POST["course_name"]);
    $instructor_id = htmlspecialchars($_POST["instructor_id"]);
    $course_description = htmlspecialchars($_POST["course_description"]);
    $starting_time = htmlspecialchars($_POST["starting_time"]);

    if (empty($course_duration) || empty($course_id) || empty($course_name) || empty($instructor_id) || empty($course_description) || empty($starting_time)) {
        $errorMessage = "All the fields are required";
    } else {
        $sql = "UPDATE course SET course_duration=?, course_name=?, instructor_id=?, course_description=?, starting_time=? WHERE course_id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("issssi", $course_duration, $course_name, $instructor_id, $course_description, $starting_time, $course_id);
        if ($stmt->execute()) {
            $successMessage = "Course updated successfully";
            header("location: /LMS/admin/admincourses.php");
            exit;
        } else {
            $errorMessage = "Error updating course: " . $stmt->error;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /LMS/admin/index.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM course WHERE course_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row) {
        header("location: /LMS/admin/admincourses.php");
        exit;
    }

    $course_duration = $row["course_duration"];
    $course_id = $row["course_id"];
    $course_name = $row["course_name"];
    $instructor_id = $row["instructor_id"];
    $course_description = $row["course_description"];
    $starting_time = $row["starting_time"];

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
        <h2>Edit Course</h2>

        <?php if (!empty($errorMessage)) : ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type = "hidden" name = "course_id" value = "<?php echo $course_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Course Duration</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course_duration" value="<?php echo $course_duration ?>" >
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Course  ID</label>
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
                    <a class="btn btn-outline-primary" href="/LMS/admin/admincourses.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>