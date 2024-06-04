<?php
include 'includes/header.php';
?>
<div class="profile-wrapper">
    <div class="profile-container">
        <div class="profile-header">
            <img class="profile-img" src="/linkup/assets/images/profile.png" alt="Profile Picture">
            <h2 class="profile-name">YourUsername01</h2>
        </div>
        <div class="profile-details">
            <div class="profile-info">
                <label for="email"><b>Email:</b></label>
                <p class="profile-email">YourUsername01@gmail.com</p>
            </div>
            <div class="profile-info">
                <label for="bio"><b>Bio:</b></label>
                <p class="profile-bio">Making Prototypes and Testing them!</p>
            </div>
            <div class="profile-actions">
                <button class="btn-edit" id="editProfileBtn">Edit Profile</button>
                <button class="btn-password" id="changePasswordBtn">Change Password</button>
                <button class="btn-delete" onclick="location.href='/linkup/templates/account/delete_profile.php'">Delete Profile</button>
            </div>
        </div>
    </div>

    <div class="followers-following-container">
        <!-- Followers Section -->
        <div class="followers-section">
            <h3>Followers</h3>
            <ul id="followers-list">
                <!-- Example followers, replace with dynamic content -->
                <li><img src="/linkup/assets/images/profile.png" alt="Follower 1"> Follower 1</li>
                <li><img src="/linkup/assets/images/profile.png" alt="Follower 2"> Follower 2</li>
                <!-- Add more followers here -->
            </ul>
        </div>

        <!-- Following Section -->
        <div class="following-section">
            <h3>Following</h3>
            <ul id="following-list">
                <!-- Example following, replace with dynamic content -->
                <li><img src="/linkup/assets/images/profile.png" alt="Following 1"> Following 1</li>
                <li><img src="/linkup/assets/images/profile.png" alt="Following 2"> Following 2</li>
                <!-- Add more following here -->
            </ul>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Profile</h2>
        <form method="post" action="update_profile.php">
            <div class="form-group">
                <label for="username">Change Username:</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="bio">Change Bio:</label>
                <textarea id="bio" name="bio"></textarea>
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

<?php include 'includes/footer.php'; ?>
