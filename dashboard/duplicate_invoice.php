<?php

// Include the database connection
require_once("../db_conn.php");

// Initialize an empty array to store customer IDs with duplicate invoices
$customersWithDuplicateInvoices = [];

// Check if the GET variable 'customers' is set
if (isset($_GET['customers'])) {
    // Extract the customer IDs from the GET variable and convert it to an array
    $customerIDs = explode(',', $_GET['customers']);

    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Query to check for duplicate invoices
    $sql = "SELECT customer_id FROM invoices WHERE MONTH(invoice_date) = ? AND YEAR(invoice_date) = ?";
    $stmt = $conn->prepare($sql);

    // Check if the preparation of the SQL statement was successful
    if ($stmt) {
        $stmt->bind_param('ii', $currentMonth, $currentYear);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for duplicate invoices and store customer IDs with duplicates
        while ($row = $result->fetch_assoc()) {
            if (in_array($row['customer_id'], $customerIDs)) {
                $customersWithDuplicateInvoices[] = $row['customer_id'];
            }
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error in SQL query preparation: " . $conn->error;
    }
}

// Close the database connection
$conn->close();

// Return the list of customers with duplicate invoices as JSON
echo json_encode($customersWithDuplicateInvoices);

?>