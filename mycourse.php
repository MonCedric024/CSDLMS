<?php
include('connect.php');
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/myCourse.css">
</head>

<body>
    <h1>My Courses</h1>

    <?php
    echo '<table class="center">';
    echo '<tr>
    <th> Course ID </th>
    <th> Course Name </th>
    <th> Comments </th>
    <th> Action </th>
    </tr>';

    $student_id = $_SESSION['student_id'];
    $sql = mysqli_query($conn, "SELECT * FROM enroll WHERE student_id ='$student_id'");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo '<tr>';
        echo '<td>' . $row['course_id'] . '</td>';
        $course_id = $row['course_id'];
        $sql2 = mysqli_query($conn, "SELECT * FROM course WHERE course_id ='$course_id'");
        $row2 = mysqli_fetch_assoc($sql2);
        echo '<td>' . $row2['course_name'] . '</td>';
        $course_name = $row2['course_name'];


        echo '<td><form action="feedback_display.php" method="POST">
        <input type="text" name="cid" value="' . $course_id . '" hidden>' .
        '<input type="submit" value="Comments" name="submit_f">' .
        '</form></td>';



        echo '<td>' . '<form action="delete.php" method="POST">
        <input type="text" name="cid" value="' . $course_id . '" hidden>' .
            '<input type="submit" value="Delete" name="submit_delete">' .
            '</form>' . '</td>';

        echo '</tr>';
    }
    echo '</table>';
    ?>

    <br>
    <div class="navigation">
        <div class="navigation-buttons">
            <a href="student_profile.php" class="button">BACK</a>
        </div>
    </div>
    <br>
    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>

    <script src="#"></script>
</body>

</html>
