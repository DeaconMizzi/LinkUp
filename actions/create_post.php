<?php
include '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    $title = $conn->real_escape_string($_POST['title']);
    $tag_id = $conn->real_escape_string($_POST['tag']);
    $image_path = null;

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');  // Redirect to login page if not logged in
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/uploads/";

        // Create the uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = "/linkup/assets/uploads/" . basename($_FILES["image"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Insert the post into the database
    $sql = "INSERT INTO posts (user_id, title, content, image_path) VALUES ('$user_id', '$title', '$content', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        // Get the ID of the newly created post
        $post_id = $conn->insert_id;

        // Insert the post-tag relationship into the posttags table
        $sql_tag = "INSERT INTO posttags (post_id, tag_id) VALUES ('$post_id', '$tag_id')";
        $conn->query($sql_tag);

        header('Location: ../index.php');  // Redirect to home page after successful post creation
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
