<?php
include 'includes/header.php';
include 'includes/db.php';

$post_id = $_GET['id']; // Get the post ID from the URL
$logged_in_user_id = $_SESSION['user_id'] ?? null;

// Fetch the post details and the user who created the post
$sql = "SELECT posts.*, users.username, users.profile_picture FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        WHERE post_id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div class="outer-container">
        <div class="container">
            <div class="post-detail-container">
                <div class="post-header">
                    <img class="post-avatar" src="<?php echo htmlspecialchars($row['profile_picture']) ?: '/linkup/assets/images/profile.png'; ?>" alt="Profile Picture">
                    <div class="post-header-content">
                        <h2 class="post-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p class="post-username">Posted by: <?php echo htmlspecialchars($row['username']); ?></p>
                    </div>
                </div>
                <div class="post-content"><?php echo htmlspecialchars($row['content']); ?></div>
                <div class="post-actions">
                    <?php
                    // Check if the user has already liked the post
                    $is_starred = false;
                    if ($logged_in_user_id) {
                        $star_check_sql = "SELECT * FROM stars WHERE user_id = $logged_in_user_id AND post_id = $post_id";
                        $star_check_result = $conn->query($star_check_sql);
                        $is_starred = $star_check_result->num_rows > 0;
                    }

                    // Count the number of likes for this post
                    $star_count_sql = "SELECT COUNT(*) AS star_count FROM stars WHERE post_id = $post_id";
                    $star_count_result = $conn->query($star_count_sql);
                    $star_count_row = $star_count_result->fetch_assoc();
                    $star_count = $star_count_row['star_count'];
                    ?>
                    <form action="actions/add_star.php" method="post" class="star-form">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <button type="submit" class="btn-star">
                            <img src="/linkup/assets/images/<?php echo $is_starred ? 'starred.png' : 'star.png'; ?>" alt="Star">
                        </button>
                        <span class="star-count"><?php echo $star_count; ?></span>
                    </form>
                    <button class="btn-comment" onclick="highlightAddComment()"><img src="/linkup/assets/images/comment.png" alt="Comment"></button>
                    <button class="btn-share" onclick="sharePost('http://localhost/linkup/post.php?id=<?php echo $row['post_id']; ?>')"><img src="/linkup/assets/images/share.png" alt="Share"></button>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="comments-section">
                <h3>Comments</h3>
                <ul class="comments-list">
                    <?php
                    // Fetch comments for the post along with the user who posted each comment
                    $sql_comments = "SELECT comments.*, users.username, users.profile_picture FROM comments 
                                    JOIN users ON comments.user_id = users.user_id 
                                    WHERE post_id = $post_id";
                    $result_comments = $conn->query($sql_comments);

                    if ($result_comments->num_rows > 0) {
                        while ($comment = $result_comments->fetch_assoc()) {
                            echo '<li>';
                            echo '<img class="comment-avatar" src="' . htmlspecialchars($comment['profile_picture']) . '" alt="Profile Picture">';
                            echo '<div class="comment-content-wrapper">';
                            echo '<p class="comment-username">' . htmlspecialchars($comment['username']) . '</p>';
                            echo '<div class="comment-content">' . htmlspecialchars($comment['content']) . '</div>';
                            if (in_array($logged_in_user_id, ['admin', 'mod'])) {
                                echo '<form action="actions/delete_comment.php" method="post">';
                                echo '<input type="hidden" name="comment_id" value="' . $comment['comment_id'] . '">';
                                echo '<button type="submit" class="btn-delete">Delete</button>';
                                echo '</form>';
                            }
                            echo '</div>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li>No comments yet. Be the first to comment!</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Add Comment Section -->
            <div id="addCommentSection" class="add-comment-section">
                <h3>Add a Comment</h3>
                <form action="actions/add_comment.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <div class="form-group">
                        <textarea name="comment" rows="4" placeholder="Enter your comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn-post">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "Post not found.";
}

$conn->close();

include 'includes/footer.php';
?>
