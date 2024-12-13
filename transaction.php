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
           orders.customer_id, 
           COALESCE(customers.customer_name, CONCAT('Customer ID: ', orders.customer_id)) AS customer_display,
           orders.order_date, 
           SUM(order_details.quantity * order_details.price) AS total_amount
    FROM orders
    LEFT JOIN customers ON orders.customer_id = customers.customer_id
    LEFT JOIN order_details ON orders.id = order_details.order_id
    GROUP BY orders.id
    ORDER BY orders.id DESC";
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
</head>
<body>
    <div class="container-1">
        <h2>Transaction Records</h2>
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
                            <td><?php echo htmlspecialchars($order['customer_display'] ?? 'N/A'); ?></td> <!-- Using customer_display -->
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
