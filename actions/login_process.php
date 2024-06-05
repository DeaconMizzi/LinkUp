<?php
session_start();
include '../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user exists in the database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Password is correct
        $_SESSION['user_id'] = $user['user_id'];

        // Fetch user role
        $user_id = $user['user_id'];
        $role_sql = "SELECT userroles.role_name 
                     FROM userroleassignments 
                     JOIN userroles ON userroleassignments.role_id = userroles.role_id 
                     WHERE userroleassignments.user_id = ?";
        $role_stmt = $conn->prepare($role_sql);
        $role_stmt->bind_param('i', $user_id);
        $role_stmt->execute();
        $role_result = $role_stmt->get_result();

        if ($role_result->num_rows > 0) {
            $role = $role_result->fetch_assoc();
            $_SESSION['user_role'] = $role['role_name'];
        } else {
            $_SESSION['user_role'] = 'user'; // Default role if no role is assigned
        }

        header('Location: ../index.php');
        exit();
    } else {
        // Incorrect password
        $_SESSION['login_error'] = "Incorrect password. Please try again.";
    }
} else {
    // No user found with that email
    $_SESSION['login_error'] = "No account found with that email. Please register.";
}

header('Location: ../login.php');
exit();
?>
