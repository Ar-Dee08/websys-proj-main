<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Session user_id not set.";
    exit();
}

include 'db/db_connection.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT u.username, u.email, p.birthdate, p.sex 
        FROM user_login u
        LEFT JOIN user_profile p ON u.id = p.user_id 
        WHERE u.id = ?";
error_log("Executing SQL: " . $sql);

$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Error preparing statement: " . $conn->error);
    echo "Error preparing statement.";
    exit();
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    error_log("Error executing query: " . $stmt->error);
    echo "Error executing query.";
    exit();
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No data found for the user ID $user_id";
    exit();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
</head>
<body>
    <h1>Profile Page</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
    <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($row['birthdate'] ?? 'Not Set'); ?></p>
    <p><strong>Sex:</strong> <?php echo htmlspecialchars($row['sex'] ?? 'Not Set'); ?></p>
    <button onclick="location.href='edit_profile.php'">Edit Profile</button>
</body>
<?php include 'includes/footer.php'; ?>
</html>