<?php
include 'includes/header.php';
?>

<div class="outer-container">
    <div class="container">
        <div class="create-post">
            <h2>Create Post</h2>
            <form action="create_post.php" method="post">
                <div class="form-group">
                    <label for="tag">Tag</label>
                    <input type="text" id="tag" name="tag" placeholder="Tag">
                </div>
                <div class="form-group">
                    <label for="content">Enter Post text...</label>
                    <textarea id="content" name="content" rows="4" placeholder="Enter Post text..."></textarea>
                </div>
                <button type="submit" class="btn-post">Post</button>
            </form>
        </div>

        <!-- Fetch posts from database and loop through them -->
        <?php
        // Example connection and query to fetch posts
        $conn = new mysqli("localhost", "username", "password", "database");
        $sql = "SELECT post_id, title, content, tag FROM posts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $post_id = $row["post_id"];
                $title = $row["title"];
                $content = $row["content"];
                $tag = $row["tag"];
                ?>

                <div class="post-container">
                    <div class="post">
                        <div class="post-header">
                            <img class="post-avatar" src="/linkup/assets/images/profile.png" alt="Profile Picture">
                            <a href="post.php?id=<?php echo $post_id; ?>"><h3 class="post-title"><?php echo $title; ?></h3></a>
                        </div>
                        <div class="post-tag"><?php echo $tag; ?></div>
                        <div class="post-content">
                            <p><?php echo substr($content, 0, 100); ?>...</p> <!-- Display a preview of the content -->
                        </div>
                        <div class="post-actions">
                            <button class="btn-star"><img src="/linkup/assets/images/star.png" alt="Star"></button>
                            <button class="btn-comment"><img src="/linkup/assets/images/comment.png" alt="Comment"></button>
                            <button class="btn-share" onclick="sharePost('https://yourdomain.com/post/<?php echo $post_id; ?>')"><img src="/linkup/assets/images/share.png" alt="Share"></button>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<p>No posts available.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
