<?php
include('connect.php');
session_start();
// print_r($_SESSION);
// print_r($_POST['cname']);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/stdFeedback.css">
</head>
<body>
    <?php

    //echo "<h1>" . "SUBMIT FEEDBACKS" . "</h1>";
    //echo "<h3 style='text-align: center;'>" . $_SESSION['name'] . "</h3>";
    // echo "<h3 style='text-align: center;'>" . $_SESSION['student_id'] . "</h3>";
    ?>
    <?php
    if (isset($_POST['submit_f']))
        echo '<table class="center">';
    echo '<tr>
    <th> Course ID </th>
    <th> Feedback ID </th>
    <th> Content  </th>
    <th> Answer </th>
    <th> Submit </th>
    </tr>';
    $student_id = $_SESSION['student_id'];
    $course_id = $_POST['course_id'];
    $sql = mysqli_query($conn, "select * from comments where course_id ='$course_id'");
    while ($row = mysqli_fetch_assoc($sql)) {
        
    }
        $sql2 = "SELECT * from comments where course_id = '$course_id'";
        $result = $conn->query($sql2);
        if ($result){
            while($row=mysqli_fetch_assoc($result)){
                $course_id = $_POST['course_id'];
                $feedback_id = $row['feedback_id'];
                $content = $row['content'];
                echo '<td>'.$course_id.'</td>';
                echo '<td>'.$feedback_id.'</td>';
                echo '<td>'.$content.'</td>';
                echo '<td></td>';
                echo '<td></td>';
            }
        }
    echo '</table>';
    ?>
     <br>
<div class="navigation-buttons back-button">
    <a href="mycourse.php">BACK</a>
</div>

<footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>