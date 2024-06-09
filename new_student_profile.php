<?php
include('connect.php');
session_start();

// Query to count the number of subjects enrolled by the student
$student_id = $_SESSION['student_id'];
$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total_subjects FROM enroll WHERE student_id ='$student_id'");
$count_row = mysqli_fetch_assoc($count_query);
$total_subjects = $count_row['total_subjects'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/new_styles.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <title>Document</title>







    <style>
.box {
    background-color: #f8f9fa; 
    border: 2px solid #dee2e6; 
    border-radius: 8px; 
    padding: 20px; 
    margin-bottom: 20px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    width: 50%; 
    margin-left: auto; 
    margin-right: auto; 
    margin-left: 450px;
}

h3 {
    margin: 0; 
    color: #333; 
    font-size: 18px; 
    font-weight: bold; 
    padding-top: 20px;
}

.subject-count {
    font-size: 30px;
    color: #007bff; 
    margin-top: -30px; 
    padding-left: 150px;
}

 /* Media query for screens smaller than 600px (typical mobile screens) */
 @media (max-width: 600px) {
        .box {
            width: 90%; /* Adjust width for smaller screens */
        }

        .subject-count {
            padding-left: 0;
            margin-top: 10px; /* Add some space */
        }
    }
</style>

</head>
<body>
  <header>
      <h2>Student Portal</h2>
      <h3><?php echo 'Hello! '.$_SESSION['name']; ?></h3>
      
  </header>
  <ul>
  <center><h3 class="logo"><img src="CSD.png" alt="CSD E-LMS Logo"></h3></center>
    <hr>
    <li><a href="new_student_profile.php" class="active"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M13.45 11.55l2.05 -2.05" /><path d="M6.4 20a9 9 0 1 1 11.2 0z" /></svg> Dashboard</a></li>
    <li><a href="new_mycourse.php"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-book"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg> My Courses</a></li>
    <hr class="signout">  
    <li><a href="logout.php "> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> Sign out</a></li>
  </ul>

  <div class="box">
  <h3>Total Subjects:</h3>
  <div class="subject-count"><?php echo $total_subjects; ?></div>
</div>
   
   
<footer>
  <p>Created By <span class="yellow-text">CSD E Learning System</span> All Rights Reserved</p>
</footer>

</body>
</html>