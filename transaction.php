<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include('db/db_connection.php');

// Fetch all orders with customer details and calculate the total amount
$query = "
    SELECT orders.id AS order_id, 
           orders.customer_name,  -- Directly get customer_name from orders table
           orders.customer_id,    -- Also fetch customer_id if customer_name is empty
           orders.order_date, 
           SUM(order_details.quantity * order_details.price) AS total_amount
    FROM orders
    LEFT JOIN order_details ON orders.id = order_details.order_id
    GROUP BY orders.id
    ORDER BY orders.id ASC";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-1">
        <h2><strong>Transaction Records</strong></h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></td>
                            <td>
                            <?php
                                // If customer_name is not set, show customer_id, ensure no null value is passed
                                echo htmlspecialchars($order['customer_name'] ?? $order['customer_id'] ?? 'Unknown');
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($order['order_date'] ?? 'N/A'); ?></td>
                            <td>₱<?php echo number_format($order['total_amount'] ?? 0, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No transactions found. Add some orders to display them here.</p>
        <?php endif; ?>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>
