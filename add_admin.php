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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO user_login (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $new_username, $new_email, $new_password);

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
    <title>Add New Admin</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-1">
        <h1>Add New Admin</h1>
        <form action="add_admin.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="add_admin">Add Admin</button>
        </form>
        <br>
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
