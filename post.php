<?php
include 'includes/header.php';
include 'includes/db.php';

$post_id = $_GET['id']; // Get the post ID from the URL

$sql = "SELECT * FROM posts WHERE post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div class="post-detail-container">
        <h2 class="post-title"><?php echo $row['title']; ?></h2>
        <div class="post-tag"><?php echo $row['tag']; ?></div>
        <div class="post-content"><?php echo $row['content']; ?></div>
    </div>
    <?php
} else {
    echo "Post not found.";
}

$conn->close();

include 'includes/footer.php';
?>
