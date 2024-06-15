<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <link rel="stylesheet" href="CSS/view_assignments.css"> 
</head>
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

.delete-button {
    color: #fff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px; 
    margin-top: 90px;
	width: 120px;
}

.edit-button{
    color: #fff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px;
    margin-top: 10px;
    width: 120px;
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

.course-actions .delete-button i {
    color: #fff;
    margin-right: 5px;
}
</style>
<body>
<?php
include('connect.php');

if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $section = $_GET['section'];
    $subject = $_GET['subject'];
} else {
    header('Location: new_instructor_profile.php');
    exit();
}

$query = "SELECT * FROM Assignment WHERE subject = '$subject' AND section = '$section'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    echo '<div class="course-container">';
    while($row = mysqli_fetch_assoc($result)) {
        echo '
            <div class="course-box">
                <div class="course-info">
                    <p><strong>Description:</strong> '.$row['description'].'</p>';
        
        $due_time = strtotime($row['due_time']);
        $current_time = time();
        $time_left = $due_time - $current_time;
        $days_left = floor($time_left / (60 * 60 * 24));
        $hours_left = floor(($time_left % (60 * 60 * 24)) / (60 * 60));
        
        if ($days_left > 0) {   
            echo '<p><strong>Time Left:</strong> '.$days_left.' days '.$hours_left.' hrs</p>';
        } elseif ($hours_left > 0) {
            echo '<p><strong>Time Left:</strong> '.$hours_left.' hrs</p>';
        } else {
            echo '<p><strong>Time Left:</strong> Expired</p>';
        }
        
        echo '
                </div>
                <div class="course-actions">
                    <button class="delete-button" type="button" onclick="deleteAssignment('.$row['assignment_id'].')">Delete</button>
                    <button class="edit-button" type="button">
                        <a href="assignments.php?assignment='.$row['assignment_id'].'" style="color: white">Assignments</a>
                    </button> 
                    </div>
            </div>';
    }
    echo '</div>';
    echo "<tfoot><tr><td colspan='3'><button class='back-button' onclick='goBack()'>Back</button></td></tr></tfoot>";
} else {
    echo "<script>alert('No assignments found.'); window.history.back();</script>";
}
?>
<script>
   
    function goBack() {
        window.history.back();
    }
    
    function deleteAssignment(assignment_id) {
        if (confirm("Are you sure you want to delete this assignment?")) {
           
            var xhr = new XMLHttpRequest();
            
           
            xhr.open("POST", "delete_assignments.php", true);
            
           
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                 
                    var row = document.getElementById("assignment_row_" + assignment_id);
                    if (row) {
                        row.parentNode.removeChild(row);
                    }
                 
                    if (!document.querySelector('.table tbody tr')) {
                        window.history.back();
                    }
                } else {
                    
                    console.error("Delete request failed with status: " + xhr.status);
                }
            };
            
            
            xhr.send("assignment_id=" + assignment_id);
        }
    }
    
</script>

<footer>
    <p>Created By <span class="yellow-text">CSD E Learning Management System</span> All Rights Reserved</p>
</footer>

</body>
</html>
