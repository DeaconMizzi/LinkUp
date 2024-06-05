<?php
session_start();
include '../includes/db.php';

// Check if the user is an admin or mod
$user_role = $_SESSION['user_role'] ?? null;
if ($user_role !== 'admin' && $user_role !== 'mod') {
    header('Location: ../index.php');
    exit();
}

$post_id = $_POST['post_id'] ?? null;

if ($post_id) {
    // Delete the post
    $sql = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $stmt->close();
}

header('Location: ../index.php');
exit();
?>
