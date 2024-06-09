<?php
include('connect.php');
session_start();
// print_r($_SESSION);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/studentProfile.css">
</head>

<body>
    <div class="container">
    <div class="card">
      <div class="card-header">
        <h1 class="text-center">Student Dashboard</h1>
      </div>
      <div class="card-body">
        <h3 class="text-center">Name: <?php echo $_SESSION['name']; ?></h3>
        <h3 class="text-center">Student ID: <?php echo $_SESSION['student_id']; ?></h3>
      </div>
    </div>
    <div class="card">
      <div class="card-header">Navigation</div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item"><a href="student_course.php" class="card-link">Available Courses</a></li>
          <li class="list-group-item"><a href="student_assignments.php" class="card-link">Lesson & Assignments</a></li>
          <li class="list-group-item"><a href="mycourse.php" class="card-link">My Courses</a></li>
          <li class="list-group-item"><a href="logout.php" class="card-link">Sign Out</a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>


  <script src="#"></script>
</body>

</html>