<?php

require_once("../db_conn.php");

// Getting the database connection and post variables
$paymentID = $_GET['payment_id'];

// Delete the payment from the payments table
$deletePaymentQuery = "DELETE FROM payments WHERE payment_id = ?";
$deletePaymentStmt = $conn->prepare($deletePaymentQuery);
$deletePaymentStmt->bind_param("s", $paymentID);

// Check if the deletion was successful for the payments table
if ($deletePaymentStmt->execute()) {
    // If the deletion was successful, attempt to delete the balance
    $deleteBalanceQuery = "DELETE FROM balances WHERE payment_id = ?";
    $deleteBalanceStmt = $conn->prepare($deleteBalanceQuery);
    $deleteBalanceStmt->bind_param("s", $paymentID);

    // Check if the deletion was successful for the balances table
    if ($deleteBalanceStmt->execute()) {
        // If both deletions were successful, commit the transaction
        $conn->commit();
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=52");
        exit();
    } else {
        // If the deletion of the balance fails, rollback the transaction
        $conn->rollback();
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=53");
        exit();
    }
} else {
    // If the deletion of the payment fails, rollback the transaction
    $conn->rollback();
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=54");
    exit();
}

// Close the statements and the connection
$deleteBalanceStmt->close();
$deletePaymentStmt->close();
$conn->close();
?>