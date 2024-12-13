<?php
// Include necessary files
include 'includes/header.php';
include('db/db_connection.php');

// Fetch all orders with customer details and calculate the total amount
$query = "
    SELECT orders.id AS order_id, 
           orders.customer_id, 
           customers.customer_name, 
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
    <h2>Transaction Records</h2>
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
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($order = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td>
                            <?php 
                                echo !empty($order['customer_name']) 
                                    ? htmlspecialchars($order['customer_name']) 
                                    : "Customer ID: " . htmlspecialchars($order['customer_id']); 
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No transactions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
<?php include 'includes/footer.php'; ?>
</html>
