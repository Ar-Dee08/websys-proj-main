<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
include('db/db_connection.php');

// Fetch active products from the database
$query = "SELECT * FROM products WHERE status = 'Active'";  // Only fetch active products
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
    <title>Active Products</title>
</head>
<body>
    <div class="container-1">
        <button onclick="window.history.back()" style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Back to Previous Page</button><br>
        <h2><strong>Active Products List</strong></h2><br>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <ul>
                <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                    <li>
                        <?php
                        // Check if product image exists in the database
                        if (!empty($product['prod_img'])) {
                            // Image stored as BLOB, so we need to convert it to base64
                            $image_data = $product['prod_img'];
                            $encoded_image = base64_encode($image_data);  // Convert BLOB to base64 string
                            $image_src = 'data:image/jpeg;base64,' . $encoded_image; // Set the base64 image source
                        } else {
                            $image_src = 'default_image.png'; // Default image if no image is set
                        }
                        ?>
                        <!-- Display the image using base64 encoded string -->
                        <img src="<?php echo $image_src; ?>" alt="Product Image" width="150">

                        <h3><?php echo $product['product_name']; ?></h3>
                        <p><?php echo $product['product_description']; ?></p>
                        <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    </li>
                    <hr>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No active products available.</p>
        <?php endif; ?>
        <a href="removed_product.php" style="color: white; background-color: #493628; font-weight: bold; padding: 10px 20px; border-radius: 5px; text-decoration: none;">View Removed Products</a>
    </div>
</body>
<footer>
    <?php include 'includes/footer.php'; ?>
</footer> 
</html>
