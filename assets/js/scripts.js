document.addEventListener('DOMContentLoaded', (event) => {
    // Get the modals
    var editProfileModal = document.getElementById("editProfileModal");
    var changePasswordModal = document.getElementById("changePasswordModal");

    // Get the buttons that open the modals
    var editProfileBtn = document.getElementById("editProfileBtn");
    var changePasswordBtn = document.getElementById("changePasswordBtn");

    // Get the <span> elements that close the modals
    var closeBtns = document.getElementsByClassName("close");

    // When the user clicks the button, open the respective modal
    if (editProfileBtn) {
        editProfileBtn.onclick = function() {
            editProfileModal.style.display = "block";
        }
    }

    if (changePasswordBtn) {
        changePasswordBtn.onclick = function() {
            changePasswordModal.style.display = "block";
        }
    }

    // When the user clicks on <span> (x), close the respective modal
    for (let i = 0; i < closeBtns.length; i++) {
        closeBtns[i].onclick = function() {
            this.parentElement.parentElement.style.display = "none";
        }
    }

    // When the user clicks anywhere outside of the modals, close them
    window.onclick = function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = "none";
        }
        if (event.target == changePasswordModal) {
            changePasswordModal.style.display = "none";
        }
    }
});
