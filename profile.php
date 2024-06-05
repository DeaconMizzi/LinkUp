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
$sql = "SELECT username, email, bio, profile_picture FROM users WHERE user_id = $profile_user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Check if the logged-in user is following this profile
$isFollowing = false;
if ($profile_user_id !== $logged_in_user_id) {
    $follow_check_sql = "SELECT * FROM followers WHERE follower_id = $logged_in_user_id AND followee_id = $profile_user_id";
    $follow_check_result = $conn->query($follow_check_sql);
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
                <div class="profile-actions">
                    <button class="btn-edit" id="editProfileBtn">Edit Profile</button>
                    <button class="btn-password" id="changePasswordBtn">Change Password</button>
                    <button class="btn-delete" onclick="location.href='/linkup/templates/account/delete_profile.php'">Delete Profile</button>
                </div>
            <?php elseif ($logged_in_user_id): ?>
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
                $sql_followers = "SELECT users.username, users.profile_picture FROM followers 
                                  JOIN users ON followers.follower_id = users.user_id 
                                  WHERE followers.followee_id = $profile_user_id";
                $result_followers = $conn->query($sql_followers);
                if ($result_followers->num_rows > 0) {
                    while ($follower = $result_followers->fetch_assoc()) {
                        echo '<li><img src="' . htmlspecialchars($follower['profile_picture']) . '" alt="' . htmlspecialchars($follower['username']) . '"> ' . htmlspecialchars($follower['username']) . '</li>';
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
                $sql_following = "SELECT users.username, users.profile_picture FROM followers 
                                  JOIN users ON followers.followee_id = users.user_id 
                                  WHERE followers.follower_id = $profile_user_id";
                $result_following = $conn->query($sql_following);
                if ($result_following->num_rows > 0) {
                    while ($following = $result_following->fetch_assoc()) {
                        echo '<li><img src="' . htmlspecialchars($following['profile_picture']) . '" alt="' . htmlspecialchars($following['username']) . '"> ' . htmlspecialchars($following['username']) . '</li>';
                    }
                } else {
                    echo '<li>Not following anyone yet.</li>';
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
                    <textarea id="bio" name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
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
