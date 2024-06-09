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
    <link rel="stylesheet" href="CSS/std_assignment.css">
</head>
<body>

<?php
echo "<h1>" . "STUDENT" . "</h1>";
echo "<h3 style='text-align: center;'>" . $_SESSION['name'] . "</h3>";

$student_id  = $_SESSION['student_id'];
$sql = mysqli_query($conn, "SELECT * FROM enroll WHERE student_id = '$student_id'");
echo '<table class="center">';
echo '<tr>
<th> Assignment ID </th>
<th> Course ID </th>
<th> Description </th>
<th> Lessons </th>
<th> Upload Work </th>
<th> Due Time</th>
<th> Submit </th>
<th> Marks </th>
</tr>';

while ($row = mysqli_fetch_assoc($sql)) {
    $course_id = $row['course_id'];
    $sql2 = mysqli_query($conn, "SELECT * FROM assignment WHERE course_id = '$course_id'");
    while ($row2 = mysqli_fetch_assoc($sql2)) {
        echo '<tr>';
        $file_path = $row2['file_path'];
        echo '<td>' . $row2['assignment_id'] . '</td>
              <td>' . $row2['course_id'] . '</td>
              <td>' . $row2['description'] . '</td>';
        echo '<td>' . "<a href='$file_path' target='_blank'> View </a>" . '</td>';
        $ass_id = $row2['assignment_id'];
        $due_time = $row2['due_time'];

        $submit_sql = mysqli_query($conn, "SELECT * FROM submit_assignment WHERE assignment_id = '$ass_id' AND student_id = '$student_id'");
        if (mysqli_num_rows($submit_sql) === 1) {
            $submit_row = mysqli_fetch_assoc($submit_sql);
            echo '<td>You Already Submitted</td>';
            echo '<td>' . $due_time . '</td>';
            echo '<td>-</td>';
            // Show marks if assignment is graded
            if ($submit_row['marks'] !== null) {
                echo '<td>' . $submit_row['marks'] . '</td>';
            } else {
                echo '<td>Not yet graded</td>';
            }
        } else {
            echo '<form action="submit_assignment.php" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="aid" value="' . $row2["assignment_id"] . '">';
            echo '<input type="hidden" name="cid" value="' . $row2["course_id"] . '">';
            echo '<input type="hidden" name="student_id" value="' . $student_id . '">';
            echo '<td><input type="file" name="file" required></td>';
            echo '<td>' . $due_time . '</td>';
            echo '<td><input type="submit" name="submit" value="Submit"></td>';
            echo '<td>-</td>';
            echo '</form>';
        }
        echo '</tr>';
    }
}
echo '</table>';
?>

<div class="navigation">
    <div class="navigation-buttons">
        <a href="student_profile.php" class="button">BACK</a>
    </div>
</div>

<footer>
    <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>

<script src="#"></script>
</body>
</html>
