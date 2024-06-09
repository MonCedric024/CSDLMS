<?php
include('connect.php');
session_start();

// Check if the course name is set in the URL
if(isset($_GET['course'])) {
    $_SESSION['course_name'] = htmlspecialchars($_GET['course']);
}

// Retrieve the course ID based on the course name
$course_id = null;
if(isset($_SESSION['course_name'])) {
    $course_name = $_SESSION['course_name'];
    $course_id_sql = "SELECT course_id FROM course WHERE course_name = '$course_name'";
    $course_id_result = mysqli_query($conn, $course_id_sql);
    if($course_id_result && mysqli_num_rows($course_id_result) > 0) {
        $course_id_row = mysqli_fetch_assoc($course_id_result);
        $course_id = $course_id_row['course_id'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/accordions.css">
    <link rel="stylesheet" href="CSS/newViewCourses.css">
    <title>Document</title>
</head>
<body>
<header>
    <h2>Student Portal</h2>
    <h3><?php echo 'Hello! '.$_SESSION['name']; ?></h3>
</header>
<ul class="view">
<center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
  <hr>
  <li><a href="new_student_profile.php"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M13.45 11.55l2.05 -2.05" /><path d="M6.4 20a9 9 0 1 1 11.2 0z" /></svg> Dashboard</a></li>
  <li><a href="new_mycourse.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Courses</a></li>
 
  <hr class="signout">  
  <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
</ul>

<ul class="course">
  <p class="course_name"><?php echo isset($_SESSION['course_name']) ? $_SESSION['course_name'] : ''; ?></p>
  <li><a href="new_view_course_home.php" class="course_active">Home</a></li>
  <!--<li><a href="#">Syllabus</a></li>-->
  <li><a href="new_view_course.php" class="active">Modules</a></li>
  <li><a href="new_student_assignment.php">Assignments</a></li>
  <li><a href="new_feedback.php?course_id=<?php echo $course_id; ?>">Feedbacks</a></li>
</ul> 


<footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer>

</body>
</html>
