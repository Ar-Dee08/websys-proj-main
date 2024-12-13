<?php
// Include necessary files
include 'includes/header.php';
include('db/db_connection.php');

// Fetch all customers
$query = "SELECT * FROM customers ORDER BY customer_id ASC";
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
    <title>Customers</title>
</head>
<body>
    <h2>Customer Records</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($customer = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $customer['customer_id']; ?></td>
                        <td><?php echo !empty($customer['customer_name']) ? htmlspecialchars($customer['customer_name']) : 'N/A'; ?></td>
                        <td>
                            <a href="edit_customer.php?id=<?php echo $customer['customer_id']; ?>">Edit</a>
                            <a href="delete_customer.php?id=<?php echo $customer['customer_id']; ?>" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No customers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="add_customer.php">Add New Customer</a>
</body>
<?php include 'includes/footer.php'; ?>
</html>
