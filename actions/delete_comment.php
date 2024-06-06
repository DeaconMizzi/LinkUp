<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['Admin', 'Mod'])) {
    header("Location: ../login.php");
    exit();
}

$comment_id = $_POST['comment_id'] ?? null;

if (!$comment_id) {
    echo "No comment ID provided.";
    exit();
}

$sql = "DELETE FROM comments WHERE comment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $comment_id);

if ($stmt->execute()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error deleting comment.";
}

$conn->close();
?>
