<?php
session_start();
include '../includes/db.php';

if (isset($_SESSION['user_id']) && isset($_POST['followed_id'])) {
    $follower_id = $_SESSION['user_id'];
    $followed_id = $_POST['followed_id'];

    $sql = "DELETE FROM followers WHERE follower_id = $follower_id AND followee_id = $followed_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: ../login.php");
}

$conn->close();
?>
