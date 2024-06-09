<?php
include('connect.php');
session_start();

if(isset($_POST['submit'])) {
    $assignment_id = $_POST['aid'];
    foreach($_POST['marks'] as $student_id => $marks) {
        // Assuming you have a field called 'marks' in your submit_assignment table
        $sql_update = "UPDATE submit_assignment SET marks = '$marks' WHERE assignment_id = '$assignment_id' AND student_id = '$student_id'";
        mysqli_query($conn, $sql_update);
    }
    echo "Marks posted successfully.";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>CSD-Learning Management System</title>
    <link rel="stylesheet" href="CSS/stdUploads.css">

</head>

<body>
    <form method="POST" action="">
        <?php
        echo '<table class="center">';
        echo '<tr>
        <th> Student Name </th>
        <th> Student Work </th>
        <th> Marks </th>
        <th> Return </th>
        </tr>';
        $assignment_id = $_POST['aid'];
        $sql = mysqli_query($conn, "select  * from submit_assignment where assignment_id = '$assignment_id' ");
        while ($row = mysqli_fetch_assoc($sql)) {
            echo '<tr>';
            $sid =  $row['student_id'];
            $sql2 = mysqli_query($conn, "select * from student where student_id = '$sid'");
            $row2 = mysqli_fetch_assoc($sql2);
            $name = $row2['name'];
            echo '<td>' . $row2['name'] . '</td>';
            $filepath = $row['submit_file_path'];
            echo '<td>' . "<a href='$filepath' target='blank'> file </a>" . '</td>';
            echo '<td><input type="number" name="marks['.$sid.']" required></td>';
            echo '<td><input type="submit" name="submit" value="Post Marks"></td>';
        }
        echo '</table>';
        ?>
        <br>
        <div class="navigation-buttons back-button">
            <a href="prev_assignments.php">BACK</a>
        </div>
    </form>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>
</body>

</html>
