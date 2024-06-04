<?php
include 'includes/header.php';
include 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        // Check if email or username already exists
        $sql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Email or Username already exists!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
                // Redirect to login page or login the user automatically
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    $conn->close();
}
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
