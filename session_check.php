<?php
// session_check.php

// Start or resume the session
session_start();

// Array of pages that don't require authentication
$publicPages = array('login.php');

// Check if 'isLoggedIn' session variable is not set and the current page is not in the publicPages array
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    $currentPage = basename($_SERVER['SCRIPT_FILENAME']);

    // If the current page is not a public page, redirect to the login page
    if (!in_array($currentPage, $publicPages)) {
        header('Location: /login/login.php'); // Redirect to your login page
        exit(); // Stop further execution
    }
}
?>