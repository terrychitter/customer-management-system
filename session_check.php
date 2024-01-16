<?php
session_start();

// Check if 'isLoggedIn' session variable is not set and the current page is not in the publicPages array
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {

    header('Location: /login/login.php'); // Redirect to your login page
    exit(); // Stop further execution
}
?>