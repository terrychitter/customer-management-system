<?php
require_once("../db_conn.php");

// Query to get unique months and years from the invoices table
$query = "SELECT DISTINCT DATE_FORMAT(invoice_date, '%m/%y') AS month_year 
          FROM invoices 
          ORDER BY invoice_date DESC";

$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the results and store them as objects with id and title fields
    $uniqueMonthsYears = array();
    $id = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $uniqueMonthsYears[] = ['id' => $id++, 'title' => $row['month_year'], 'invoices' => []];
    }

    // Loop through each unique month/year and get the associated data
    foreach ($uniqueMonthsYears as &$monthYear) {
        // Extract month and year from the title
        list($month, $year) = explode('/', $monthYear['title']);

        // Query to get data for the specific month and year
        $dataQuery = "SELECT invoice_id, customer_id 
                      FROM invoices 
                      WHERE DATE_FORMAT(invoice_date, '%m/%y') = '{$month}/{$year}'";

        $dataResult = mysqli_query($conn, $dataQuery);

        if ($dataResult) {
            // Fetch the data and store it in the 'invoices' field of $uniqueMonthsYears
            while ($invoiceRow = mysqli_fetch_assoc($dataResult)) {
                // Query to get customer details from the customers table
                $customerQuery = "SELECT name, surname 
                                  FROM customers 
                                  WHERE account_number = '{$invoiceRow['customer_id']}'";

                $customerResult = mysqli_query($conn, $customerQuery);

                if ($customerResult) {
                    $customerData = mysqli_fetch_assoc($customerResult);
                    $customerName = $customerData['name'][0] . '. ' . $customerData['surname'];

                    $monthYear['invoices'][] = [
                        'invoice_id' => $invoiceRow['invoice_id'],
                        'customer_id' => $invoiceRow['customer_id'],
                        'customer_name' => $customerName,
                    ];
                } else {
                    // Handle the case where the customer query fails
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            // Handle the case where the data query fails
            echo "Error: " . mysqli_error($conn);
        }
    }
    // echo json_encode($uniqueMonthsYears, JSON_PRETTY_PRINT);

    // Now $uniqueMonthsYears contains the data for each month and year, including invoices
} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}
?>