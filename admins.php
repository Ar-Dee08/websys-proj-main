<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db/db_connection.php';
include 'includes/header.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_admin'])) {
        // Add new admin account
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO user_login (username, email, password) VALUES ('$new_username', '$new_email', '$new_password')";
        if ($conn->query($sql) === TRUE) {
            echo "New admin added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['edit_admin'])) {
        // Edit admin account
        $id = $_POST['id'];
        $edit_username = $_POST['username'];
        $edit_email = $_POST['email'];
        $edit_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

        $sql = "UPDATE user_login SET username='$edit_username', email='$edit_email'";
        if ($edit_password) {
            $sql .= ", password='$edit_password'";
        }
        $sql .= " WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Admin updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch all admins
$sql = "SELECT id, username, email FROM user_login";
$result = $conn->query($sql);

// Check if the result is valid
if (!$result) {
    die("Error fetching admins: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins List</title>
</head>
<body>
    <h1>Admins List</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <form action="admins.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="username" value="<?= $row['username'] ?>" required>
                        <input type="email" name="email" value="<?= $row['email'] ?>" required>
                        <input type="password" name="password" placeholder="New password (optional)">
                        <button type="submit" name="edit_admin">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add New Admin</h2>
    <form action="admins.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add_admin">Add Admin</button>
    </form>
</body>
<?php include 'includes/footer.php'; ?>
</html>

<?php
// Close the connection
$conn->close();
?>
