<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include 'db/db_connection.php';

// Fetch all categories from the database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Check if query is successful
if (!$category_result) {
    echo "Error: " . mysqli_error($conn);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    // Handle file upload
    $product_image = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "uploads/";
        $product_image = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $product_image);
    }

    // Add product to database
    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, category_id, status, product_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $product_name, $product_description, $product_price, $category_id, $status, $product_image);
    $stmt->execute();
    header("Location: view_product.php");
    if ($stmt->execute()) {
        echo "Product added successfully!";
        header("Location: view_product.php");  // Redirect to product gallery after adding product
        exit();
    } else {
        echo "Error: " . $stmt->error;  // Show error message if query fails
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Crumbs & Brew</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-1">
        <button onclick="window.history.back()">Back to Previous Page</button>
        <h2>Add a New Product</h2>
        <form action="add_product.php" method="POST">
            <label for="product_name">Product Name:</label><br>
            <input type="text" name="product_name" id="product_name" required><br><br>

            <label for="product_description">Product Description:</label><br>
            <textarea name="product_description" id="product_description" required></textarea><br><br>

            <label for="product_price">Product Price:</label><br>
            <input type="number" name="product_price" id="product_price" required><br><br>

            <label for="category_id">Category:</label><br>
            <select name="category_id" id="category_id" required>
                <option value="">Select a category</option>
                <?php while ($category = mysqli_fetch_assoc($category_result)) : ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="status">Product Status:</label><br>
            <select name="status" id="status" required>
                <option value="Active">Active</option>
                <option value="Removed">Removed</option>
            </select><br><br>

            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <!-- Other fields -->
                <label for="product_image">Product Image:</label><br>
                <input type="file" name="product_image" id="product_image" accept="image/*"><br><br>
                <input type="submit" name="submit" value="Add Product">
            </form>
</footer> 
</html>
