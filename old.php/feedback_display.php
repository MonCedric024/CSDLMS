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
    <title>Course Comments</title>
    <link rel="stylesheet" href="CSS/std_feedback.css">
</head>

<body>
    <h1>Course Comments</h1>

    <?php
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];

        $course_name_sql = "SELECT course_name FROM course WHERE course_id = ?";
        $stmt = $conn->prepare($course_name_sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $course_name_row = $result->fetch_assoc();
            $course_name = $course_name_row['course_name'];

            echo '<h2>Comments for Course: ' . $course_name . '</h2>';

            $comments_sql = "SELECT * FROM comments WHERE course_id = ?";
            $stmt = $conn->prepare($comments_sql);
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th>Course ID</th>   
                                <th>Feedback ID</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($comment = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $comment['course_id'] . '</td>
                            <td>' . $comment['feedback_id'] . '</td>
                            <td>' . $comment['content'] . '</td>
                        </tr>';
                }

                echo '</tbody>
                    </table>';
            } else {
                echo '<p>No comments available for this course.</p>';
            }
        } else {
            echo '<p>Invalid course ID.</p>';
        }
    } else {
        echo '<p>Course ID not provided.</p>';
    }
    ?>

    <br>
    <div class="navigation-buttons back-button">
        <a href="mycourse.php">BACK</a>
    </div>
    <br>
    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>

    <script src="#"></script>
</body>

</html>
