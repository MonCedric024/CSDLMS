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

    <title>Learning Management System</title>
    <link rel="stylesheet" href="CSS/prev_assignments.css">

</head>
<body>
    <?php
    // echo "<h1>" . $_SESSION['name'] . "</h1>";
    // echo "<h1>" . $_SESSION['ins_id'] . "</h1>";
    ?>

    <?php
    // print_r($_POST);
    if (isset($_POST['submit'])) {
        try {
            // $int_id = $_SESSION['ins_id'];
            // print_r($instructor_name);
            $course_id = $_POST['cid'];
            $sql = mysqli_query($conn, "select* from feedback where course_id = '$course_id'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $feedback_id = $row['feedback_id'];
                echo '<div>' . $row['content'] . '</div>';
                echo '<table class="center">';
                echo '<tr>
                <th> Student ID </th>
                <th> Answer </th>
                </tr>';
                $sql2 = mysqli_query($conn, "select* from takes_feedback where course_id = '$course_id' and feedback_id = '$feedback_id'");
                while ($row2 = mysqli_fetch_assoc($sql2)) {
                    echo '<tr>';
                    echo '<td>' . $row2['student_id'] . '</td>';
                    echo '<td>' . $row2['answer'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            unset($_POST);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ?>
    <div><a href="instructor_profile.php"> Profile Home</a></div>
    <div><a href="logout.php">Sign Out</a></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>