<?php
session_start();

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
    <?php include 'includes/sidebar.php'; ?>

    <div class="content" style="margin-left: 250px; margin-top: 60px; padding: 20px;">
        <h1>Hi there, <?php echo htmlspecialchars($username); ?>!</h1>
        <h2>Welcome to your dashboard.</h2>
        <p>This is your home page where you can navigate through the system.</p>
    </div>
</body>
</html>
