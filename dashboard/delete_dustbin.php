<?php
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if(isset($_GET['account_number'])) {
    // Sanitize the account number
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $binId = $_POST['modal-confirm-bin-id'];

        $stmt = $conn->prepare("DELETE FROM bins WHERE serial_number = ? AND customer_id = ?");
        $stmt->bind_param('si', $binId, $accountNumber);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=34");
            exit();
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=35");
            exit();
        }
    }
    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=33");
    exit();
}
?>