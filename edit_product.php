<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include('db/db_connection.php');

// Check if the product ID is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details from the database
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Handle image upload
    $prod_img = $product['prod_img']; // Default to existing image
    if (isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] == UPLOAD_ERR_OK) {
        $prod_img = file_get_contents($_FILES['prod_img']['tmp_name']);
    }

    // Update the product in the database
    $update_query = "UPDATE products SET product_name='$product_name', product_description='$product_description', product_price='$product_price', category_id='$category_id', status='$status', prod_img=? WHERE id='$id'";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "b", $prod_img);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_product.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

// Fetch all categories for the dropdown
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <div class="container-1">
        <h2>Edit Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br>

            <label for="product_description">Product Description:</label>
            <textarea id="product_description" name="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea><br>

            <label for="product_price">Product Price:</label>
            <input type="number" id="product_price" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" step="0.01" required><br>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <?php while ($category = mysqli_fetch_assoc($category_result)) : ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php if ($category['category_id'] == $product['category_id']) echo 'selected'; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="Active" <?php if ($product['status'] == 'Active') echo 'selected'; ?>>Active</option>
                <option value="Removed" <?php if ($product['status'] == 'Removed') echo 'selected'; ?>>Removed</option>
            </select><br>

            <label for="prod_img">Product Image:</label>
            <input type="file" name="prod_img" id="prod_img" accept="image/*"><br>
            <?php if (!empty($product['prod_img'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['prod_img']); ?>" alt="Product Image" width="150"><br>
            <?php endif; ?>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
<footer>
    <?php include 'includes/footer.php'; ?>
</footer> 
</html>
