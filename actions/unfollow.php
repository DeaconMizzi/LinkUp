<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$follower_id = $_SESSION['user_id'];
$followee_id = $_POST['followee_id'];

// Remove follow relationship from the database
$sql = "DELETE FROM followers WHERE follower_id = $follower_id AND followee_id = $followee_id";
$conn->query($sql);

header("Location: ../profile.php?id=$followee_id");
?>
