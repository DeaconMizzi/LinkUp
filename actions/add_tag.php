<?php
include '../includes/db.php';
session_start();

$tag_name = $_POST['tag_name'];

$sql = "INSERT INTO tags (tag_name) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $tag_name);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: ../tag_management.php");
exit();
?>
