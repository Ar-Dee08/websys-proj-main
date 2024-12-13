<?php
// Include necessary files
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);

include 'includes/header.php';
include('db/db_connection.php');

// Check if category ID is provided
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $query = "SELECT * FROM categories WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);
}

// Handle form submission
if (isset($_POST['submit'])) {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (isset($_GET['id'])) {
        // Update existing category
        $query = "UPDATE categories SET category_name = '$category_name', category_description = '$category_description' WHERE category_id = '$category_id'";
    } else {
        // Insert new category
        $query = "INSERT INTO categories (category_name, category_description) VALUES ('$category_name', '$category_description')";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: view_category.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>
    <div class="container-1">
        <form action="" method="post">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" value="<?php echo (isset($category)) ? $category['category_name'] : ''; ?>">
            <br><br>
            <label for="category_description">Category Description:</label>
            <textarea id="category_description" name="category_description"><?php echo (isset($category)) ? $category['category_description'] : ''; ?></textarea>
            <br><br>
            <input type="submit" name="submit" value="<?php echo (isset($_GET['id'])) ? 'Update' : 'Add'; ?>">
        </form>
    </div>
    <h2><?php echo (isset($_GET['id'])) ? 'Edit Category' : 'Add New Category'; ?></h2>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>