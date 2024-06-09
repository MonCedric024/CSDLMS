<?php
$server = "localhost";
$username = "root";
$pass = "";
$db = "lms";
$conn = mysqli_connect($server, $username, $pass, $db);
if (!$conn) {
    echo '<script>alert("Connection Falied")</script>';
}
?>