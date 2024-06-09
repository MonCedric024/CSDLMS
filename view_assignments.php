<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
    <link rel="stylesheet" href="CSS/view_assignments.css"> 
</head>
<body>
<?php
include('connect.php');

if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
} else {
    
    header('Location: new_instructor_profile.php');
    exit();
}


$query = "SELECT * FROM Assignment WHERE course_id = '$course_id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>Description</th><th>Time Left</th><th>Action</th></tr></thead>";
    echo "<tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr id='assignment_row_".$row['assignment_id']."'>";
        echo "<td>".$row['description']."</td>";
        
        $due_time = strtotime($row['due_time']);
        $current_time = time();
        $time_left = $due_time - $current_time;
        $days_left = floor($time_left / (60 * 60 * 24));
        $hours_left = floor(($time_left % (60 * 60 * 24)) / (60 * 60));
        
        if ($days_left > 0) {
            echo "<td>".$days_left." days ".$hours_left." hrs</td>";
        } elseif ($hours_left > 0) {
            echo "<td>".$hours_left." hrs</td>";
        } else {
            echo "<td>Expired</td>";
        }
        echo "<td><button class='delete-button' type='button' onclick='deleteAssignment(".$row['assignment_id'].")'>Delete</button></td>";
        
echo "</tr>";
}
echo "</tbody>";


echo "<tfoot><tr><td colspan='3'><button class='back-button' onclick='goBack()'>Back</button></td></tr></tfoot>";


    echo "</table>";
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
