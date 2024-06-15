<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Module</title>
    <link rel="stylesheet" href="CSS/view_assignments.css">
    <style>
        .course-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 90%;
            margin: auto;
        }
        .course-box {
            width: calc(40% - 20px);
            background-color: #f9f9f9;
            border: 5px solid #ddd;
            border-radius: 30px;
            margin-bottom: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        @media (max-width: 768px) {
            .course-box {
                width: calc(50% - 20px);
            }
        }
        .course-info {
            flex: 1;
        }
        .course-info p {
            margin: 5px 0;
        }
        .back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .comment-form {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .comment-form input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-right: 10px;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .comment-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php
include('connect.php');
session_start();

if (isset($_GET['module'])) {
    $module = htmlspecialchars($_GET['module']);
} else {
    header('Location: new_instructor_profile.php');
    exit();
}

// Insert comment if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $id = $_SESSION['id'];

    if (!empty($comment)) {
            $stmt = $conn->prepare("INSERT INTO module_comments (module_id, instructor_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $module, $id, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch module information
$query = "SELECT * FROM module WHERE module_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $module);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="course-container">';
    while ($row = $result->fetch_assoc()) {
        echo '
            <div class="course-box" id="module_row_' . htmlspecialchars($row['module_id']) . '">
                <div class="course-info">
                    <p><strong>Title:</strong> ' . htmlspecialchars($row['title']) . '</p></br>
                    <p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p></br>
                    <p><strong>Date Added:</strong> ' . $row['added'] . '</p></br>';

        // Fetch files for the module
        $fileQuery = "SELECT file_path FROM module_files WHERE module_id = ?";
        $fileStmt = $conn->prepare($fileQuery);
        $fileStmt->bind_param('s', $row['module_id']);
        $fileStmt->execute();
        $fileResult = $fileStmt->get_result();

        if ($fileResult->num_rows > 0) {
            echo '<p><strong>Files:</strong></p>';
            while ($fileRow = $fileResult->fetch_assoc()) {
                echo '<p><a href="' . htmlspecialchars($fileRow['file_path']) . '" download>' . basename(htmlspecialchars($fileRow['file_path'])) . '</a></p>';
            }
        } else {
            echo '<p>No files available.</p>';
        }
        $fileStmt->close();

        echo '</div></div>';
    }
    echo '</div>';
} else {
    echo "<script>alert('No modules found.'); window.history.back();</script>";
}

$query = "
    SELECT mc.*, 
           IFNULL(i.instructor_name, s.name) AS user_name 
    FROM module_comments mc
    LEFT JOIN instructor i ON mc.instructor_id = i.id
    LEFT JOIN student s ON mc.student_id = s.id
    WHERE mc.module_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $module);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="course-container">';
echo '<div class="course-box">';
echo '<div class="course-info">';
echo '<p><strong>Comments</strong></p><br>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<p><strong>' .  htmlspecialchars($row['user_name']) . '</strong> - ' . htmlspecialchars($row['message']) . '</p><br>';
    }
} else {
    echo '<p>No comments found.</p>';
}

echo '</div>';
echo '<form class="comment-form" method="POST" action="">';
echo '<input type="text" name="comment" placeholder="Add a comment" required>';
echo '<button type="submit" name="submit">Send</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo "<tfoot><tr><td colspan='3'><button class='back-button' onclick='goBack()'>Back</button></td></tr></tfoot>";
$stmt->close();
$conn->close();
?>
<footer>
    <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>
<script>
        function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
