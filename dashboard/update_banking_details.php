<?php
require_once("../db_conn.php");

if (isset($_GET['account_number'])) {
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bankingDetailsID = $_POST['banking-details-select'];

        // Updating the customer's banking details id
        $stmt = $conn->prepare("UPDATE customers SET bank_account = ?
                                WHERE account_number = ?");
        $stmt->bind_param("ii", $bankingDetailsID, $accountNumber);

        if ($stmt->execute()) {
            // Successfully updating the customer's banking details
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=45");
            exit();
        } else {
            // Failed to update the customer's banking details
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=46");
            exit();
        }

        // Close the database connection
        $stmt->close();
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=47");
    exit();
}
?>
