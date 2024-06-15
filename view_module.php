<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
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
            width: calc(30% - 20px); 
            height: 150px;
            background-color: #f9f9f9;
            border: 5px solid #ddd;
            border-radius: 30px;
            margin-bottom: 20px;
            margin-right: 20px; 
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start; 
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

        .course-actions {
            display: flex;
            flex-direction: column; 
            align-items: flex-end; 
        }

        .delete-button,
        .edit-button {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px; 
            margin-top: 10px;
            width: 120px;
            text-align: center;
            cursor: pointer;
        }

        .edit-button {
            background-color: #007bff; 
        }

        .delete-button {
            background-color: #dc3545; 
        }

        .edit-button:hover,
        .delete-button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<?php
include('connect.php');

if (isset($_GET['course_id']) && isset($_GET['section']) && isset($_GET['subject'])) {
    $course_id = htmlspecialchars($_GET['course_id']);
    $section = htmlspecialchars($_GET['section']);
    $subject = htmlspecialchars($_GET['subject']);
} else {
    header('Location: new_instructor_profile.php');
    exit();
}

$query = "SELECT * FROM module WHERE subject = ? AND section = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $subject, $section);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="course-container">';
    while ($row = $result->fetch_assoc()) {

        echo '
            <div class="course-box" id="module_row_' . htmlspecialchars($row['module_id']) . '">
                <div class="course-info">
                    <p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>
                    <p><strong>Date Added:</strong> ' . $row['added'] . '</p>
                </div>
                <div class="course-actions">
                    <button class="delete-button" type="button" onclick="deleteModule(' . htmlspecialchars($row['module_id']) . ')">Delete</button>
                    <button class="edit-button" type="button">
                        <a href="assignments.php?assignment=' . htmlspecialchars($row['module_id']) . '" style="color: white; text-decoration: none;">View</a>
                    </button> 
                </div>
            </div>';
    }
    echo '</div>';
    echo "<tfoot><tr><td colspan='3'><button class='back-button' onclick='goBack()'>Back</button></td></tr></tfoot>";
} else {
    echo "<script>alert('No assignments found.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
<script>
    function goBack() {
        window.history.back();
    }
    
    function deleteModule(module_id) {
        if (confirm("Are you sure you want to delete this module?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_module.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var row = document.getElementById("module_row_" + module_id);
                    if (row) {
                        row.parentNode.removeChild(row);
                    }
                    if (!document.querySelector('.course-container .course-box')) { 
                        window.history.back();
                    }
                } else {
                    console.error("Delete request failed with status: " + xhr.status);
                }
            };
            xhr.send("module_id=" + module_id);
        }
    }
</script>

<footer>
    <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>

</body>
</html>
