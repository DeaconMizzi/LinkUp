<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$comment_id = $_POST['comment_id'] ?? null;
$post_id = $_POST['post_id'] ?? null;

if ($comment_id && $post_id) {
    // Delete the comment from the database
    $sql = "DELETE FROM comments WHERE comment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $comment_id);

    if ($stmt->execute()) {
        // Redirect back to the post page
        header("Location: ../post.php?id=" . $post_id);
        exit();
    } else {
        echo "Error deleting comment: " . $stmt->error;
    }
} else {
    echo "No comment ID provided.";
}

$conn->close();
?>
