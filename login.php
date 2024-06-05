<?php
include 'includes/header.php';
?>

<div class="outer-container">
    <div class="container login-container">
        <h2>Welcome to LinkUp!</h2>
        <br>
        <h3>Log In</h3>
        <form action="actions/login_process.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">Log In</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here!</a></p>
    </div>
</div>

<!-- Modal for error message -->
<?php if (isset($_SESSION['login_error'])): ?>
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo $_SESSION['login_error']; ?></p>
        </div>
    </div>
    <?php unset($_SESSION['login_error']); ?>
<?php endif; ?>

<?php
include 'includes/footer.php';
?>


