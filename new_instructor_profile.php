<?php
session_start(); 
include('connect.php'); 
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $courses_query = "SELECT 
        instructor_subject.id AS instructor_subject_id,
        instructor_subject.subject_id,
        instructor_subject.instructor_id,
        instructor_subject.section,
        subject.id AS subject_id,
        subject.course_id,
        subject.title,
        subject.description
    FROM 
        instructor_subject
    LEFT JOIN 
        subject 
    ON 
        instructor_subject.subject_id = subject.id
    WHERE 
        instructor_subject.instructor_id = $id;";

    $courses_result = mysqli_query($conn, $courses_query);
    if (mysqli_num_rows($courses_result) > 0) {
        
        ob_start();
        echo '<div class="row" style="display: flex; flex-wrap: wrap;">';
        while ($course = mysqli_fetch_assoc($courses_result)) {
            $course_id = $course['course_id'];
            $course_title = htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8');
            $course_description = htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8');
            $course_section = htmlspecialchars($course['section'], ENT_QUOTES, 'UTF-8');
            $subject_id = htmlspecialchars($course['subject_id'], ENT_QUOTES, 'UTF-8');
            echo '<div class="col" style="flex: 1 0 21%; margin: 5px; margin-left: 120px; box-sizing: border-box;">';
            echo '<div class="card" style="width: 100%;">';
            echo '<img src="images/Coding-amico.png" alt="Course Image" style="width:100px">';
            echo '<div class="card_container">';
            echo '<p>' . $course_title . ' - ' . $course_section . '</p>';
            echo '<p>Description: ' . $course_description . '</p>'; 
            echo '<button onclick="window.location.href = \'new_view_students.php?course_id=' . urlencode($course_id) . '&section=' . $course_section . '\';" style="margin-right: 10px;">Students</button>';
            echo '<button onclick="window.location.href = \'create_assignment.php?course_id=' . urlencode($course_id) . '&section=' . $course_section .'&subject=' . $subject_id .'\';" style="margin-right: 10px;">Assignment</button>';
            echo '<button onclick="window.location.href = \'create_module.php?course_id=' . urlencode($course_id) . '&section=' . $course_section .'&subject=' . $subject_id .'\';">Module</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        
        $courses_output = ob_get_clean();
    } else {
        $courses_output = '<p>No courses created yet.</p>';
    }
} else {
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
    <!-- <a href="create_course.php"><button class="add_course">Add Subjects</button></a> -->
    <ul class="view">
    <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_instructor_profile.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Subjects</a></li>
        <!-- <li><a href="assignments.php" ><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg> Submissions</a></li> -->
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
