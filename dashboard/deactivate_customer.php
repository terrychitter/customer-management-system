<?php
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get account number
    $accountNumber = $_GET['account_number'];

    // Prepare and execute the update query for deactivating a customer
    $stmt = $conn->prepare("UPDATE customers SET active = 0 WHERE account_number = ?");
    $stmt->bind_param('i', $accountNumber);

    if ($stmt->execute()) {
        // Successfully deactived customer
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=40");
        exit();      
    } else {
        // Failed to deactivate customer
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=41");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=39");
    exit();
}
?>