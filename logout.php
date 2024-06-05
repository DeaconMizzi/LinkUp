<?php
session_start();
session_destroy(); // Destroy the session
echo "Logged out successfully"; // Debug statement
header("Location: login.php"); // Redirect to login page
exit();
?>
