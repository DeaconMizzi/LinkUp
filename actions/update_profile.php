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
$profile_picture = $_FILES['profile_picture'];

// Check if a new profile picture was uploaded
if ($profile_picture['error'] == UPLOAD_ERR_OK) {
    $target_dir = "../assets/uploads/";
    $target_file = $target_dir . basename($profile_picture["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($profile_picture["tmp_name"]);
    if ($check !== false) {
        // Check file size (limit to 2MB)
        if ($profile_picture["size"] <= 2000000) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                // Move uploaded file to the target directory
                if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
                    // Update the profile picture path in the database
                    $profile_picture_path = 'assets/uploads/' . basename($profile_picture["name"]);
                    $sql = "UPDATE users SET profile_picture = '$profile_picture_path' WHERE user_id = $user_id";
                    $conn->query($sql);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }
}

// Update username and bio in the database
$sql = "UPDATE users SET username = '$username', bio = '$bio' WHERE user_id = $user_id";
if ($conn->query($sql) === TRUE) {
    header("Location: ../profile.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
