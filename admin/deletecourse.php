<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "LMS";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $course_id = htmlspecialchars($_GET['id']);

    $sql = "DELETE FROM course WHERE course_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        $connection->close();
        header("Location: admincourses.php");
        exit;
    } else {
        echo "Error deleting course: " . $stmt->error;
    }
} else {
    header("Location: admincourses.php");
    exit;
}
?>
