<?php
require_once("../db_conn.php");

// Query to get the next account number
$query = "SELECT account_number FROM customers ORDER BY account_number DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $nextAccountNumber = $row['account_number'] + 1;

    // Return the next account number as JSON
    echo json_encode(array("nextAccountNumber" => $nextAccountNumber));
} else {
    // Handle error
    echo json_encode(array("error" => "Failed to fetch account number"));
}

// Close the database connection
mysqli_close($conn);
?>
