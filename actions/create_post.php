<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $title = "Post Title";  // Placeholder title, change as necessary
    $tag_id = $_POST['tag'];  // Get the selected tag ID

    // Insert the post into the database
    $sql = "INSERT INTO posts (user_id, title, content) VALUES (1, '$title', '$content')";  // Assuming user_id 1 for now

    if ($conn->query($sql) === TRUE) {
        // Get the ID of the newly created post
        $post_id = $conn->insert_id;

        // Insert the post-tag relationship into the posttags table
        $sql_tag = "INSERT INTO posttags (post_id, tag_id) VALUES ($post_id, $tag_id)";
        $conn->query($sql_tag);

        header('Location: ../index.php');  // Redirect to home page after successful post creation
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
