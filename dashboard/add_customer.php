<?php
include "../session_check.php";
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get customer details
    $accountNumber = $_POST['modal-account-number'];
    $title = $_POST['modal-title'];
    $name = $_POST['modal-name'];
    $surname = $_POST['modal-surname'];
    $address = $_POST['modal-address'];
    $suburb = $_POST['modal-suburb'];
    $postal = $_POST['modal-postal'];
    $email = $_POST['modal-email'];
    $origin = $_POST['modal-origin'];
    $freq = $_POST['modal-frequency'];
    $day = $_POST['modal-day'];
    $monthlyFee = $_POST['modal-monthly-fee'];
    $prefferedBankAccount = $_POST['modal-preffered-bank-account'];

    date_default_timezone_set('Africa/Johannesburg');
    $currentDateTime = date('Y-m-d H:i:s');

    // Prepare and execute the update query for adding a customer
    $stmt = $conn->prepare("INSERT INTO customers (account_number, title, name, surname, address, suburb, postal_code, active, email, origin, frequency, day, monthly_rate, date_joined, date_added, bank_account)
    VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssssssisissi", $accountNumber, $title, $name, $surname, $address, $suburb, $postal, $email, $origin, $freq, $day, $monthlyFee, $currentDateTime, $currentDateTime, $prefferedBankAccount);

    if ($stmt->execute()) {
        // Successfully updated bin, replace customer_id parameter in the URL and redirect with status 15
        $referer = $_SERVER['HTTP_REFERER'];
        $updatedReferer = preg_replace('/customer_id=\d+/', "customer_id=$accountNumber", $referer);

        header("Location: " . $updatedReferer . "&status=37");
        exit();
    } else {
        // Failed to update bin, redirect with status 14
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=38");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=36");
    exit();
}
?>