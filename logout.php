<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other page you prefer
    header("Location: register.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: register.php");
    exit();
}
?>
