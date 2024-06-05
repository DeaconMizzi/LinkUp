<?php
include '../includes/db.php';
session_start();

// Ensure the user is a mod or admin
$logged_in_user_id = $_SESSION['user_id'] ?? null;

if (!$logged_in_user_id) {
    header("Location: ../login.php");
    exit();
}

// Fetch the role of the logged-in user
$sql = "SELECT userroles.role_name 
        FROM users 
        LEFT JOIN userroleassignments ON users.user_id = userroleassignments.user_id 
        LEFT JOIN userroles ON userroleassignments.role_id = userroles.role_id 
        WHERE users.user_id = $logged_in_user_id";
$result = $conn->query($sql);
$logged_in_user_role = $result->fetch_assoc()['role_name'] ?? 'User';

if ($logged_in_user_role != 'Mod' && $logged_in_user_role != 'Admin') {
    header("Location: ../index.php");
    exit();
}

// Delete user
$user_id = $_POST['user_id'];
$delete_user_sql = "DELETE FROM users WHERE user_id = $user_id";
$conn->query($delete_user_sql);

// Optionally, you can delete related data from other tables if needed

$conn->close();
header("Location: ../user_management.php");
exit();
?>
