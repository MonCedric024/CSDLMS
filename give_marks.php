<?php
include('connect.php');
session_start();
// print_r($_POST);
$sid = $_POST['sid'];
$aid = $_POST['aid'];
$marks = $_POST['marks'];
$sql = mysqli_query($conn, "update submit_assignment set marks='$marks' , if_returned = 1 where student_id = '$sid' and assignment_id = '$aid' ");
    echo "<script>alert('Assignment Returned');</script>";
    echo "<script>location.replace('prev_assignments.php')</script>";
?>