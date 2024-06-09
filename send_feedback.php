<?php
include('connect.php');
session_start();
print_r($_SESSION);
print_r($_POST);
?>
<?php
if (isset($_POST['submit_send'])) {
    $student_id = $_POST['sid'];
    $course_id = $_POST['cid'];
    $feedback_id = $_POST['fid'];
    $answer = $_POST['f_send'];
    $sql2 = mysqli_query($conn, "insert into takes_feedback (answer , student_id , feedback_id ,course_id ,feedback_given ) values('$answer', '$student_id' , '$feedback_id' , '$course_id'  , true)");
    echo "<script>alert('Feedback Sent Successfully');</script>";
    echo "<script>location.replace('student_profile.php')</script>";
}
?>