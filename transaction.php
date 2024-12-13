<?php
session_start();
include 'includes/header.php';
include('db/db_connection.php');

// Fetch all order details with joined information
$query = "
    SELECT 
        o.id AS order_id, 
        o.customer_name, 
        o.order_date, 
        p.product_name, 
        od.quantity, 
        od.price, 
        od.total 
    FROM order_details od
    JOIN orders o ON od.order_id = o.id
    JOIN products p ON od.product_id = p.id
    ORDER BY o.order_date DESC, o.id DESC";
$result = mysqli_query($conn, $query);
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
    <h2>All Transactions</h2>
    <button onclick="window.location.href='add_order.php'">Add New Order</button>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>₱<?php echo number_format($row['price'], 2); ?></td>
                        <td>₱<?php echo number_format($row['total'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No transactions yet.</p>
    <?php endif; ?>
    </div>
</body>
<?php include 'includes/footer.php'; ?>
</html>
