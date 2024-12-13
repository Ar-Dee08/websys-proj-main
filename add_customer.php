<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/header.php';
include('db/db_connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];

    $stmt = $conn->prepare("INSERT INTO customers (customer_name) VALUES (?)");
    $stmt->bind_param("s", $customer_name);

    if ($stmt->execute()) {
        echo "Customer added successfully!";
        header("Location: customers.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
</head>
<body>
    <div class="container-1">
        <h2>Add Customer</h2>
        <form action="" method="POST">
            <label for="customer_name">Customer Name:</label><br>
            <input type="text" id="customer_name" name="customer_name" placeholder="Enter customer name (optional)">
            <br><br>
            <button type="submit">Add Customer</button>
        </form>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>
