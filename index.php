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
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            include 'db/db_connection.php';

            $errorMessage = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $username = trim($_POST['username']);
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                if ($username && $email && $password) {
                    $stmt = $conn->prepare("INSERT INTO user_login (username, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $username, $email, $hashedPassword);

                    try {
                        $stmt->execute();
                        header("Location: index.php?message=success");
                        exit();
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

                $conn->close();
            }
            if (!empty($errorMessage)) {
                echo "<div class='error-message'>$errorMessage</div>";
                echo "<script>document.getElementById('main').classList.add('right-panel-active');</script>";
            }
            ?>
            <input type="text" name="username" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>
    <div class="sign-in">
        <form action="login.php" method="POST">
            <h1>Sign In</h1>
            <?php
            if (isset($_GET['message']) && $_GET['message'] == 'success') {
                echo '<div class="success-message">Account Successfully Created!</div>';
            }
            ?>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Sign In</button>
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