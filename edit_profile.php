<?php
// edit_profile.php
include 'db_connection.php';

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

    $sql = "UPDATE user_login SET username = ?, email = ?, birthdate = ?, sex = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $birthdate, $sex, $user_id);

    if ($stmt->execute()) {
        header("Location: view_profile.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
} else {
    $sql = "SELECT username, email, birthdate, sex FROM user_login WHERE id = ?";
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
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['username']); ?>" required><br>

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
</html>
