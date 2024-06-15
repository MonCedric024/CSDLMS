<?php
include('connect.php');
session_start();
// print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/card.css">
    <link rel="stylesheet" href="CSS/footer.css">
    
    <title>Document</title>
</head>
<body>
  <header>
      <h2>Student Portal</h2>
      <h3><?php echo 'Hello! '.$_SESSION['name']; ?></h3>
  </header>
  
    <ul>
        <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_student_profile.php"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M13.45 11.55l2.05 -2.05" /><path d="M6.4 20a9 9 0 1 1 11.2 0z" /></svg> Dashboard</a></li>
        <li><a href="new_mycourse.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Subjects</a></li>  
        <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
    </ul>
  <div>
    <h1>My Subjects <a href="new_student_course.php">
    <button style="margin-left:-2000px; background-color: white;"></button></a></h1>
  
        <div class="container">
        <?php
        $section = $_SESSION['section'];

        $sql2 = mysqli_query($conn, "
        SELECT 
            instructor_subject.id AS instructor_subject_id,
            instructor_subject.subject_id,
            instructor_subject.instructor_id,
            subject.id AS subject_id,
            subject.course_id,
            subject.title AS course_name,
            subject.description,
            instructor.instructor_name 
        FROM 
            instructor_subject
        LEFT JOIN 
            subject 
        ON 
            instructor_subject.subject_id = subject.id
        LEFT JOIN 
            instructor 
        ON 
            instructor_subject.instructor_id = instructor.id
        WHERE 
            instructor_subject.section = '$section';");

        if (mysqli_num_rows($sql2) > 0) {
            echo '<div class="row" style="display: flex; flex-wrap: wrap; margin-left: 140px;">';
            while ($row2 = mysqli_fetch_assoc($sql2)) {
                $course_id = htmlspecialchars($row2['course_id'], ENT_QUOTES, 'UTF-8');
                $course_name = htmlspecialchars($row2['course_name'], ENT_QUOTES, 'UTF-8');
                $subject_id = htmlspecialchars($row2['subject_id'], ENT_QUOTES, 'UTF-8');
                $course_description = htmlspecialchars($row2['description'], ENT_QUOTES, 'UTF-8');
                $instructor_name = htmlspecialchars($row2['instructor_name'], ENT_QUOTES, 'UTF-8');
                echo '<div class="col" style="flex: 1 0 21%; margin: 10px; box-sizing: border-box; padding: 0 10px;">';
                echo '<div class="card" style="width: 550px; height: 450px; margin-bottom: 20px;">';
                echo '<img src="images/Coding-amico.png" alt="Course Image" style="width:150px; height: 150px;">';
                echo '<div class="card_container" style="padding: 16px;">';
                echo '<h4><b>' . $course_name . '</b></h4>';
                echo '<p>Description: ' . $course_description . '</p>';
                echo '<p>Instructor: ' . $instructor_name . '</p>';
                echo '<button style="margin-right: 5px;" onclick="window.location.href = \'new_view_course.php?course_id=' . urlencode($course_id) .'&subject='. urlencode($subject_id) .'\';">View</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No courses found for this section.</p>';
        }?>
    </div>
</body>
</html> 