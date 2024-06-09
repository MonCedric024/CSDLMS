<?php
include('connect.php');
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/create_courses.css">
</head>

<body>
    <form action="create_course.php" method="POST">
        <h3>Create Subjects</h3>
        <br>
        <div>
            <label for="course_name">Subject Name:</label>
            <input type="text" name="course_name" id="course_name" required>
        </div>
        <div>
            <label for="course_code">Subject Code:</label> <!-- New input for course code -->
            <input type="text" name="course_code" id="course_code" required>
        </div>
        <div>
            <label for="course_description">Subject Description:</label>
            <input type="text" name="course_description" id="course_description" required>
        </div>
        <div>
            <label for="starting_time">Subject Starting Date:</label>
            <input type="date" name="starting_time" id="starting_time" required>
        </div>
        <div style="display: none;">
            <label for="course_id">Course ID:</label>
            <input type="text" name="course_id" id="course_id" value="<?php echo rand(100000, 999999); ?>" required readonly>
        </div>
        <div>
            <input type="submit" name="create" value="Create">
        </div>
        <div class="navigation">
            <div class="navigation-buttons">
                <a href="new_instructor_profile.php" class="button">BACK</a>
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST['course_name']) && isset($_POST['course_description']) && isset($_POST['starting_time']) && isset($_POST['course_id']) && isset($_POST['course_code'])) {
        try {
            $course_name =  $_POST['course_name'];
            $course_code =  $_POST['course_code']; // Added new field value
            $course_description =  $_POST['course_description'];
            
            $starting_time = $_POST['starting_time'];
            $course_id = $_POST['course_id'];
            $int_id = $_SESSION['ins_id'];

            $sql = mysqli_query($conn, "select* from course where course_id = '$course_id' OR course_code = '$course_code'");
            if (mysqli_num_rows($sql) > 0) {
                echo '<div style="color: red; padding-left:630px;">Course Already Exists with this ID or Code</div>';
                exit;
            } else {
                $query = "INSERT INTO course (course_duration, course_id, course_name, instructor_id, course_description, starting_time, course_code) 
                VALUES ('$course_duration', '$course_id', '$course_name', '$int_id', '$course_description', '$starting_time', '$course_code')";
                $sql = mysqli_query($conn, $query) or die("Couldn't Perform Query");
            }
            echo '<script>alert("Course Created");</script>';
            echo "<script>location.replace('new_instructor_profile.php')</script>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ?>

    <br>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>
</body>
</html>
