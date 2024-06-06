document.addEventListener('DOMContentLoaded', (event) => {
    // Validation for Registration Form
    const registerForm = document.getElementById('registerForm');
    const emailInput = document.getElementById('email');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const emailError = document.getElementById('emailError');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    // Strict email validation pattern
    const strictEmailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Function to show error message
    function showError(input, message) {
        input.nextElementSibling.textContent = message;
        input.classList.add('error');
    }

    // Function to clear error message
    function clearError(input) {
        input.nextElementSibling.textContent = '';
        input.classList.remove('error');
    }

    // Registration form validation function
    function validateRegisterForm(event) {
        let valid = true;

        // Validate email
        if (!strictEmailPattern.test(emailInput.value)) {
            showError(emailInput, 'Invalid email format');
            valid = false;
        } else {
            clearError(emailInput);
        }

        // Validate username (min 3, max 20 characters)
        if (usernameInput.value.length < 3 || usernameInput.value.length > 20) {
            showError(usernameInput, 'Username must be between 3 and 20 characters');
            valid = false;
        } else {
            clearError(usernameInput);
        }

        // Validate password (min 6, max 20 characters)
        if (passwordInput.value.length < 6 || passwordInput.value.length > 20) {
            showError(passwordInput, 'Password must be between 6 and 20 characters');
            valid = false;
        } else {
            clearError(passwordInput);
        }

        // Validate confirm password
        if (passwordInput.value !== confirmPasswordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match');
            valid = false;
        } else {
            clearError(confirmPasswordInput);
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if invalid
        }
    }

    if (registerForm) {
        registerForm.addEventListener('submit', validateRegisterForm);
    }

    // Validation for Login Form
    const loginForm = document.getElementById('loginForm');
    const loginEmailInput = document.getElementById('email');
    const loginPasswordInput = document.getElementById('password');
    const loginEmailError = document.getElementById('emailError');
    const loginPasswordError = document.getElementById('passwordError');

    // Loosened email validation pattern to allow admin@admin
    const looseEmailPattern = /^[^\s@]+@[^\s@]+$/;

    // Login form validation function
    function validateLoginForm(event) {
        let valid = true;

        // Validate email
        if (!looseEmailPattern.test(loginEmailInput.value)) {
            showError(loginEmailInput, 'Invalid email format');
            valid = false;
        } else {
            clearError(loginEmailInput);
        }

        // Validate password (not empty)
        if (loginPasswordInput.value.trim() === '') {
            showError(loginPasswordInput, 'Password cannot be empty');
            valid = false;
        } else {
            clearError(loginPasswordInput);
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if invalid
        }
    }

    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }

    // Existing modal behavior for Edit Profile and Change Password
    var editProfileModal = document.getElementById("editProfileModal");
    var changePasswordModal = document.getElementById("changePasswordModal");
    var editProfileBtn = document.getElementById("editProfileBtn");
    var changePasswordBtn = document.getElementById("changePasswordBtn");
    var closeBtns = document.getElementsByClassName("close");

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

    for (let i = 0; i < closeBtns.length; i++) {
        closeBtns[i].onclick = function() {
            this.parentElement.parentElement.style.display = "none";
        }
    }

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
});
