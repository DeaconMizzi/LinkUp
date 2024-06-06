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
$star_check_sql = "SELECT * FROM stars WHERE user_id = $user_id AND post_id = $post_id";
$star_check_result = $conn->query($star_check_sql);

if ($star_check_result->num_rows > 0) {
    // User has already liked the post, remove the like
    $remove_star_sql = "DELETE FROM stars WHERE user_id = $user_id AND post_id = $post_id";
    $conn->query($remove_star_sql);
} else {
    // User has not liked the post, add a new like
    $add_star_sql = "INSERT INTO stars (user_id, post_id) VALUES ($user_id, $post_id)";
    $conn->query($add_star_sql);
}

$conn->close();
header("Location: $redirect_to");
exit();
?>
