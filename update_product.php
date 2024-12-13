<?php
// Include necessary files
include('db/db_connection.php');

// Check if the form is submitted
if (isset($_POST['reactivate']) && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Update product status to 'Active'
    $query = "UPDATE products SET status = 'Active' WHERE id = '$product_id'";

    if (mysqli_query($conn, $query)) {
        echo "Product reactivated successfully.";
        header("Location: removed_product.php");  // Redirect to removed products page
        exit();
    } else {
        echo "Error reactivating product: " . mysqli_error($conn);
    }
}
?>
