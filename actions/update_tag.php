<?php
include '../includes/db.php';
session_start();

$tag_id = $_POST['tag_id'];
$new_tag_name = $_POST['new_tag_name'];

$sql = "UPDATE tags SET tag_name = ? WHERE tag_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $new_tag_name, $tag_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: ../tag_management.php");
exit();
?>
