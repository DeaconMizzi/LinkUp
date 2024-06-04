<?php
include 'includes/header.php';
?>

<div class="outer-container">
    <div class="container signup-container">
        <h2>Welcome to LinkUp!</h2><br>
        <h3>Register</h3>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Log In!</a></p>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
