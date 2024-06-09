<?php
include('connect.php');
session_start();
// print_r($_SESSION);
// print_r($_POST);

if (isset($_POST['submit_feedback'])) {
    $course_id = $_SESSION['course_id'];
    $instructor_id = $_SESSION['ins_id'];
    $feedback_id = $_POST['feedback_id'];
    $content = $_POST['description'];

    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO feedback (feedback_id, course_id, instructor_id, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $feedback_id, $course_id, $instructor_id, $content);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Feedback Uploaded Successfully');</script>";
        echo "<script>location.replace('instructor_courses.php')</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}
?>
