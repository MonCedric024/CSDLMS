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
    $instructor_id = htmlspecialchars($_GET['id']);

    $sql = "DELETE FROM instructor WHERE instructor_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $instructor_id);

    if ($stmt->execute()) {
        $connection->close();
        header("Location: admininstructor.php");
        exit;
    } else {
        echo "Error deleting instructor: " . $stmt->error;
    }
} else {
    header("Location: admininstructor.php");
    exit;
}
?>
