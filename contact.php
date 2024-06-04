<?php include 'includes/header.php'; ?>

    <div class="outer-container">
        <div class="container contact-container">
            <h2>Contact Us</h2>
            <form method="post" action="contact.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send</button>
            </form>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>