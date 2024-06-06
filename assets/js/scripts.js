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
});
