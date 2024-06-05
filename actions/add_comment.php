<?php
include '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $content = $conn->real_escape_string($_POST['comment']);

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');  // Redirect to login page if not logged in
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Insert the comment into the database
    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";

    if ($conn->query($sql) === TRUE) {
        header('Location: ../post.php?id=' . $post_id);  // Redirect back to the post page after successful comment
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
