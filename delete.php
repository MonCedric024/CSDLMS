<?php
include('connect.php');

if(isset($_POST['submit_delete'])) {
    $course_id = $_POST['cid'];
    
    $delete_query = "DELETE FROM enroll WHERE course_id = '$course_id'";
    $result = mysqli_query($conn, $delete_query);

    if($result) {

        header("Location: mycourse.php");
        exit();
    } else {
        echo "Error deleting course.";
    }
}
?>
