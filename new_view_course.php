<?php
include('connect.php');
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$subject = isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : '';

if (isset($subject)) {
    $stmt = $conn->prepare("SELECT * FROM module WHERE subject = ?");
    $stmt->bind_param('s', $subject);
    $stmt->execute();
    $result = $stmt->get_result();
}

if (!empty($subject)) {
    $stmt = $conn->prepare("SELECT title FROM subject WHERE id = ?");
    $stmt->bind_param('s', $subject);
    $stmt->execute();
    $result1 = $stmt->get_result();
    
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $_SESSION['title'] = $row['title'];
    } else {
        $_SESSION['title'] = 'Description not found.';
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/accordions.css">
    <link rel="stylesheet" href="CSS/newViewCourse.css">
    <title>Assignments</title>
</head>
<body>
    <header>
        <h2>Student Portal</h2>
        <h3><?php echo 'Hello! ' . htmlspecialchars($_SESSION['name']); ?></h3>
    </header>
    <ul class="view">
        <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
        <hr>
        <li><a href="new_student_profile.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M13.45 11.55l2.05 -2.05" />
                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
            </svg> Dashboard</a></li>
        <li><a href="new_mycourse.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                <path d="M3 6l0 13" />
                <path d="M12 6l0 13" />
                <path d="M21 6l0 13" />
            </svg> My Courses</a></li> 
        <li><a href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                <path d="M15 12h-12l3 -3" />
                <path d="M6 15l-3 -3" />
            </svg> Sign out</a></li>
    </ul>

    <ul class="course" style="width: 200px; margin-left: 300px;">
        <p class="course_name"></p>
        <li><a href="new_view_course.php?subject=<?php echo $subject; ?>" class="course_active">Modules</a></li>
        <li><a href="new_student_assignment.php?subject=<?php echo $subject; ?>">Assignments</a></li>
        <li><a href="new_feedback.php?course_id=<?php echo htmlspecialchars($course_id); ?>">Feedbacks</a></li>
    </ul> 
    <div class="accordion_box" style="margin-left: 550px;">
        <h1>Module for <?php echo isset($_SESSION['title']) ? htmlspecialchars($_SESSION['title']) : ''; ?></h1>
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Title: </strong>" . htmlspecialchars($row['title']) . "</p>";
                echo "<p><strong>Description: </strong>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p><strong>Due Date: </strong>" . htmlspecialchars($row['added']) . "</p>";
                echo "<a href='student_module_content.php?module=" . htmlspecialchars($row['module_id']) . "&subject=" . htmlspecialchars($subject) . "'><button class='view_btn'>View Module</button></a>";
                echo "<hr>";
            }
        } else {
            echo "<p>No upcoming assignments found for this course.</p>";
        }
        ?>
    </div>

<!-- <footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer> -->

</body>
</html>
