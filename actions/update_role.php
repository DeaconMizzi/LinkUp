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

// Update user role
$user_id = $_POST['user_id'];
$new_role = $_POST['new_role'];

// Fetch the role_id of the new role
$sql = "SELECT role_id FROM userroles WHERE role_name = '$new_role'";
$result = $conn->query($sql);
$new_role_id = $result->fetch_assoc()['role_id'];

// Delete current role assignment
$delete_role_sql = "DELETE FROM userroleassignments WHERE user_id = $user_id";
$conn->query($delete_role_sql);

// Insert new role assignment
$insert_role_sql = "INSERT INTO userroleassignments (user_id, role_id) VALUES ($user_id, $new_role_id)";
$conn->query($insert_role_sql);

$conn->close();
header("Location: ../role_management.php");
exit();
?>
