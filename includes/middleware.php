<?php

if (isset($_SESSION['username'])) { //CHECK IF USER IS ADMIN, will be updated
    if (!isset($_SESSION['username'])) {
        $_SESSION['message'] = "You are not authorized to access this page.";
        header("Location: index.php?error=You are not authorized.");

    }
} else {
    $_SESSION['message'] = "Login to continue";
    header("Location: index.php?error=Login to continue.");

}