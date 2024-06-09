<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submissions</title>
    <link rel="stylesheet" href="CSS/view_submissionss.css">
</head>
<body>
<?php
include('connect.php');
session_start();

if(isset($_GET['assignment_id'])) {
    $assignment_id = $_GET['assignment_id'];

    // Fetch course details
    $course_sql = "SELECT course_id FROM assignment WHERE assignment_id = $assignment_id";
    $course_result = $conn->query($course_sql);

    if ($course_result && $course_result->num_rows > 0) {
        $course_row = $course_result->fetch_assoc();
        $course_id = $course_row['course_id'];

        // Fetch enrolled students for the course
        $enrolled_sql = "SELECT student.student_id, student.name, submit_assignment.assignment_id, submit_assignment.submit_file_path, submit_assignment.marks
                        FROM student
                        LEFT JOIN submit_assignment ON student.student_id = submit_assignment.student_id
                        WHERE student.student_id IN (SELECT student_id FROM enroll WHERE course_id = $course_id)";
        $enrolled_result = $conn->query($enrolled_sql);

        if ($enrolled_result && $enrolled_result->num_rows > 0) {
            echo '<h1>Students Enrolled and Submissions for Assignment</h1>';
            echo '<table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Submission Status</th>
                            <th>File Submitted</th>
                            <th>Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $enrolled_result->fetch_assoc()) {
                $student_id = $row['student_id'];
                $name = $row['name'];
                $submission_status = $row['assignment_id'] ? 'Submitted' : 'Not Submitted';
                $file_path = $row['submit_file_path'] ?? '';
                $marks = $row['marks'] ?? '';

                echo '<tr>
                        <td>' . $student_id . '</td>
                        <td>' . $name . '</td>
                        <td>' . $submission_status . '</td>
                        <td><a href="' . $file_path . '" target="_blank">' . ($file_path ? 'View File' : '') . '</a></td>
                        <td>' . ($marks ? $marks : 'Not Graded') . '</td>
                        <td>';
                
                if (!$marks) {
                    echo '<form action="" method="post">
                            <input type="hidden" name="student_id" value="' . $student_id . '">
                            <input type="hidden" name="assignment_id" value="' . $assignment_id . '">
                            <input type="number" name="marks" placeholder="Enter Marks" required>
                            <button type="submit">Grade</button>
                        </form>';
                } else {
                    echo 'Graded';
                }

                echo '</td>
                    </tr>';
            }

            echo '</tbody>
                </table>';
        } else {
            echo '<p>No students enrolled in this course.</p>';
        }
    } else {
        echo '<p>Invalid assignment ID</p>';
    }
} else {
    echo '<p>Assignment ID not provided</p>';
}

// Handle form submission to update marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['marks'])) {
    $student_id = $_POST['student_id'];
    $assignment_id = $_POST['assignment_id'];
    $marks = $_POST['marks'];

    // Update marks in the database
    $update_sql = "UPDATE submit_assignment SET marks = $marks WHERE student_id = $student_id AND assignment_id = $assignment_id";
    if ($conn->query($update_sql) === TRUE) {
        // Refresh the page to display updated marks
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error updating marks: " . $conn->error;
    }
}

$conn->close();
?>
<br>
        <div class="navigation">
    <div class="navigation-buttons">
        <a href="assignments.php" class="button">BACK</a>
    </div>
</div>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>
</body>
</html>
