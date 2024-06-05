<?php
include 'includes/header.php';
include 'includes/db.php';
?>

<div class="outer-container">
    <div class="container">
        <div class="create-post">
            <h2>Create Post</h2>
            <form action="actions/create_post.php" method="post">
                <div class="form-group">
                    <label for="tag">Tag</label>
                    <select id="tag" name="tag">
                        <?php
                        // Fetch tags from the database
                        $sql = "SELECT * FROM tags";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['tag_id'] . '">' . $row['tag_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter Post Title">
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
        $sql = "SELECT posts.*, tags.tag_name, users.username, users.profile_picture 
                FROM posts 
                JOIN posttags ON posts.post_id = posttags.post_id
                JOIN tags ON posttags.tag_id = tags.tag_id
                JOIN users ON posts.user_id = users.user_id
                ORDER BY posts.post_id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="post-container">';
                echo '<div class="post">';
                echo '<div class="post-header">';
                echo '<img class="post-avatar" src="' . htmlspecialchars($row["profile_picture"]) . '" alt="Profile Picture">';
                echo '<div class="post-details">';
                echo '<h3 class="post-title"><a href="post.php?id=' . $row["post_id"] . '">' . htmlspecialchars($row["title"]) . '</a></h3>';
                echo '<div class="post-tag">' . htmlspecialchars($row["tag_name"]) . '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="post-content"><p>' . htmlspecialchars($row["content"]) . '</p></div>';
                echo '<div class="post-actions">';
                echo '<button class="btn-star"><img src="/linkup/assets/images/star.png" alt="Star"></button>';
                echo '<button class="btn-comment"><img src="/linkup/assets/images/comment.png" alt="Comment"></button>';
                echo '<button class="btn-share" onclick="sharePost(\'https://yourdomain.com/post/' . $row["post_id"] . '\')"><img src="/linkup/assets/images/share.png" alt="Share"></button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
