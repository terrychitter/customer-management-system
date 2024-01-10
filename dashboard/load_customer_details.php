<?php
require_once("../db_conn.php");

// Intialising variables
$customerActive = false;
$customerID = '0';

// Assigning variables
if (isset($_GET['customer_id'])) {
    $customerActive = true;
    $customerID = $_GET['customer_id'];
}

// Getting customer data if a customer is selected
if ($customerActive) {

    // Query the database to get the customer data
    $sql = "SELECT * FROM customers WHERE account_number = $customerID";

    // Execute the query and store the result in $result
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and fetch the customer data
    if ($result && mysqli_num_rows($result) > 0) {
        $customerData = mysqli_fetch_assoc($result);

        // Extract each field value and store them in variables
        $accountNumber = $customerData['account_number'];
        $title = $customerData['title'];
        $name = $customerData['name'];
        $surname = $customerData['surname'];
        $address = $customerData['address'];
        $suburb = $customerData['suburb'];
        $postalCode = $customerData['postal_code'];
        $active = $customerData['active'];
        $email = $customerData['email'];
        $origin = $customerData['origin'];
        $frequency = $customerData['frequency'];
        $day = $customerData['day'];
        $monthlyRate = $customerData['monthly_rate'];
        $dateJoined = $customerData['date_joined'];
        $dateAdded = $customerData['date_added'];
        $prefferedBank = $customerData['bank_account'];

        // Retrieve comments for the customer and store in an array
        $comments = array();
        $sql_comments = "SELECT * FROM comments WHERE customer_id = $customerID ORDER BY date_time_added DESC";
        $result_comments = mysqli_query($conn, $sql_comments);
        if ($result_comments) {
            while ($commentData = mysqli_fetch_assoc($result_comments)) {
                $comments[] = $commentData;
            }
        }

        // Retrieve bins for the customer and store in an array
        $bins = array();
        $sql_bins = "SELECT * FROM bins WHERE customer_id = $customerID";
        $result_bins = mysqli_query($conn, $sql_bins);
        if ($result_bins) {
            while ($binData = mysqli_fetch_assoc($result_bins)) {
                $bins[] = $binData;
            }
        }

        // Retrieve contacts for the customer and store in an array
        $contacts = array();
        $sql_contacts = "SELECT * FROM contacts WHERE customer_id = $customerID";
        $result_contacts = mysqli_query($conn, $sql_contacts);
        if ($result_contacts) {
            while ($contactData = mysqli_fetch_assoc($result_contacts)) {
                $contacts[] = $contactData;
            }
        }

        // Retrieve payments (with their balances) for the customer and store in an array
        $payments = array();
        $sql_payments = "SELECT P.*, B.balance_amount AS balance_after_payment FROM payments P LEFT JOIN balances B ON P.payment_id = B.payment_id WHERE P.customer_id = $customerID ORDER BY P.payment_date DESC";
        $result_payments = mysqli_query($conn, $sql_payments);
        if ($result_payments) {
            while ($paymentData = mysqli_fetch_assoc($result_payments)) {
                $payments[] = $paymentData;
            }
        }

        // Get current balance
        $sql_current_balance = "SELECT * FROM balances WHERE customer_id = $customerID ORDER BY balance_date DESC LIMIT 1";
        $results_current_balance = mysqli_query($conn, $sql_current_balance);

        if ($results_current_balance) {
            if (mysqli_num_rows($results_current_balance) > 0) {
                $row = mysqli_fetch_assoc($results_current_balance);
                $currentBalance = $row['balance_amount'];
            } else {
                // No rows in the result, set currentBalance to 0
                $currentBalance = 0;
            }
        }

        // Retrieve invoices for the customer and store in an array
        $invoices = array();
        $sql_invoices = "SELECT * FROM invoices WHERE customer_id = $customerID";
        $result_invoices = mysqli_query($conn, $sql_invoices);
        if ($result_invoices) {
            while ($invoiceData = mysqli_fetch_assoc($result_invoices)) {
                $invoices[] = $invoiceData;
            }
        }
    } else {

        // Customer could not be found
        header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=1");
    }
}
?>