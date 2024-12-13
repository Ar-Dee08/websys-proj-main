<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include('db/db_connection.php');

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
    $status = $_POST['status'];  // Get product status

    // Handle the uploaded image
    $prod_img = null;
    if (isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] == 0) {
        // Read the image content and store it as BLOB
        $prod_img = file_get_contents($_FILES['prod_img']['tmp_name']);
    }

    // Prepare statement to insert product into database
    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, category_id, status, prod_img) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $product_name, $product_description, $product_price, $category_id, $status, $prod_img); // Add prod_img to bind parameters

    // Execute the query
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
</head>
<body>
    <div class="container-1">
        <button onclick="window.history.back()" style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Back to Previous Page</button><br>
        <h2><b>Add a New Product</b></h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
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

            <label for="prod_img">Product Image:</label><br>
            <input type="file" name="prod_img" id="prod_img"><br><br>

            <input type="submit" name="submit" value="Add Product" style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px;">
        </form>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>
