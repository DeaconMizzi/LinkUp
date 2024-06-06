<?php
include '../includes/db.php';
session_start();

$logged_in_user_id = $_SESSION['user_id'] ?? null;

if (!$logged_in_user_id) {
    header("Location: ../login.php");
    exit();
}

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    echo "New password and confirm password do not match.";
    exit();
}

// Fetch the current password hash from the database
$sql = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($current_password, $user['password'])) {
    echo "Current password is incorrect.";
    exit();
}

// Update the password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $new_password_hash, $logged_in_user_id);
$stmt->execute();

header("Location: ../profile.php?id=$logged_in_user_id");
exit();
?>
