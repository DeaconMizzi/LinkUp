<?php
include '../includes/db.php';
session_start();

$tag_id = $_POST['tag_id'];

$sql = "DELETE FROM tags WHERE tag_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $tag_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: ../tag_management.php");
exit();
?>
