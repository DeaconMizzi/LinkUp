<?php
include 'includes/header.php';
include 'includes/db.php';

// Ensure the user is a mod or admin
$logged_in_user_id = $_SESSION['user_id'] ?? null;

if (!$logged_in_user_id) {
    header("Location: login.php");
    exit();
}

// Fetch the role of the logged-in user
$sql = "SELECT userroles.role_name 
        FROM users 
        LEFT JOIN userroleassignments ON users.user_id = userroleassignments.user_id 
        LEFT JOIN userroles ON userroleassignments.role_id = userroles.role_id 
        WHERE users.user_id = $logged_in_user_id";
$result = $conn->query($sql);
$logged_in_user_role = $result->fetch_assoc()['role_name'] ?? 'User';

if ($logged_in_user_role != 'Mod' && $logged_in_user_role != 'Admin') {
    header("Location: index.php");
    exit();
}

// Fetch all users and their roles
$sql = "SELECT users.user_id, users.username, users.email, userroles.role_name 
        FROM users 
        LEFT JOIN userroleassignments ON users.user_id = userroleassignments.user_id 
        LEFT JOIN userroles ON userroleassignments.role_id = userroles.role_id";
$result = $conn->query($sql);

$conn->close();
?>

<div class="role-management-container">
    <h2>Role Management</h2>
    <table class="role-table">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Current Role</th>
            <th>New Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['role_name'] ?? 'User') . '</td>';
                echo '<td>';
                echo '<form action="actions/update_role.php" method="post">';
                echo '<input type="hidden" name="user_id" value="' . $row['user_id'] . '">';
                echo '<select name="new_role">';
                echo '<option value="User">User</option>';
                echo '<option value="Mod">Mod</option>';
                echo '<option value="Admin">Admin</option>';
                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<button type="submit" class="btn-assign">Assign Role</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No users found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
