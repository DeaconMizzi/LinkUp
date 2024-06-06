<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$post_id = $_POST['post_id'] ?? null;

if ($post_id) {
    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Delete related entries from posttags
        $sql_posttags = "DELETE FROM posttags WHERE post_id = ?";
        $stmt_posttags = $conn->prepare($sql_posttags);
        $stmt_posttags->bind_param('i', $post_id);
        $stmt_posttags->execute();

        // Delete related entries from comments
        $sql_comments = "DELETE FROM comments WHERE post_id = ?";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param('i', $post_id);
        $stmt_comments->execute();

        // Delete related entries from stars
        $sql_stars = "DELETE FROM stars WHERE post_id = ?";
        $stmt_stars = $conn->prepare($sql_stars);
        $stmt_stars->bind_param('i', $post_id);
        $stmt_stars->execute();

        // Delete the post from the database
        $sql_posts = "DELETE FROM posts WHERE post_id = ?";
        $stmt_posts = $conn->prepare($sql_posts);
        $stmt_posts->bind_param('i', $post_id);
        $stmt_posts->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect back to index.php
        header("Location: ../index.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Error deleting post: " . $e->getMessage();
    }
} else {
    echo "No post ID provided.";
}

$conn->close();
?>
