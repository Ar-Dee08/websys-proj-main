<?php
// Include necessary files
include('db/db_connection.php');

// Check if category ID is provided
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $query = "DELETE FROM categories WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: view_category.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>