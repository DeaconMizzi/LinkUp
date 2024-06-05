<?php
include '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    $title = $conn->real_escape_string($_POST['title']);
    $tag_id = $conn->real_escape_string($_POST['tag']);

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');  // Redirect to login page if not logged in
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Insert the post into the database
    $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";

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
