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

    // Highlight the add comment section
    window.highlightAddComment = function() {
        const addCommentSection = document.getElementById('addCommentSection');
        addCommentSection.scrollIntoView({ behavior: 'smooth' });
        addCommentSection.style.transition = 'background-color 0.5s ease';
        addCommentSection.style.backgroundColor = '#ffffcc';
        setTimeout(() => {
            addCommentSection.style.backgroundColor = '#fff';
        }, 2000);
    }

    window.sharePost = function(url) {
        if (navigator.share) {
            navigator.share({
                title: 'Check out this post!',
                url: url
            }).then(() => {
                console.log('Thanks for sharing!');
            }).catch(console.error);
        } else {
            copyToClipboard(url);
            alert('Link copied to clipboard. You can now share it manually.');
        }
    };

    function copyToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.style.position = 'fixed';
        textArea.style.top = 0;
        textArea.style.left = 0;
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.padding = 0;
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';
        textArea.style.background = 'transparent';
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
        } catch (err) {
            console.error('Unable to copy to clipboard', err);
        }
        document.body.removeChild(textArea);
    }

    // Character limit for bio
    const bioTextarea = document.getElementById('bio');
    const bioCharCount = document.getElementById('bio-char-count');
    const maxBioLength = 160;

    if (bioTextarea) {
        bioTextarea.addEventListener('input', () => {
            const remaining = maxBioLength - bioTextarea.value.length;
            bioCharCount.textContent = `${remaining} characters remaining`;
        });
    }

    // Minimum and Maximum Length for Username
    const usernameInput = document.getElementById('username');
    const usernameValidation = document.getElementById('usernameValidation');
    const minUsernameLength = 3;
    const maxUsernameLength = 20;

    if (usernameInput) {
        usernameInput.addEventListener('input', () => {
            const usernameLength = usernameInput.value.length;
            if (usernameLength < minUsernameLength) {
                usernameValidation.textContent = `Username must be at least ${minUsernameLength} characters long.`;
            } else if (usernameLength > maxUsernameLength) {
                usernameValidation.textContent = `Username must be no more than ${maxUsernameLength} characters long.`;
            } else {
                usernameValidation.textContent = '';
            }
        });
    }

    // Confirmation dialog for profile deletion
    const deleteProfileBtn = document.getElementById('deleteProfileBtn');
    if (deleteProfileBtn) {
        deleteProfileBtn.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to delete your profile? This action cannot be undone.")) {
                document.getElementById('deleteProfileForm').submit();
            }
        });
    }

    // Validation for Change Password Form
    const changePasswordForm = document.getElementById('changePasswordForm');
    const currentPasswordInput = document.getElementById('current-password');
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const currentPasswordValidation = document.getElementById('currentPasswordValidation');
    const newPasswordValidation = document.getElementById('newPasswordValidation');
    const confirmPasswordValidation = document.getElementById('confirmPasswordValidation');

    const minPasswordLength = 6;
    const maxPasswordLength = 20;

    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', (event) => {
            let valid = true;

            // Check current password
            if (currentPasswordInput.value.length < minPasswordLength) {
                currentPasswordValidation.textContent = `Current password must be at least ${minPasswordLength} characters long.`;
                valid = false;
            } else {
                currentPasswordValidation.textContent = '';
            }

            // Check new password
            if (newPasswordInput.value.length < minPasswordLength || newPasswordInput.value.length > maxPasswordLength) {
                newPasswordValidation.textContent = `New password must be between ${minPasswordLength} and ${maxPasswordLength} characters long.`;
                valid = false;
            } else {
                newPasswordValidation.textContent = '';
            }

            // Check if new password and confirm password match
            if (newPasswordInput.value !== confirmPasswordInput.value) {
                confirmPasswordValidation.textContent = 'New password and confirm password do not match.';
                valid = false;
            } else {
                confirmPasswordValidation.textContent = '';
            }

            // If validation fails, prevent form submission
            if (!valid) {
                event.preventDefault();
            }
        });
    }
});
