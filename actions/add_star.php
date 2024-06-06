<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$redirect_to = $_POST['redirect_to'] ?? '../index.php';

// Check if the user has already liked the post
$star_check_sql = "SELECT * FROM stars WHERE user_id = ? AND post_id = ?";
$stmt = $conn->prepare($star_check_sql);
$stmt->bind_param('ii', $user_id, $post_id);
$stmt->execute();
$star_check_result = $stmt->get_result();

if ($star_check_result->num_rows > 0) {
    // User has already liked the post, remove the like
    $remove_star_sql = "DELETE FROM stars WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($remove_star_sql);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();

    // Remove from likedposts table
    $remove_like_sql = "DELETE FROM likedposts WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($remove_like_sql);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();
} else {
    // User has not liked the post, add a new like
    $add_star_sql = "INSERT INTO stars (user_id, post_id) VALUES (?, ?)";
    $stmt = $conn->prepare($add_star_sql);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();

    // Add to likedposts table
    $add_like_sql = "INSERT INTO likedposts (user_id, post_id) VALUES (?, ?)";
    $stmt = $conn->prepare($add_like_sql);
    $stmt->bind_param('ii', $user_id, $post_id);
    $stmt->execute();
}

$conn->close();
header("Location: $redirect_to");
exit();
?>
