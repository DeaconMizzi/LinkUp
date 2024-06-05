<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$follower_id = $_SESSION['user_id'];
$followee_id = $_POST['followed_id'] ?? null;

if ($followee_id) {
    $sql = "DELETE FROM followers WHERE follower_id = ? AND followee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $follower_id, $followee_id);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
