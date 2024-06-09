<?php
include('connect.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Published Assignments</title>
    <link rel="stylesheet" href="CSS/assignments.css">
</head>
<body>
    <h1>Published Assignments</h1>

    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Assignment Description</th>
                <th>Due Date</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT course.course_name, assignment.description, assignment.due_time, assignment.assignment_id 
                FROM assignment 
                INNER JOIN course ON assignment.course_id = course.course_id
                WHERE assignment.due_time >= NOW()";
        
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $course_name = $row['course_name'];
                $assignment_name = $row['description'];
                $due_date = $row['due_time'];
                $assignment_id = $row['assignment_id'];

                // Check if any student submitted the assignment
                $submission_sql = "SELECT * FROM submit_assignment WHERE assignment_id = $assignment_id";
                $submission_result = $conn->query($submission_sql);

                echo '<tr>';
                echo '<td>' . $course_name . '</td>';
                echo '<td>' . $assignment_name . '</td>';
                echo '<td>' . $due_date . '</td>';
                echo '<td>';
if ($submission_result && $submission_result->num_rows > 0) {
    echo '<a href="view_submissions.php?assignment_id=' . $assignment_id . '">View Submissions</a>';
} else {
    echo 'Not yet submitted';
}
echo '</td>';

                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No published assignments found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
    <br>
    <div class="navigation">
        <div class="navigation-buttons">
            <a href="new_instructor_profile.php" class="button">BACK</a>
        </div>
    </div>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>
</body>
</html>
