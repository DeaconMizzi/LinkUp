<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkUp</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="/assets/js/scripts.js" defer></script>
</head>
<body>
<header>
    <div class="logo">
        <img src="assets/images/logo.png" alt="LinkUp Logo">
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="templates/pages/contact.php"><img src="assets/images/contact.png" alt="Contact"></a></li>
            <li><a href="templates/pages/faq.php"><img src="assets/images/faq.png" alt="FAQ"></a></li>
            <li class="profile-menu">
                <img src="assets/images/profile.png" alt="Profile">
                <div class="dropdown-content">
                    <a href="templates/authentication/login.php">Sign In</a>
                    <a href="templates/authentication/register.php">Sign Up</a>
                    <a href="templates/authentication/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
<main>