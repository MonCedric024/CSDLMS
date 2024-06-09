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
    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        $filename = $file['name'];
        $fileTempName = $file['tmp_name'];
        $filesize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $fileExt = explode('.', $filename);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'mp4','ppt');
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($filesize < 10000000) {
                    $filenamenew = uniqid('', true) . "." . $fileActualExt;
                    $filedestination = 'uploads/' . $filenamenew;
                    move_uploaded_file($fileTempName, $filedestination);
                    // echo 'File Uploaded Successfully';
                    $course_id = $_SESSION['course_id'];
                    $instructor_id = $_SESSION['ins_id'];
                    $filepath = $filedestination;
                    $description = $_POST['description'];
                    $due_time = $_POST['due_time'];
                    // $start_time = 
                    $sql = mysqli_query($conn, "insert into assignment (course_id , instructor_id ,  description , file_path , due_time) values('$course_id' ,'$instructor_id' ,'$description' , '$filepath' , '$due_time')");
                    echo "<script>alert('Uploaded Successfully');</script>";
                    echo "<script>location.replace('new_instructor_profile.php');</script>";
                } else {
                    echo 'File is too large !';
                }
            } else {
                echo 'There was an error uploading the file.';
            }
        } else {
            echo 'File type not allowed';
        }
        // print_r($file);
    }
    ?>
    <a href="new_instructor_profile.php"> Profile Home </a>
</body>

</html>