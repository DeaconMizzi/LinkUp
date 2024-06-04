<?php
include 'includes/header.php';
?>
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
            <button class="btn-edit" onclick="location.href='/linkup/templates/account/edit_profile.php'">Edit Profile</button>
            <button class="btn-password" onclick="location.href='/linkup/templates/account/change_password.php'">Change Password</button>
            <button class="btn-delete" onclick="location.href='/linkup/templates/account/delete_profile.php'">Delete Profile</button>
        </div>
    </div>
</div>
