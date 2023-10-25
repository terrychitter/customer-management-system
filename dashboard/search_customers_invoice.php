<?php
// Connection to database
include "../db_conn.php";

// Get the search term, search by criteria, filtersRadio, and filtersCheck from the AJAX request
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : null;
$searchBy = isset($_POST['searchBy']) ? $_POST['searchBy'] : null;
$filtersRadio = isset($_POST['filtersRadio']) ? $_POST['filtersRadio'] : null;
$filtersCheck = isset($_POST['filtersCheck']) ? $_POST['filtersCheck'] : null;

// Initialize the results array
$results = array();

// Depending on the value of $searchBy and $filtersRadio, construct the query accordingly
switch ($searchBy) {
    case 'account-number':
        $sql = "SELECT * FROM customers WHERE account_number LIKE '%$searchTerm%'";
        break;
    case 'surname':
        $sql = "SELECT * FROM customers WHERE surname LIKE '%$searchTerm%'";
        break;
    case 'street-name':
        $sql = "SELECT * FROM customers WHERE address LIKE '%$searchTerm%'";
        break;
    default:
        // Invalid search criteria
        die('Invalid search criteria');
}

if ($filtersRadio == "pending") {
    // Query the invoices table to only show records from this month using the invoice_date column
    $invoiceSql = "SELECT customer_id FROM invoices WHERE MONTH(invoice_date) = MONTH(CURRENT_DATE())";
    $invoiceResultSet = mysqli_query($conn, $invoiceSql);

    // Record all the account numbers in a list in the customer_id column
    $customerIds = [];
    while ($row = mysqli_fetch_assoc($invoiceResultSet)) {
        $customerIds[] = $row['customer_id'];
    }

    // Query the customers' table and return the customers that are not in that list
    if (!empty($customerIds)) {
        $customerIdsString = implode("','", $customerIds);
        switch ($searchBy) {
            case 'account-number':
                $sql = "SELECT * FROM customers WHERE account_number NOT IN ('$customerIdsString') AND account_number LIKE '%$searchTerm%'";
                break;
            case 'surname':
                $sql = "SELECT * FROM customers WHERE account_number NOT IN ('$customerIdsString') AND surname LIKE '%$searchTerm%'";
                break;
            case 'street-name':
                $sql = "SELECT * FROM customers WHERE account_number NOT IN ('$customerIdsString') AND address LIKE '%$searchTerm%'";
                break;
        }
    }
}

if ($filtersCheck !== null) {
    if ($filtersCheck === 'true') {
        $sql .= " AND active = false";
    } elseif ($filtersCheck === 'false') {
        $sql .= " AND active = true";
    }
}

// Execute the query
$resultSet = mysqli_query($conn, $sql);

// Fetch the results and add them to the $results array
while ($row = mysqli_fetch_assoc($resultSet)) {
    $results[] = $row;
}

// Close the connection
mysqli_close($conn);

// Return the results in JSON format
echo json_encode($results);
?>