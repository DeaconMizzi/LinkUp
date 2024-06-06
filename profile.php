<?php
include 'includes/header.php';
include 'includes/db.php';

$logged_in_user_id = $_SESSION['user_id'] ?? null;
$profile_user_id = $_GET['id'] ?? $logged_in_user_id;

if (!$logged_in_user_id) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database
$sql = "SELECT username, email, bio, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $profile_user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Check if the logged-in user is following this profile
$isFollowing = false;
if ($profile_user_id !== $logged_in_user_id) {
    $follow_check_sql = "SELECT * FROM followers WHERE follower_id = ? AND followee_id = ?";
    $stmt = $conn->prepare($follow_check_sql);
    $stmt->bind_param('ii', $logged_in_user_id, $profile_user_id);
    $stmt->execute();
    $follow_check_result = $stmt->get_result();
    $isFollowing = $follow_check_result->num_rows > 0;
}
?>

<div class="profile-wrapper">
    <div class="profile-container">
        <div class="profile-header">
            <img class="profile-img" src="<?php echo $user['profile_picture'] ? htmlspecialchars($user['profile_picture']) : '/linkup/assets/images/profile.png'; ?>" alt="Profile Picture">
            <h2 class="profile-name"><?php echo htmlspecialchars($user['username']); ?></h2>
        </div>
        <div class="profile-details">
            <div class="profile-info">
                <label for="email"><b>Email:</b></label>
                <p class="profile-email"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="profile-info">
                <label for="bio"><b>Bio:</b></label>
                <p class="profile-bio"><?php echo htmlspecialchars($user['bio']); ?></p>
            </div>
            <?php if ($profile_user_id === $logged_in_user_id): ?>
                <!-- Buttons for the logged-in user's own profile -->
                <div class="profile-actions">
                    <button class="btn-edit" id="editProfileBtn">Edit Profile</button>
                    <button class="btn-password" id="changePasswordBtn">Change Password</button>
                    <button class="btn-delete" onclick="location.href='/linkup/templates/account/delete_profile.php'">Delete Profile</button>
                </div>
            <?php elseif ($logged_in_user_id): ?>
                <!-- Follow/Unfollow button for viewing other users' profiles -->
                <div class="profile-actions">
                    <form action="actions/<?php echo $isFollowing ? 'unfollow.php' : 'follow.php'; ?>" method="post">
                        <input type="hidden" name="followee_id" value="<?php echo $profile_user_id; ?>">
                        <button type="submit" class="btn-follow"><?php echo $isFollowing ? 'Unfollow' : 'Follow'; ?></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="followers-following-container">
        <!-- Followers Section -->
        <div class="followers-section">
            <h3>Followers</h3>
            <ul id="followers-list">
                <?php
                $sql_followers = "SELECT users.user_id, users.username, users.profile_picture FROM followers 
                                  JOIN users ON followers.follower_id = users.user_id 
                                  WHERE followers.followee_id = ?";
                $stmt = $conn->prepare($sql_followers);
                $stmt->bind_param('i', $profile_user_id);
                $stmt->execute();
                $result_followers = $stmt->get_result();
                if ($result_followers->num_rows > 0) {
                    while ($follower = $result_followers->fetch_assoc()) {
                        $profile_picture = $follower['profile_picture'] ? htmlspecialchars($follower['profile_picture']) : '/linkup/assets/images/profile.png';
                        echo '<li><a href="profile.php?id=' . htmlspecialchars($follower['user_id']) . '"><img src="' . $profile_picture . '" alt="' . htmlspecialchars($follower['username']) . '">' . htmlspecialchars($follower['username']) . '</a></li>';
                    }
                } else {
                    echo '<li>No followers yet.</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Following Section -->
        <div class="following-section">
            <h3>Following</h3>
            <ul id="following-list">
                <?php
                $sql_following = "SELECT users.user_id, users.username, users.profile_picture FROM followers 
                                  JOIN users ON followers.followee_id = users.user_id 
                                  WHERE followers.follower_id = ?";
                $stmt = $conn->prepare($sql_following);
                $stmt->bind_param('i', $profile_user_id);
                $stmt->execute();
                $result_following = $stmt->get_result();
                if ($result_following->num_rows > 0) {
                    while ($following = $result_following->fetch_assoc()) {
                        $profile_picture = $following['profile_picture'] ? htmlspecialchars($following['profile_picture']) : '/linkup/assets/images/profile.png';
                        echo '<li><a href="profile.php?id=' . htmlspecialchars($following['user_id']) . '"><img src="' . $profile_picture . '" alt="' . htmlspecialchars($following['username']) . '">' . htmlspecialchars($following['username']) . '</a></li>';
                    }
                } else {
                    echo '<li>Not following anyone yet.</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Liked Posts Section -->
        <div class="liked-posts-container">
            <h3>Liked Posts</h3>
            <ul class="liked-posts-list">
                <?php
                $sql_liked_posts = "SELECT posts.post_id, posts.title, posts.content, posts.user_id, users.username, users.profile_picture 
                                    FROM likedposts 
                                    JOIN posts ON likedposts.post_id = posts.post_id 
                                    JOIN users ON posts.user_id = users.user_id 
                                    WHERE likedposts.user_id = ?";
                $stmt = $conn->prepare($sql_liked_posts);
                $stmt->bind_param('i', $profile_user_id);
                $stmt->execute();
                $result_liked_posts = $stmt->get_result();
                if ($result_liked_posts->num_rows > 0) {
                    while ($liked_post = $result_liked_posts->fetch_assoc()) {
                        $profile_picture = $liked_post['profile_picture'] ? htmlspecialchars($liked_post['profile_picture']) : '/linkup/assets/images/profile.png';
                        echo '<li class="liked-post-item">';
                        echo '<a href="post.php?id=' . htmlspecialchars($liked_post['post_id']) . '">';
                        echo '<img src="' . $profile_picture . '" alt="' . htmlspecialchars($liked_post['username']) . '">';
                        echo '<div>';
                        echo '<h4>' . htmlspecialchars($liked_post['title']) . '</h4>';
                        echo '</div>';
                        echo '</a>';
                        echo '</li>';
                    }
                } else {
                    echo '<li>No liked posts yet.</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<?php if ($profile_user_id === $logged_in_user_id): ?>
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Profile</h2>
            <form method="post" action="actions/update_profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Change Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                </div>
                <div class="form-group">
                    <label for="bio">Change Bio:</label>
                    <textarea id="bio" name="bio" maxlength="160"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                    <p id="bio-char-count">160 characters remaining</p>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Change Profile Picture:</label>
                    <input type="file" id="profile_picture" name="profile_picture">
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Change Password</h2>
            <form>
                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="password" id="current-password" name="current-password" required>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
