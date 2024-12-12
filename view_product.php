<?php
// Start session and include necessary files
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);

include 'includes/header.php';
include('db/db_connection.php');

// Fetch all categories from the database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Check if query is successful
if (!$category_result) {
    echo "Error: " . mysqli_error($conn);
}

// Check if a category is selected
if (isset($_GET['category']) && $_GET['category'] != '') {
    $category_id = $_GET['category'];
    $query = "SELECT * FROM products WHERE category_id = '$category_id'";
} else {
    $query = "SELECT * FROM products";
}

// Fetch all products from the database
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
    <title>View Products</title>
</head>
<body>
    <h2>Products List</h2>
    
    <!-- Category Dropdown -->
    <select id="category-dropdown" name="category" onchange="window.location.href='view_product.php?category='+this.value">
        <option value="">All Categories</option>
        <?php while ($category = mysqli_fetch_assoc($category_result)) : ?>
            <option value="<?php echo $category['category_id']; ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $category['category_id']) echo 'selected'; ?>>
                <?php echo $category['category_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
    
    <!-- Product List -->
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <ul>
            <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                <li>
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['product_description']; ?></p>
                    <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                    
                    <!-- Add to Cart Form -->
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity_<?php echo $product['id']; ?>">Quantity:</label>
                        <input type="number" name="quantity" id="quantity_<?php echo $product['id']; ?>" value="1" min="1">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No products added yet.</p>
    <?php endif; ?>
</body>
<?php include 'includes/footer.php'; ?>
</html>
