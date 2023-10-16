<?php
// Include the database connection
require_once("../db_conn.php");

// Assuming the customer_id is retrieved from the GET superglobal variable
$customer_id = $_GET['customer_id'];

// Assuming the form data is retrieved through the POST superglobal
$paymentDate = date('Y-m-d', strtotime($_POST['paymentDate']));
$paymentAmount = $_POST['paymentAmount'];
$paymentType = $_POST['paymentType'];

// Check for duplicate payment in the database
$query = "SELECT * FROM payments WHERE DATE(payment_date) = ? AND payment_amount = ? AND payment_type = ? AND customer_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $paymentDate, $paymentAmount, $paymentType, $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$existing_payment = $result->fetch_assoc();

// Check if there is any existing payment
if ($existing_payment) {
    // If a duplicate payment is found, return false
    $response = array('status' => true);
    echo json_encode($response);
    header('Content-Type: application/json');
} else {
    // If no duplicate payment is found, return true
    $response = array('status' => false);
    echo json_encode($response);
    header('Content-Type: application/json');
}
?>