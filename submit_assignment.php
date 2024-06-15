<?php
include('connect.php');
session_start();

if (isset($_POST['submit'])) {
    // Get form data
    $subject = $_POST['subject'];
    $assignment_id = $_POST['aid'];
    $course_id = $_POST['cid'];
    $student_id = $_POST['student_id'];

    // File details
    $file = $_FILES['file'];
    $filename = $file['name'];
    $fileTempName = $file['tmp_name'];
    $filesize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    $fileExt = pathinfo($filename, PATHINFO_EXTENSION); // Get file extension
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    // Validate file
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($filesize < 10000000) { // 10MB limit
                // Generate unique filename
                $uniqueFilename = uniqid('', true) . "_" . time() . "_" . mt_rand(1000, 9999) . "." . $fileExt;
                $filedestination = 'uploads/' . $uniqueFilename;
                move_uploaded_file($fileTempName, $filedestination);

                // Check if submission already exists
                $check_sql = "SELECT * FROM submit_assignment WHERE student_id = ? AND course_id = ? AND assignment_id = ?";
                $check_stmt = mysqli_prepare($conn, $check_sql);
                mysqli_stmt_bind_param($check_stmt, "iii", $student_id, $course_id, $assignment_id);
                mysqli_stmt_execute($check_stmt);
                $result = mysqli_stmt_get_result($check_stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo "<script>alert('Submission already exists for this assignment.');</script>";
                    echo "<script>window.location.replace('student_assignments.php');</script>";
                } else {
                    // Insert into database
                    $insert_sql = "INSERT INTO submit_assignment (student_id, course_id, assignment_id, submit_file_path) VALUES (?, ?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conn, $insert_sql);
                    mysqli_stmt_bind_param($insert_stmt, "iiis", $student_id, $course_id, $assignment_id, $filedestination);
                    mysqli_stmt_execute($insert_stmt);

                    echo "<script>alert('Uploaded Successfully');</script>";
                    echo "<script>window.location.replace('new_student_assignment.php?subject= $subject');</script>";
                }
            } else {
                echo 'File is too large!';
            }
        } else {
            echo 'There was an Error Uploading The File';
        }
    } else {
        echo 'File Type Not Allowed';
    }
}
?>
