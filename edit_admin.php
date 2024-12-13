<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/db_connection.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    die("Admin ID is required.");
}

$id = $_GET['id'];

// Allow only the admin with ID 1 to edit admin credentials
if ($_SESSION['user_id'] != 1) {
    die("You do not have permission to edit admin credentials.");
}

// Fetch the admin details
$sql = "SELECT * FROM user_login WHERE id = '$id'";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Admin not found.");
}

$admin = $result->fetch_assoc();

// Handle form submission for updating admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_admin'])) {
    $edit_username = $_POST['username'];
    $edit_email = $_POST['email'];
    $edit_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    // Use prepared statements to prevent SQL injection
    if ($edit_password) {
        $stmt = $conn->prepare("UPDATE user_login SET username = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $edit_username, $edit_email, $edit_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE user_login SET username = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $edit_username, $edit_email, $id);
    }

    if ($stmt->execute()) {
        header("Location: view_admin.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-1">
        <h1>Edit Admin</h1>
        <form action="edit_admin.php?id=<?= htmlspecialchars($id) ?>" method="POST">
            <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
            <input type="password" name="password" placeholder="New password (optional)">
            <button type="submit" name="edit_admin">Update Admin</button>
        </form>
        <a href="view_admin.php">Back to Admins List</a>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>

<?php
$conn->close();
?>
