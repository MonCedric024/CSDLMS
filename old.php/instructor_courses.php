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
    <link rel="stylesheet" href="CSS/instructor_courses.css">

</head>
<body>
<?php
    echo "<h1>" . $_SESSION['name'] . "</h1>";
    //echo "<h1>" . $_SESSION['ins_id'] . "</h1>";
    ?>

    <?php
    // print_r($_POST);
    echo '<table class="center">';
    echo '<tr>
    <th> Course ID </th>
    <th> Course Name </th>
    <th> Course Description </th>
    
    <th> Create Comments </th>
    <th> Comments </th>
    </tr>';
    if (isset($_SESSION['ins_id'])) {
        try {
            $int_id = $_SESSION['ins_id'];
            // Debug point 1: Echo out instructor ID to ensure it's set correctly
            echo "<p>Instructor ID: $int_id</p>";
            
            // print_r($instructor_name);
            $sql = mysqli_query($conn, "SELECT * FROM course WHERE instructor_id = '$int_id'");
            // Debug point 2: Echo out SQL query for debugging
            echo "<p>SQL Query: SELECT * FROM course WHERE instructor_id = '$int_id'</p>";
            
            while ($row = mysqli_fetch_assoc($sql)) {
                echo '<tr>';
                echo '<td>' . $row['course_id'] . '</td><td>' . $row['course_name'] . '</td><td>' . $row['course_description'] . "</td>";
                
                echo '<form action="create_feedback.php" method="POST">' .
                    '<input type="hidden" name="cid" value="' . $row["course_id"] . '">' .
                    '<input type="hidden" name="instructor_id" value="' . $row["instructor_id"] . '">' .
                    '<td><input type="submit" name="submit" value="Create Comment"></td>' .
                    '</form>';
                
                $cid = $row['course_id'];
                echo '<form action="previous_feedbacks.php" method="POST">' .
                    '<input type="hidden" name="cid" value="' . $cid . '">' .
                    '<td><input type="submit" name="submit" value="Comments"></td>' .
                    '</form>';
                
                echo '</tr>';
            }
            unset($_POST);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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
