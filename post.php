<?php
include 'includes/header.php';

// Get the post ID from the URL
$post_id = $_GET['id'];

// Fetch post data from database
$conn = new mysqli("localhost", "username", "password", "database");
$sql = "SELECT title, content, tag FROM posts WHERE post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $content = $row["content"];
    $tag = $row["tag"];
} else {
    echo "Post not found.";
    exit();
}
$conn->close();
?>

<div class="outer-container">
    <div class="container">
        <div class="post-container">
            <div class="post">
                <div class="post-header">
                    <img class="post-avatar" src="/linkup/assets/images/profile.png" alt="Profile Picture">
                    <h3 class="post-title"><?php echo $title; ?></h3>
                </div>
                <div class="post-tag"><?php echo $tag; ?></div>
                <div class="post-content">
                    <p><?php echo $content; ?></p>
                </div>
                <div class="post-actions">
                    <button class="btn-star"><img src="/linkup/assets/images/star.png" alt="Star"></button>
                    <button class="btn-comment"><img src="/linkup/assets/images/comment.png" alt="Comment"></button>
                    <button class="btn-share" onclick="sharePost('https://yourdomain.com/post/<?php echo $post_id; ?>')"><img src="/linkup/assets/images/share.png" alt="Share"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
