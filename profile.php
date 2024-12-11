<?php
session_start();
include 'db/db_connection.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user profile data (Replace this with your database logic if needed)
$username = $_SESSION['username'];
$user = null;

// Fetch user data
$sql = "SELECT id, username, dob, email FROM user_login WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Error: User not found.";
    exit();
}

// Update user info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];

    // Update query
    $update_sql = "UPDATE user_login SET username = ?, dob = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $name, $dob, $email, $id);

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh session data if username is changed
        $_SESSION['username'] = $name;
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
    <title>Profile - Crumbs & Brew</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Profile Form -->
            <h2 class="text-center my-4">Profile Information</h2>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?= $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php } ?>
        <form method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="id" class="form-label">Admin ID</label>
                <input type="text" class="form-control" id="id" name="id" value="<?= htmlspecialchars($user['id']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($user['dob']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'includes/footer.php'; ?>
</html>