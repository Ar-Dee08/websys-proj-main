<?php
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
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
$total_amount = 0; // Initialize total amount variable
$payment = 0; // Initialize payment amount
$change = 0; // Initialize change amount

// Handle placing the order and calculating change
if (isset($_POST['place_order'])) {
    $customer_name = $_POST['customer_name'];
    $order_items = $_SESSION['cart'];

    // Get payment amount if entered
    if (isset($_POST['payment'])) {
        $payment = $_POST['payment'];
    }

    if (!empty($order_items)) {
        // Insert the order into the orders table
        $order_query = "INSERT INTO orders (customer_name, order_date) VALUES ('$customer_name', NOW())";
        if (mysqli_query($conn, $order_query)) {
            $order_id = mysqli_insert_id($conn);

            // Insert each item into the order_details table
            foreach ($order_items as $product_id => $quantity) {
                $product_query = "SELECT product_name, product_price FROM products WHERE id = $product_id";
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

                // Add to the overall total amount
                $total_amount += $total;
            }

            // Calculate change if payment is provided
            if ($payment > 0) {
                $change = $payment - $total_amount; // Calculate change
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
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
    <title>Cart</title>
</head>
<body>
    <div class="container-1">
    <?php if ($order_success): ?>
        <h2>Order Placed Successfully</h2>
        <p>Thank you, <?php echo htmlspecialchars($customer_name ?: "Customer $order_id"); ?>! Here are your order details:</p>
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
        <p><strong>Total Amount: ₱<?php echo number_format($total_amount, 2); ?></strong></p>
        <p><strong>Payment: ₱<?php echo number_format($payment, 2); ?></strong></p>
        <?php if ($payment >= $total_amount): ?>
            <p><strong>Change: ₱<?php echo number_format($change, 2); ?></strong></p>
        <?php else: ?>
            <p><strong>Insufficient payment. Additional amount required: ₱<?php echo number_format(abs($change), 2); ?></strong></p>
        <?php endif; ?>
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
                    $total = $product['product_price'] * $quantity;
                    $total_amount += $total; // Calculate total amount for all items
                    ?>
                    <li>
                        <h3><?php echo $product['product_name']; ?></h3>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p>Price: ₱<?php echo number_format($product['product_price'], 2); ?></p>
                        <p>Total: ₱<?php echo number_format($total, 2); ?></p>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="remove_item">Remove</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h3>Total Amount: ₱<?php echo number_format($total_amount, 2); ?></h3>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <!-- Add New Order Button -->
        <h2>Add More Products to Your Cart</h2>
        <a href="add_order.php">
            <button>Add New Order</button>
        </a>
        <h2>Place Order</h2>
        <form method="POST">
            <label for="customer_name">Customer Name:</label>
            <input type="text" name="customer_name" id="customer_id"><br><br>
            <label for="payment">Enter Payment Amount:</label>
            <input type="number" name="payment" id="payment" min="0" step="0.01" required><br><br>
            <button type="submit" name="place_order">Place Order</button>
        </form>
    <?php endif; ?>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>