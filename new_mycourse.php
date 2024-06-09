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
  
    <hr class="signout">  
    <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
  </ul>
  <div>
  <h1>My Subjects <a href="new_student_course.php"><button class = "add_course" style="float:right; margin-right:50px;">Add Subject</button></a></h1>
  
  <div class="container">
    <?php
    // Get the current student ID
    $student_id = $_SESSION['student_id'];

    // Retrieve all courses the student is enrolled in
    $sql = mysqli_query($conn, "SELECT * FROM enroll WHERE student_id = '$student_id'");

    // Loop through each enrolled course and fetch additional details
    while ($row = mysqli_fetch_assoc($sql)) {
        $course_id = $row['course_id'];
        $sql2 = mysqli_query($conn, "SELECT * FROM course WHERE course_id = '$course_id'");
        $row2 = mysqli_fetch_assoc($sql2);

        // Display course information
        ?>
        <div class="card">
            <img src="images/coding-amico.png" alt="Avatar" style="width:100%">
            <div class="card_container">
                <h4><b><?php echo $row2['course_name']; ?></b></h4>

                <?php
                // Check if course code is set and not empty
                if (!empty($row2['course_code'])) {
                    // If course code is available, display it
                    echo '<p><b>Course Code:</b> ' . $row2['course_code'] . '</p>';
                } else {
                    // If not, display a default message
                    echo '<p><b>Course Code:</b> No course code available</p>';
                }
                ?>

                <button onclick="window.location.href = 'new_view_course_home.php?course=<?php echo urlencode($row2['course_name']); ?>';">View</button>
            </div>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html> 