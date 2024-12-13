<?php
session_start();
include 'db/db_connection.php';

$errorMessage = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if ($_POST['submit'] === 'Sign Up') {
        // Handle Sign Up
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($username && $email && $password) {
            $stmt = $conn->prepare("INSERT INTO user_login (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            try {
                $stmt->execute();
                $successMessage = 'Account successfully created! Please sign in.';
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    $errorMessage = 'The email is already taken. Please try again.';
                } else {
                    $errorMessage = 'An unexpected error occurred. Please try again.';
                }
            }

            $stmt->close();
        } else {
            $errorMessage = 'Please fill in all fields.';
        }
    } elseif ($_POST['submit'] === 'Sign In') {
        // Handle Sign In
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user_login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to dashboard.php
                header("Location: dashboard.php");
                exit();
            } else {
                $errorMessage = 'Invalid password.';
            }
        } else {
            $errorMessage = 'No user found with this email.';
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style-for-login.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <title>Crumbs & Brew</title>
    <link rel="icon" href="images/img-003.ico" type="image/x-icon">
</head>
<body>
<div class="container" id="main">
    <div class="sign-up">
        <form action="index.php" method="POST" id="signUpForm">
            <h1>Create Account</h1>
            <?php
            if (!empty($errorMessage) && $_POST['submit'] === 'Sign Up') {
                echo "<div class='error-message'>$errorMessage</div>";
                echo "<script>document.getElementById('main').classList.add('right-panel-active');</script>";
            }
            ?>
            <input type="text" name="username" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit" value="Sign Up">Sign Up</button>
        </form>
    </div>
    <div class="sign-in">
        <form action="index.php" method="POST">
            <h1>Sign In</h1>
            <?php
            if (!empty($successMessage)) {
                echo "<div class='success-message'>$successMessage</div>";
            }
            if (!empty($errorMessage) && $_POST['submit'] === 'Sign In') {
                echo "<div class='error-message'>$errorMessage</div>";
            }
            ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit" value="Sign In">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-left">
                <h1>Already have an account?</h1>
                <p>Sign in to Crumbs & Brew Cafe 
                    and continue enjoying our delicious coffee and pastries!</p>
                <button id="signIn" type="button">Sign In</button>
            </div>
            <div class="overlay-right">
                <h1>Welcome to Crumbs & Brew Cafe!</h1>
                <p>Join us and make your coffee and pastry experience even better. Sign up now to start ordering your favorites online!</p>
                <button id="signUp" type="button">Sign Up</button>
            </div>
        </div>
    </div>
    <style>
        .success-message {
            color: black;
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 7px;
        }
        .error-message {
            color: black;
            text-align: center;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 7px;
        }
    </style>
</div>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const main = document.getElementById('main');

    signUpButton.addEventListener('click', () => {
        main.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        main.classList.remove("right-panel-active");
    });
</script>
</body>
</html>