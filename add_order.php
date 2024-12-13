<?php
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
include 'includes/header.php';
include('db/db_connection.php');

// Initialize the cart session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding products to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Redirect to cart
    header('Location: cart.php');
    exit();
}

// Fetch products
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
</head>
<body>
    <h2>Product List</h2>
    <?php if (mysqli_num_rows($product_result) > 0): ?>
        <ul>
            <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                <li>
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['product_description']; ?></p>
                    <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" required>
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
</body>
<?php include 'includes/footer.php'; ?>
</html>
