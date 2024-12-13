<?php
include('db/db_connection.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the image from the database
    $query = "SELECT prod_img FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($prod_img);
    $stmt->fetch();

    if ($prod_img) {
        // Set the header for the image type
        header("Content-Type: image/jpeg");
        echo $prod_img;  // Output the image data
    } else {
        // If no image found, use a default image
        header("Content-Type: image/png");
        readfile('default_image.png');  // Use a default image
    }

    $stmt->close();
}
?>
