<?php
include 'includes/header.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'] ?? null;

// Fetch the role of the logged-in user
$logged_in_user_role = 'User';
if ($user_id) {
    $sql = "SELECT userroles.role_name 
            FROM users 
            LEFT JOIN userroleassignments ON users.user_id = userroleassignments.user_id 
            LEFT JOIN userroles ON userroleassignments.role_id = userroles.role_id 
            WHERE users.user_id = $user_id";
    $result = $conn->query($sql);
    $logged_in_user_role = $result->fetch_assoc()['role_name'] ?? 'User';
}

?>

<div class="outer-container">
    <div class="container">
        <div class="create-post">
            <h2>Create Post</h2>
            <form action="actions/create_post.php" method="post" enctype="multipart/form-data">
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
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" id="image" name="image">
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
                // Check if the user has a profile picture; if not, use the default
                $profile_picture = $row['profile_picture'] ? htmlspecialchars($row['profile_picture']) : '/linkup/assets/images/profile.png';

                // Count the number of likes for this post
                $star_count_sql = "SELECT COUNT(*) AS star_count FROM stars WHERE post_id = " . $row['post_id'];
                $star_count_result = $conn->query($star_count_sql);
                $star_count_row = $star_count_result->fetch_assoc();
                $star_count = $star_count_row['star_count'];

                // Check if the user has already liked the post
                $is_starred = false;
                if ($user_id) {
                    $star_check_sql = "SELECT * FROM stars WHERE user_id = $user_id AND post_id = " . $row['post_id'];
                    $star_check_result = $conn->query($star_check_sql);
                    $is_starred = $star_check_result->num_rows > 0;
                }

                echo '<div class="post-container">';
                echo '<div class="post">';
                echo '<div class="post-header">';
                echo '<div class="post-avatar-container">';
                echo '<a href="profile.php?id=' . $row['user_id'] . '">';
                echo '<img class="post-avatar" src="' . $profile_picture . '" alt="Profile Picture">';
                echo '</a>';
                echo '<div class="post-username">' . htmlspecialchars($row["username"]) . '</div>';
                echo '</div>';
                echo '<div class="post-details">';
                echo '<h3 class="post-title">' . htmlspecialchars($row["title"]) . '</h3>';
                echo '<div class="post-tag">' . htmlspecialchars($row["tag_name"]) . '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="post-content">';
                if ($row['image_path']) {
                    echo '<img src="' . $row['image_path'] . '" alt="Post Image" class="post-image">';
                }
                echo '<p>' . htmlspecialchars($row["content"]) . '</p>';
                echo '</div>';
                echo '<div class="post-actions">';
                echo '<form action="actions/add_star.php" method="post" class="star-form">';
                echo '<input type="hidden" name="post_id" value="' . $row['post_id'] . '">';
                echo '<input type="hidden" name="redirect_to" value="../index.php">';
                echo '<button type="submit" class="btn-star">';
                echo '<img src="/linkup/assets/images/' . ($is_starred ? 'starred.png' : 'star.png') . '" alt="Star">';
                echo '</button>';
                echo '<span class="star-count">' . $star_count . '</span>';
                echo '</form>';
                echo '<a href="post.php?id=' . $row["post_id"] . '"><button class="btn-comment"><img src="/linkup/assets/images/comment.png" alt="Comment"></button></a>';
                echo '<button class="btn-share" onclick="sharePost(\'http://localhost/linkup/post.php?id=' . $row["post_id"] . '\')"><img src="/linkup/assets/images/share.png" alt="Share"></button>';

                // Add the delete button for admin and mod users
                if ($logged_in_user_role == 'Admin' || $logged_in_user_role == 'Mod') {
                    echo '<form action="actions/delete_post.php" method="post" class="delete-form">';
                    echo '<input type="hidden" name="post_id" value="' . $row['post_id'] . '">';
                    echo '<button type="submit" class="btn-delete">';
                    echo '<img src="/linkup/assets/images/delete.png" alt="Delete">';
                    echo '</button>';
                    echo '</form>';
                }

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

<?php
include 'includes/footer.php';
?>
