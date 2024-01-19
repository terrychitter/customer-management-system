<?php
include "../session_check.php";
require_once("../db_conn.php");

// Check if the 'month-year' parameter is set in the GET request
if (isset($_GET['month-year'])) {
    $monthYear = $_GET['month-year'];

    // Extract month and year from the 'month-year' parameter
    list($month, $year) = explode('/', $monthYear);

    // Query the database to get all invoice ids for the specified month and year
    $query = "SELECT invoice_id 
              FROM invoices 
              WHERE DATE_FORMAT(invoice_date, '%m/%y') = '$month/$year'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch the invoice ids and store them in a list
        $invoiceIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $invoiceIds[] = $row['invoice_id'];
        }

        // Check if there are multiple invoices
        if (count($invoiceIds) > 1) {
            // Create a zip file
            $zip_file = "../../invoices/invoices_$month$year.zip";
            touch($zip_file);

            // Open zip file
            $zip = new ZipArchive();
            $this_zip = $zip->open($zip_file, ZipArchive::CREATE);

            if ($this_zip) {
                foreach ($invoiceIds as $invoiceId) {
                    $fileWithPath = "../../invoices/$invoiceId.xlsx";
                    $fileName = "$invoiceId.xlsx";
                    $zip->addFile($fileWithPath, $fileName);
                }

                $zip->close();

                // Send appropriate headers to force download
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . basename($zip_file) . '"');
                header('Content-Length: ' . filesize($zip_file));
                readfile($zip_file);

                // Delete the zip file
                unlink($zip_file);

                // Exit to prevent further output
                exit();
            } else {
                echo "Failed to open zip file.";
            }
        } else {
            $file = "../../invoices/$invoiceIds[0].xlsx";

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            } else {
                // Handle file not found error
                echo "File not found.";
            }
        }

    } else {
        // Handle the case where the query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Handle the case where 'month-year' parameter is not set
    echo "Error: 'month-year' parameter not set";
}
?>