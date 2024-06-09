<?php
include('connect.php');
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = mysqli_real_escape_string($conn, $_POST['cid']);
    $subject_code_input = mysqli_real_escape_string($conn, $_POST['course_code']);

    // Fetch the expected course code from the course table
    $query = "SELECT course_code FROM course WHERE course_id = '$course_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $expected_course_code = $row['course_code']; // Correct field name

        if ($expected_course_code === $subject_code_input) {
            // If the course code matches, proceed with enrollment
            $enroll_query = "INSERT INTO enroll (student_id, course_id) VALUES ('$student_id', '$course_id')";
            if (mysqli_query($conn, $enroll_query)) {
                header("Location: new_mycourse.php"); // Redirect after successful enrollment
                exit();
            } else {
                echo "Error enrolling in the course: " . mysqli_error($conn); // Error message if enrollment fails
            }
        } else {
            // If the course code does not match, show a warning and redirect
            echo "<script>
                    alert('Incorrect course code. Please try again.');
                    window.location.href = 'new_student_course.php';
                  </script>";
        }
    } else {
        // If the course ID is not found in the database
        echo "<script>
                alert('Course not found. Please try again.');
                window.location.href = 'new_student_course.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href = 'new_student_course.php';
          </script>"; // Invalid request method, not POST
}
?>
