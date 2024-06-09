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

    <title>Learning Management System</title>
    <link rel="stylesheet" href="CSS/instructorprofile.css">

</head>

<body>
    <div class="container">
    <div class="card">
      <div class="card-header">
        <h1 class="text-center">Instructor Dashboard</h1>
      </div>
      <div class="card-body">
        
        <h3 class="text-center">Instructor ID: <?php echo $_SESSION['ins_id']; ?></h3>
      </div>
    </div>
    <div class="card">
      <div class="card-header">Navigation</div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item"><a href="create_course.php" class="card-link">Create New Course</a></li>
          <li class="list-group-item"><a href="display.php" class="card-link">Create New Lesson</a></li>
          
          <li class="list-group-item"><a href="assignments.php" class="card-link">Previous Assignments</a></li>
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