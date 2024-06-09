<?php
// Include the database connection file
include('connect.php');

// Check if the form is submitted
// Check if the form is submitted and if the course_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $content = $_POST['content'];
    $course_id = $_POST['course_id']; 
    
    // Generate a random 4-digit feedback ID
    $feedback_id = mt_rand(1000, 9999);

    // Insert the feedback into the feedback table
    $insert_sql = "INSERT INTO comments (feedback_id, student_id, course_id, content) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($insert_sql)) {
        // Bind parameters
        $stmt->bind_param("iiss", $feedback_id, $student_id, $course_id, $content);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo '<script>alert("Feedback submitted successfully."); window.location.href = "new_view_students.php?action=add&success=1";</script>';
        } else {
            echo "Error: " . $conn->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: Course ID is not set or form is not submitted.";
}


// Close database connection
$conn->close();
?>
