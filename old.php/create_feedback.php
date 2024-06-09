<?php
include('connect.php');
session_start();
// print_r($_SESSION);
// print_r($_POST);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/create_assignment.css">

</head>
<body>
   
    <form action="upload_feedback.php" id="feedback_form" method="POST" enctype="multipart/form-data">
    <?php
    $_SESSION['course_id'] = $_POST['cid'];
    echo "<h1>" . $_POST['cid'] . "</h1>";
    // echo "<h1>" . $_POST['instructor_id'] . "</h1>";
    ?>
        <div>
            <label for="Feedback_id">Feedback ID : </label>
            <input type="text" name="feedback_id" required>
        </div>
        <div>
            <label for="Feedback">Feedback : </label>
            <textarea name="description" id="feedback_form" cols="30" rows="4" required></textarea>
        </div>
        <!--<div>
            <label for="due_date">Due Date : </label>
            <input type="date" name="due_time" id="" required>
        </div>-->
        <div>
            <br>
            <button type="submit" name="submit_feedback"> Submit </button>
        </div>
    </form>
    <br>
    <div class="navigation">
  <div class="navigation-buttons">
    <a href="instructor_courses.php" class="button">BACK</a>
  </div>
</div>
    <script src="#"></script>
</body>

</html>