<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];

try {
    // Start transaction
    $conn->begin_transaction();

    // Delete from likedposts
    $sql = "DELETE FROM likedposts WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    // Delete from stars
    $sql = "DELETE FROM stars WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    // Delete from posttags
    $sql = "DELETE FROM posttags WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    // Delete from comments
    $sql = "DELETE FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    // Delete the post itself
    $sql = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    header("Location: ../index.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo "Error deleting post: " . $e->getMessage();
}

$conn->close();
?>
