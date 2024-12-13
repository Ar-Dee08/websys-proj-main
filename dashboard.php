<?php
session_start();
ob_start(); // Start output buffering
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user profile data (Replace this with your database logic if needed)
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Dashboard - Crumbs & Brew</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-1">
        <div class="content">
            <h1>Hi there, <strong><?php echo '<b>' . htmlspecialchars($username) . '</b>'; ?></strong>!</h1>
            <h3 style="color: #636363;">What would you like to do today?</h3>
            <div class="form-con">
    <ul class="form-list">
        <li class="form-it">
            <a class="form-lin" href="dashboard.php">
                <i class="fa-solid fa-house"></i> Home
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin collapsible" href="#">
                <i class="fa-solid fa-box"></i> Products
            </a>
            <ul class="form-list sub-list">
                <li class="form-it">
                    <a class="form-lin" href="view_category.php">
                        <i class="fa-solid fa-tags"></i> Category
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="add_product.php">
                        <i class="fa-solid fa-plus"></i> Add Products
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="view_product.php">
                        <i class="fa-solid fa-images"></i> Product Gallery
                    </a>
                </li>
                <li class="form-it">
                    <a class="form-lin" href="add_order.php">
                        <i class="fa-solid fa-cart-plus"></i> Add New Order
                    </a>
                </li>
            </ul>
        </li>
        <li class="form-it">
            <a class="form-lin" href="view_admin.php">
                <i class="fa-solid fa-user-shield"></i> Administrator
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin" href="view_profile.php">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        </li>
        <li class="form-it">
            <a class="form-lin" href="cart.php">
                <i class="fa-solid fa-shopping-cart"></i> Cart
            </a>
        </li>
    </ul>
</div>
</div>
</div>
    </div>

    </div>
    

</body>
<footer>
    <?php 
        include 'includes/footer.php'; 
    ?>
</footer> 
</html>
<script>
    document.querySelectorAll('.collapsible').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            this.classList.toggle('active');
            const subList = this.nextElementSibling;
            if (subList) {
                subList.style.display = subList.style.display === 'block' ? 'none' : 'block';
            }
        });
    });
</script>

