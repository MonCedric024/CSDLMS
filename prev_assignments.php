<?php
include('connect.php');
session_start();
// print_r($_SESSION);
// print_r($_POST);
// $_SESSION['course_id'] = $_POST['cid'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/prev_assignments.css">

</head>
<body>
    <?php
    echo '<table class="center">';
    echo '<tr>
    <th> Assignment ID  </th>
    <th> Assignment Descriptions </th>
    <th> Student Works </th>
    </tr>';
    $instructor_id  = $_SESSION['ins_id'];
    $sql = mysqli_query($conn, "select* from assignment where instructor_id = '$instructor_id'");
    echo '<br>';
    while ($row = mysqli_fetch_assoc($sql)) {
        echo '<tr>';
        echo '<td>' . $row['assignment_id'] . '</td>';
        echo '<td>' . $row['description'] . '</td>';
        $assignment_id = $row['assignment_id'];
        echo '<form action="student_uploads.php" method = "POST"> 
        <input type="number" name = "aid" value=' . $assignment_id . ' hidden>' .
            '<td>' . '<input type="submit" value = "Files">' . '</td>' .
            '</form>';
        echo '</tr>';
    }
    echo '</table>';
    ?>
    <div class="navigation">
  <div class="navigation-buttons">
    <a href="instructor_profile.php" class="button">BACK</a>
  </div>
</div>

<br>

<footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>

    <script src="#"></script>
</body>

</html>