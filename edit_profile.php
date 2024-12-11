<?php
// edit_profile.php
include 'db/db_connection.php';
include 'includes/header.php';
include 'includes/sidebar.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $sex = $_POST['sex'];

    // Update the user login details (username, email)
    $sql = "UPDATE user_login SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $user_id);

    if ($stmt->execute()) {
        // Now update the user profile details (sex, birthdate)
        $sql = "UPDATE user_profile SET sex = ?, birthdate = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $sex, $birthdate, $user_id);

        if ($stmt->execute()) {
            header("Location: view_profile.php");
            exit();
        } else {
            echo "Error updating profile in user_profile: " . $conn->error;
        }
    } else {
        echo "Error updating profile in user_login: " . $conn->error;
    }

    $stmt->close();
} else {
    // Retrieve current profile data
    $sql = "SELECT u.username, u.email, p.birthdate, p.sex 
            FROM user_login u
            LEFT JOIN user_profile p ON u.id = p.user_id 
            WHERE u.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($row['birthdate']); ?>"><br>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex" required>
            <option value="" disabled>Select</option>
            <option value="Male" <?php echo ($row['sex'] === 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($row['sex'] === 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
<?php include 'includes/footer.php'; ?>
</html>
