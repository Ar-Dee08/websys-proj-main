<?php
ob_start(); // Start output buffering
session_start();
include 'includes/header.php';
include('db/db_connection.php');

// Handle removing items from the cart
if (isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Initialize variables
$order_success = false;
$order_details = [];

// Handle placing the order
if (isset($_POST['place_order'])) {
    $customer_name = $_POST['customer_name'];
    $order_items = $_SESSION['cart'];

    if (!empty($order_items)) {
        // Insert the order into the orders table
        $order_query = "INSERT INTO orders (customer_name, order_date) VALUES ('$customer_name', NOW())";
        if (mysqli_query($conn, $order_query)) {
            $order_id = mysqli_insert_id($conn);

            // Insert each item into the order_details table
            foreach ($order_items as $product_id => $quantity) {
                $product_query = "SELECT product_price FROM products WHERE id = $product_id";
                $product_result = mysqli_query($conn, $product_query);
                $product = mysqli_fetch_assoc($product_result);

                $price = $product['product_price'];
                $total = $price * $quantity;

                $order_detail_query = "INSERT INTO order_details (order_id, product_id, quantity, price, total) 
                                       VALUES ($order_id, $product_id, $quantity, $price, $total)";
                mysqli_query($conn, $order_detail_query);

                // Add to order details for display
                $order_details[] = [
                    'product_name' => $product['product_name'],
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ];
            }

            // Clear the cart
            $_SESSION['cart'] = [];
            $order_success = true;
        } else {
            echo "<p>Error placing order: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Your cart is empty!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <?php if ($order_success): ?>
        <h2>Order Placed Successfully</h2>
        <p>Thank you, <?php echo htmlspecialchars($customer_name); ?>! Here are your order details:</p>
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                        <td><?php echo $detail['quantity']; ?></td>
                        <td>₱<?php echo number_format($detail['price'], 2); ?></td>
                        <td>₱<?php echo number_format($detail['total'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="transaction.php">View All Transactions</a>
    <?php else: ?>
        <h2>Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <ul>
                <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
                    <?php
                    $product_query = "SELECT product_name, product_price FROM products WHERE id = $product_id";
                    $product_result = mysqli_query($conn, $product_query);
                    $product = mysqli_fetch_assoc($product_result);
                    ?>
                    <li>
                        <h3><?php echo $product['product_name']; ?></h3>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p>Price: ₱<?php echo number_format($product['product_price'], 2); ?></p>
                        <p>Total: ₱<?php echo number_format($product['product_price'] * $quantity, 2); ?></p>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="remove_item">Remove</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <h2>Place Order</h2>
        <form method="POST">
            <label for="customer_name">Customer Name:</label>
            <input type="text" name="customer_name" id="customer_name" required>
            <button type="submit" name="place_order">Place Order</button>
        </form>
    <?php endif; ?>
</body>
<?php include 'includes/footer.php'; ?>
</html>
