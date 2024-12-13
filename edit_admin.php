<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db/db_connection.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    die("Admin ID is required.");
}

$id = $_GET['id'];

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

    $sql = "UPDATE user_login SET username='$edit_username', email='$edit_email'";
    if ($edit_password) {
        $sql .= ", password='$edit_password'";
    }
    $sql .= " WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
</head>
<body>
    <div class="container-1">
        <h1>Edit Admin</h1>
        <form action="edit_admin.php?id=<?= $id ?>" method="POST">
            <input type="text" name="username" value="<?= $admin['username'] ?>" required>
            <input type="email" name="email" value="<?= $admin['email'] ?>" required>
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
