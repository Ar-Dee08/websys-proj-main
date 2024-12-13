<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
    <title>Products - Crumbs & Brew</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-1">
        <div class="content" style="text-align: center; align-items: center;">
        <h2>Product Page</h2>
        <form action="view_category.php" method="get" style="display: inline-block; width: 500%;">
            <button type="submit" style="width: 100%;">Category</button>
        </form>
        <form action="add_product.php" method="get" style="display: inline-block; width: 500%;">
            <button type="submit" style="width: 100%;">Add Products</button>
        </form>
        <form action="view_product.php" method="get" style="display: inline-block; width: 500%;">
            <button type="submit" style="width: 100%;">Product Gallery</button>
        </form>
        </div>
    </div>
</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>