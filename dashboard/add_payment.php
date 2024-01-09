<?php
include "../session_check.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Establish a database connection
    require_once("../db_conn.php");

    // Get customer id, amount, date, and type
    $accountNumber = $_GET['customer_id'];
    $paymentAmount = $_POST['payment-amount'];
    $paymentDate = $_POST['payment-date'] . ' ' . date('H:i:s');
    $paymentType = $_POST['payment-type'];

    // Checking if there is a payment amount
    if ($paymentAmount === "") {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=51");
        exit();
    }

    // Get the most recent balance
    $sql_current_balance = "SELECT balance_amount FROM balances WHERE customer_id = $accountNumber ORDER BY balance_date DESC LIMIT 1";
    $results_current_balance = mysqli_query($conn, $sql_current_balance);

    if ($results_current_balance) {
        $row = mysqli_fetch_assoc($results_current_balance);
        $currentBalance = $row['balance_amount'];
    }

    echo "Current Balance: $currentBalance";

    // Calculate the new balance
    $updatedBalance = $currentBalance - $paymentAmount;

    // Generate the payment id
    $uniquePaymentID = generateUniquePaymentID($accountNumber, $paymentDate, $paymentType, $conn);


    // Add a record of the payment
    if (addPayment($uniquePaymentID, $accountNumber, $paymentDate, $paymentAmount, $paymentType, $conn)) {
        // Add a record of the updated balance
        if (addBalance($accountNumber, $paymentDate, $updatedBalance, $uniquePaymentID, $conn)) {
            // Both the payment and balance records were added successfully
            // Commit the transaction
            mysqli_commit($conn);
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=48");
            exit();
        } else {
            // Error adding balance record
            // Roll back the transaction
            mysqli_rollback($conn);
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=49");
            exit();
            ;
        }
    } else {
        // Error adding payment record
        // Roll back the transaction
        mysqli_rollback($conn);
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=50");
        exit();
    }
}

// Function to add a payment record
function addPayment($uniquePaymentID, $accountNumber, $paymentDate, $paymentAmount, $paymentType, $conn)
{
    $sql = "INSERT INTO payments (payment_id, customer_id, payment_date, payment_amount, payment_type)
            VALUES ('$uniquePaymentID', '$accountNumber', '$paymentDate', $paymentAmount, '$paymentType')";

    return mysqli_query($conn, $sql);
}

// Function to add a balance record
function addBalance($accountNumber, $paymentDate, $updatedBalance, $uniquePaymentID, $conn)
{

    $sql = "INSERT INTO balances (customer_id, balance_date, balance_amount, payment_id)
            VALUES ('$accountNumber', '$paymentDate', $updatedBalance, '$uniquePaymentID')";

    return mysqli_query($conn, $sql);
}

function generateUniquePaymentID($accountNumber, $paymentDate, $paymentType, $conn)
{
    // Extract year, month, and day from the payment date
    $year = date('y', strtotime($paymentDate));
    $month = date('m', strtotime($paymentDate));
    $day = date('d', strtotime($paymentDate));

    // Extract the first two letters of the payment type (uppercase)
    $paymentType = strtoupper(substr($paymentType, 0, 2));

    // Initialize a counter to handle duplicates
    $counter = 1;

    // Construct the initial payment ID
    $paymentID = "PMT{$year}{$month}{$day}{$paymentType}{$accountNumber}";

    // Check if the initial payment ID already exists in the database
    $uniquePaymentID = $paymentID;
    while (paymentIDExists($uniquePaymentID, $conn)) {
        $counter++;
        $uniquePaymentID = "PMT{$year}{$month}{$day}{$paymentType}{$accountNumber}-$counter";
    }

    return $uniquePaymentID;
}

// Function to check if a payment ID already exists in the payments table
function paymentIDExists($paymentID, $conn)
{
    $sql = "SELECT COUNT(*) AS count FROM payments WHERE payment_id = '$paymentID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    return false;
}

?>