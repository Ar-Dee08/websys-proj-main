<?php
// Include necessary files
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

    // Prepare statement to insert product into database
    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, category_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $product_name, $product_description, $product_price, $category_id); // "ssdi" means string, string, decimal, integer

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
    <title>Edit Profile - Add Product</title>
</head>
<body>
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

        <input type="submit" name="submit" value="Add Product">
    </form>
</body>
<?php include 'includes/footer.php'; ?>
</html>