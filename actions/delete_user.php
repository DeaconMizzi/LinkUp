<?php
include '../includes/db.php';
session_start();

$logged_in_user_id = $_SESSION['user_id'] ?? null;
$user_id_to_delete = $_POST['user_id'] ?? null;

if (!$logged_in_user_id) {
    header("Location: ../login.php");
    exit();
}

// If the user is deleting their own account or if the user is an admin or mod
if ($user_id_to_delete == $logged_in_user_id || in_array($_SESSION['user_role'], ['Admin', 'Mod'])) {
    // Delete the user
    $delete_user_sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_user_sql);
    $stmt->bind_param('i', $user_id_to_delete);
    $stmt->execute();

    // Optionally, you can delete related data from other tables if needed
    // For example, deleting from likedposts table
    $delete_likedposts_sql = "DELETE FROM likedposts WHERE user_id = ?";
    $stmt = $conn->prepare($delete_likedposts_sql);
    $stmt->bind_param('i', $user_id_to_delete);
    $stmt->execute();

    $conn->close();

    // If the user deleted their own profile, destroy the session and redirect to login
    if ($user_id_to_delete == $logged_in_user_id) {
        session_destroy();
        header("Location: ../login.php");
        exit();
    } else {
        header("Location: ../user_management.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
