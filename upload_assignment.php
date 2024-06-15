<?php
include('connect.php');
session_start();
print_r($_SESSION);
print_r($_POST);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Learning Management System</title>

</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        include('connect.php');
        session_start();

        $course_id = $_SESSION['course_id'];
        $instructor_id = $_SESSION['ins_id'];
        $description = $_POST['description'];
        $section = $_POST['section'];
        $subject = $_POST['subject'];
        $due_time = $_POST['due_time'];

        $files = $_FILES['files'];
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'mp4', 'ppt');
        $upload_directory = 'uploads/';

        // Insert assignment information
        $sql_assignment = "INSERT INTO assignment (course_id, instructor_id, description, section, subject, due_time) VALUES ('$course_id', '$instructor_id', '$description', '$section', '$subject', '$due_time')";
        if (mysqli_query($conn, $sql_assignment)) {
            $last_insert_id = mysqli_insert_id($conn); // Get the last inserted assignment ID

            // Process each uploaded file
            foreach ($files['name'] as $key => $filename) {
                $fileTmpName = $files['tmp_name'][$key];
                $fileSize = $files['size'][$key];
                $fileError = $files['error'][$key];
                $fileType = $files['type'][$key];

                $fileExt = explode('.', $filename);
                $fileActualExt = strtolower(end($fileExt));

                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 10000000) {
                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = $upload_directory . $fileNewName;
                            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                                // Insert file information into database
                                $sql_file = "INSERT INTO assignment_files (assignment_id, file_path) VALUES ('$last_insert_id', '$fileDestination')";
                                if (mysqli_query($conn, $sql_file)) {
                                } else {
                                    echo "<script>alert('Error uploading file to database');</script>";
                                }
                            } else {
                                echo "<script>alert('Error moving uploaded file');</script>";
                            }
                        } else {
                            echo "<script>alert('File is too large');</script>";
                        }
                    } else {
                        echo "<script>alert('Error uploading file');</script>";
                    }
                } else {
                    echo "<script>alert('File type not allowed');</script>";
                }
            }
            echo "<script>alert('Assignment uploaded successfully');</script>";
            echo "<script>location.replace('new_instructor_profile.php');</script>";
        } else {
            echo "<script>alert('Error inserting assignment');</script>";
            header('Location: new_instructor_profile.php');
            exit();
        }
    } else {
        header('Location: new_instructor_profile.php');
        exit();
    }
    ?>
    <a href="new_instructor_profile.php"> Profile Home </a>
</body>

</html>