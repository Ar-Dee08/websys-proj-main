<?php
// Start session and include necessary files
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/header.php';
require_once 'db/db_connection.php';

// Handle adding multiple products to cart
if (isset($_POST['add_multiple_to_cart']) && isset($_POST['id']) && is_array($_POST['id'])) {
    foreach ($_POST['id'] as $id) {
        $id = mysqli_real_escape_string($conn, $id);
        $quantity = isset($_POST['quantities'][$id]) ? (int)$_POST['quantities'][$id] : 1;

        // Fetch product details securely
        $product_query = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($product_query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product_result = $stmt->get_result();
        $product = $product_result->fetch_assoc();

        if ($product) {
            $cart_item = [
                'id' => $product['id'],
                'name' => $product['product_name'],
                'price' => $product['product_price'],
                'quantity' => $quantity,
            ];

            // Add to session cart
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = $cart_item;
            }
        }
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>
    <h2>Shopping Cart</h2>
    <a href="view_product.php">Back to Products</a>
    <form method="post">
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                        <tr>
                            <td><input type="checkbox" name="remove[]" value="<?php echo $item['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                            </td>
                            <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <button type="submit" name="update_cart">Update Quantities</button>
            <button type="submit" name="remove_items">Remove Selected Items</button>
            <button type="submit" name="checkout">Checkout</button>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </form>
</body>
<?php require_once 'includes/footer.php'; ?>
</html>
