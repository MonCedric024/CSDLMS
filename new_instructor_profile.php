<?php
session_start(); // Start the session
include('connect.php'); // Include the file that establishes database connection

// Check if the instructor ID is set in the session
if (isset($_SESSION['ins_id'])) {
    $ins_id = $_SESSION['ins_id'];

    // Retrieve courses created by the instructor
    $courses_query = "SELECT * FROM course WHERE instructor_id = '$ins_id'";
    $courses_result = mysqli_query($conn, $courses_query);
    // Check if there are courses
    if (mysqli_num_rows($courses_result) > 0) {
        // Start output buffering to capture the courses
        
        ob_start();
        while ($course = mysqli_fetch_assoc($courses_result)) {
            $course_id = $course['course_id'];
            $course_code = $course['course_code']; // Kunin ang subject code
            echo '<div class="card">';
            echo '<img src="images/Coding-amico.png" alt="Course Image" style="width:100%">';
            echo '<div class="card_container">';
            echo '<p>' . $course['course_name'] . '</p>';
            echo '<p>Subject Code: ' . $course_code . '</p>'; // I-display ang subject code
            echo '<button onclick="window.location.href = \'new_view_students.php?course_id=' . urlencode($course['course_id']) . '\';">Students</button>';
            echo '<button onclick="window.location.href = \'create_assignment.php?course_id=' . urlencode($course_id) . '\';">Assignment</button>';
            echo '</div>';
            echo '</div>';
        }
        
        // Get the buffered output and assign it to a variable
        $courses_output = ob_get_clean();
    } else {
        $courses_output = '<p>No courses created yet.</p>';
    }
} else {
    // Redirect if instructor ID is not set
    header('Location: signup.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/instructo.css">
    <link rel="stylesheet" href="CSS/ProfFooter.css">
    <title>CSD-Learning Management System</title>
</head>
<body>
    <header>
        <h2>Instructor Portal</h2>
        <h3><?php echo 'Prof. '.$_SESSION['name']; ?></h3>
    </header>
    <h1>My Subjects</h1>
    <a href="create_course.php"><button class="add_course">Add Subjects</button></a>
    <ul class="view">
    <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_instructor_profile.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Subjects</a></li>
        <li><a href="assignments.php" ><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg> Submissions</a></li>
        <hr class="signout">  
        <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
    </ul>
    
    <div class="course_container">

        <?php echo isset($courses_output) ? $courses_output : ''; ?>
    </div>

<footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer>

</body>
</html>
