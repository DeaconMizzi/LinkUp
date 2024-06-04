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
            <button class="btn-edit" id="editProfileBtn">Edit Profile</button>
            <button class="btn-password" onclick="location.href='/linkup/templates/account/change_password.php'">Change Password</button>
            <button class="btn-delete" onclick="location.href='/linkup/templates/account/delete_profile.php'">Delete Profile</button>
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

<?php include 'includes/footer.php'; ?>

<script>
    // Get the modal
    var modal = document.getElementById("editProfileModal");

    // Get the button that opens the modal
    var btn = document.getElementById("editProfileBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
