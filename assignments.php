<?php
include('connect.php');
session_start();

$assignment = isset($_GET['assignment']) ? htmlspecialchars($_GET['assignment']) : '';

$assignment_description = '';

if (!empty($assignment)) {
    $stmt = $conn->prepare("SELECT * FROM assignment WHERE assignment_id = ?");
    $stmt->bind_param('s', $assignment);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $assignment_description = htmlspecialchars($row['description']);
        $due_time = ($row['due_time']);
    }

    $stmt->close();
}
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
    <h1><?php echo $assignment_description; ?> (<?php echo $due_time; ?>)</h1>

    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Assignment Description</th>
                <th>File Submitted</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (isset($_GET['assignment'])) {
                $assignment_id = $_GET['assignment'];

                $submission_sql = "
                SELECT 
                    sa.student_id, 
                    sa.course_id, 
                    sa.assignment_id, 
                    sa.submit_file_path, 
                    sa.added,
                    sa.marks, 
                    sa.if_returned,
                    a.instructor_id, 
                    a.section AS assignment_section, 
                    a.subject, 
                    a.description, 
                    a.due_time, 
                    a.start_time,
                    s.name AS student_name, 
                    s.contactno, 
                    s.age, 
                    s.address, 
                    s.email_id, 
                    s.dob, 
                    s.gender, 
                    s.course AS student_course, 
                    s.section AS student_section, 
                    s.status
                FROM 
                    submit_assignment sa
                JOIN 
                    assignment a ON sa.assignment_id = a.assignment_id
                JOIN 
                    student s ON sa.student_id = s.student_id
                WHERE 
                    sa.assignment_id = ?";
                
                if ($stmt = $conn->prepare($submission_sql)) {
                    $stmt->bind_param("i", $assignment_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['student_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                            echo '<td><a href="' . htmlspecialchars($row['submit_file_path']) . '" download class="download-button">Download</a></td>';
                            echo '<td width="15%">' . htmlspecialchars($row['added']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No assignments found for this ID.</td></tr>';
                    }
                    $stmt->close();
                } else {
                    echo '<tr><td colspan="5">Query error: ' . $conn->error . '</td></tr>';
                }
            } else {
                echo '<tr><td colspan="5">Assignment ID not provided.</td></tr>';
            }
        ?>
        </tbody>
    </table>
    <br>
    <div class="navigation">
        <div class="navigation-buttons">
            <center><a href="new_instructor_profile.php">BACK</a><center>
        </div>
    </div>

    <footer>
        <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
    </footer>
</body>
</html>
