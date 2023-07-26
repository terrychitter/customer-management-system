<?php
// Include the database credentials file
require_once __DIR__ . "/../config/db_cred.php";

// Establish the database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
