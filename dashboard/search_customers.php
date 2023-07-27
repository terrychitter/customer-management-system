<?php
// Connection to database
include "../db_conn.php";

// Get the search term and search by criteria from the AJAX request
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : null;
$searchBy = isset($_POST['searchBy']) ? $_POST['searchBy'] : null;

// Initialize the results array
$results = array();

// Depending on the value of $searchBy, construct the query accordingly
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
