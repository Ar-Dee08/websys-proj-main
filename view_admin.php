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

// Set the number of items per page
$items_per_page = 10;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $items_per_page;

// Fetch the total number of admins
$total_items_sql = "SELECT COUNT(*) AS total FROM user_login";
$total_items_result = $conn->query($total_items_sql);
$total_items_row = $total_items_result->fetch_assoc();
$total_items = $total_items_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_items / $items_per_page);

// Fetch the admins for the current page
$sql = "SELECT id, username, email FROM user_login LIMIT $items_per_page OFFSET $offset";
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
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
    <style>
        table, th, td {
            background-color: white;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container-1">
        <br><h1><strong>Admins List</strong></h1>
        <p style="color: red;">Note: Only the moderator can edit admin credentials.</p>
        <table style="width: 100%;">
            <tr>
                <th><strong>ID</strong></th>
                <th><strong>Username</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>Actions</strong></th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <?php if ($_SESSION['user_id'] == 1): ?>
                            <a href="edit_admin.php?id=<?= htmlspecialchars($row['id']) ?>">Edit</a>
                        <?php else: ?>
                            <span style="color: gray;">Edit Disabled</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Pagination -->
        <div>
            <br>
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" <?= $i === $page ? 'style="font-weight: bold;"' : '' ?>>
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>">Next</a>
            <?php endif; ?>
        </div>

        <br>
        <a href="add_admin.php">
            <button style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px;">Add New Account</button>
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
