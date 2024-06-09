<?php
session_start();
session_unset();
session_destroy();
header("Location: adminlogin.php"); // Redirect to login page after logout
exit;
?>