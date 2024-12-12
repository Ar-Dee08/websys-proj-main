<?php
// Start session and include necessary files
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);

include 'includes/header.php';
include('db/db_connection.php');

// Handle adding products to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details
    $product_query = "SELECT * FROM products WHERE id = '$product_id'";
    $product_result = mysqli_query($conn, $product_query);
    $product = mysqli_fetch_assoc($product_result);

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
            if ($item['id'] == $product_id) {
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

// Handle updating quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $key => $quantity) {
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }
}

// Handle removing items
if (isset($_POST['remove_items'])) {
    foreach ($_POST['remove'] as $key) {
        unset($_SESSION['cart'][$key]);
    }
}

// Handle checkout (example placeholder)
if (isset($_POST['checkout'])) {
    echo "<script>alert('Checkout completed!')</script>";
    unset($_SESSION['cart']);
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
                            <td><input type="checkbox" name="remove[]" value="<?php echo $key; ?>"></td>
                            <td><?php echo $item['name']; ?></td>
                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo $key; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
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
<?php include 'includes/footer.php'; ?>
</html>
