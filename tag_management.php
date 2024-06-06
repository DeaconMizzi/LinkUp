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

// Fetch all tags
$sql = "SELECT * FROM tags";
$result = $conn->query($sql);

$conn->close();
?>

<div class="tag-management-container">
    <h2>Tag Management</h2>
    <form action="actions/add_tag.php" method="post">
        <div class="form-group">
            <label for="tag_name">New Tag Name:</label>
            <input type="text" id="tag_name" name="tag_name" required>
        </div>
        <button type="submit" class="btn-add">Add Tag</button>
    </form>
    <table class="tag-table">
        <thead>
        <tr>
            <th>Tag ID</th>
            <th>Tag Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['tag_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['tag_name']) . '</td>';
                echo '<td>';
                echo '<form action="actions/update_tag.php" method="post" style="display:inline-block;">';
                echo '<input type="hidden" name="tag_id" value="' . $row['tag_id'] . '">';
                echo '<input type="text" name="new_tag_name" value="' . htmlspecialchars($row['tag_name']) . '">';
                echo '<button type="submit" class="btn-update">Update</button>';
                echo '</form>';
                echo '<form action="actions/delete_tag.php" method="post" style="display:inline-block;">';
                echo '<input type="hidden" name="tag_id" value="' . $row['tag_id'] . '">';
                echo '<button type="submit" class="btn-delete">Delete</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">No tags found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
