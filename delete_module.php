<?php
include('connect.php');

// Check if assignment_id is provided in the POST data
if(isset($_POST['module_id'])) {
    $module_id = $_POST['module_id'];
    
    // Query to delete assignment from the database
    $delete_query = "DELETE FROM module WHERE module_id = '$module_id'";
    
    // Execute the query
    if(mysqli_query($conn, $delete_query)) {
        // Assignment deleted successfully
        echo "success";
    } else {
        // Error occurred while deleting assignment
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If assignment_id is not provided, return an error message
    echo "No module provided.";
}
?>
