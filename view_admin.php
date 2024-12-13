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
    <div class="container-1">
        <br><h1>Admins List</h1>
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
                        <a href="edit_admin.php?id=<?= $row['id'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <br>
        <a href="add_admin.php">
            <button>Add New Account</button>
        </a>
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
