<?php
// Include necessary files
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);

include 'includes/header.php';
include('db/db_connection.php');

// Fetch all categories from the database
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);

// Check if query is successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories</title>
</head>
<body>
    <div class="container-1">
    <button onclick="window.history.back()">Back to Previous Page</button>
    <h2>Categories List</h2>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <ul>
                <?php while ($category = mysqli_fetch_assoc($result)) : ?>
                    <li>
                        <h3><?php echo $category['category_name']; ?></h3>
                        <p><?php echo $category['category_description']; ?></p>
                        <a href="edit_category.php?id=<?php echo $category['category_id']; ?>">Edit</a>
                        <a href="delete_category.php?id=<?php echo $category['category_id']; ?>">Delete</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No categories added yet.</p>
        <?php endif; ?>
        <a href="edit_category.php">Add New Category</a>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>