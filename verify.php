<?php
include('connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = mysqli_query($conn, "SELECT * FROM student WHERE id = $id");

    if (mysqli_num_rows($sql) > 0) {

        $update_query = "UPDATE student SET status = 1 WHERE id = $id";
        $update_sql = mysqli_query($conn, $update_query);

        if ($update_sql) {
            echo "Email verified successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid verification link.";
    }
} else {
    echo "Invalid request.";
}
?>
