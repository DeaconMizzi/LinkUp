<?php
session_start();
include '../includes/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$bio = $_POST['bio'];

// Update the user's information in the database
$sql = "UPDATE users SET username = ?, bio = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $bio, $user_id);

if ($stmt->execute()) {
    // Update the session variables
    $_SESSION['username'] = $username;
    $_SESSION['bio'] = $bio;
    header("Location: ../profile.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
