<?php
// Include necessary files
include 'includes/header.php';
include('db/db_connection.php');

// Fetch all products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check if query is successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - Products</title>
</head>
<body>
    <h2>Products List</h2>
    
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <ul>
            <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                <li>
                    <h3><?php echo $product['product_name']; ?></h3>
                    <p><?php echo $product['product_description']; ?></p>
                    <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No products added yet.</p>
    <?php endif; ?>
</body>
<?php include 'includes/footer.php'; ?>
</html>
