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
    $student_id = htmlspecialchars($_GET['id']);

    $sql = "DELETE FROM student WHERE student_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        $connection->close();
        header("Location: adminstudent.php");
        exit;
    } else {
        echo "Error deleting student: " . $stmt->error;
    }
} else {
    header("Location: adminstudent.php");
    exit;
}
?>
