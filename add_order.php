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
    // Check if any products were selected
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        // Loop through the selected products and add them to the cart
        foreach ($_POST['product_id'] as $index => $product_id) {
            $quantity = $_POST['quantity'][$index];

            // Check if the product is already in the cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity; // Update quantity if product exists
            } else {
                $_SESSION['cart'][$product_id] = $quantity; // Add new product to cart
            }
        }

        // Redirect to the cart page after adding products
        header('Location: cart.php');
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "<p>No products selected to add to the cart.</p>";
    }
}

// Fetch products from the database
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
    <div class="container-1">
        <button onclick="window.history.back()" style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Back to Previous Page</button><br>
        <h2>Product List</h2>
        <form method="POST">
            <?php if (mysqli_num_rows($product_result) > 0): ?>
                <ul>
                    <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                        <li>
                            <input type="checkbox" name="product_id[]" value="<?php echo $product['id']; ?>" id="product_<?php echo $product['id']; ?>">
                            <label for="product_<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></label><br>
                            <p><?php echo $product['product_description']; ?></p>
                            <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                            <label for="quantity_<?php echo $product['id']; ?>">Quantity:</label>
                            <input type="number" name="quantity[]" id="quantity_<?php echo $product['id']; ?>" min="1" value="1" required><br><br>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <button type="submit" name="add_to_cart">Add to Cart</button>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>