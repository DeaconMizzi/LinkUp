<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$follower_id = $_SESSION['user_id'];
$followee_id = $_POST['followee_id'];

// Insert follow relationship into the database
$sql = "INSERT INTO followers (follower_id, followee_id) VALUES ($follower_id, $followee_id)";
$conn->query($sql);

header("Location: ../profile.php?id=$followee_id");
?>
