<?php
session_start();
include 'includes/db.php'; // Make sure to include database connection

$userProfilePicture = 'assets/images/profile.png'; // Default profile picture

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT profile_picture FROM users WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userProfilePicture = htmlspecialchars($row['profile_picture']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/linkup/assets/css/styles.css">
    <script src="/linkup/assets/js/scripts.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div class="logo">
        <a href="index.php"><img src="assets/images/logo.png" alt="LinkUp Logo"></a>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="contact.php"><img src="assets/images/contact.png" alt="Contact"></a></li>
            <li><a href="faq.php"><img src="assets/images/faq.png" alt="FAQ"></a></li>
            <li class="profile-menu">
                <img src="<?php echo $userProfilePicture; ?>" alt="Profile">
                <div class="dropdown-content">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="profile.php">Profile</a>
                        <a href="user_management.php">User Management</a>
                        <a href="role_management.php">Role Management</a>
                        <a href="logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login.php">Sign In</a>
                        <a href="register.php">Sign Up</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
</header>
