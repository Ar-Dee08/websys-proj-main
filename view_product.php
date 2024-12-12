<?php
// Start session and include necessary files
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/header.php';
require_once 'db/db_connection.php';

// Fetch all categories
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
if (!$category_result) {
    die("Error fetching categories: " . mysqli_error($conn));
}

// Filter products by category if selected
$category_id = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$query = $category_id ? 
    "SELECT * FROM products WHERE category_id = '$category_id'" : 
    "SELECT * FROM products";

// Fetch all products
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching products: " . mysqli_error($conn));
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
            <option value="<?php echo htmlspecialchars($category['category_id']); ?>" 
                <?php if ($category_id == $category['category_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($category['category_name']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    
    <!-- Product List -->
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <ul>
            <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                <li>
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['product_description']); ?></p>
                    <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                    
                    <!-- Add to Cart Form -->
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <label for="quantity_<?php echo $product['id']; ?>">Quantity:</label>
                        <input type="number" name="quantity" id="quantity_<?php echo $product['id']; ?>" value="1" min="1">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
</body>
<?php require_once 'includes/footer.php'; ?>
</html>
