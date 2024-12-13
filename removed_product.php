<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include('db/db_connection.php');

// Fetch removed products from the database
$query = "SELECT * FROM products WHERE status = 'Removed'";  // Only fetch removed products
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Removed Products</title>
</head>
<body>
    <div class="container-1">
        <h2>Removed Products List</h2>
        
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <ul>
                <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                    <li>
                        <h3><?php echo $product['product_name']; ?></h3>
                        <p><?php echo $product['product_description']; ?></p>
                        <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                        <form action="update_product.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="submit" name="reactivate" value="Reactivate">
                        </form>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> <!-- Edit button for removed products -->
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No removed products available.</p>
        <?php endif; ?>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>
