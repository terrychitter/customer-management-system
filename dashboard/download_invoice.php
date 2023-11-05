<?php
// Assuming $invoiceID is passed as a query parameter
if (isset($_GET['invoiceID'])) {
    $invoiceID = $_GET['invoiceID'];
    $file = '../../invoices/' . $invoiceID . '.xlsx';

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
} else {
    // Handle invalid or missing invoiceID parameter
    echo "Invalid or missing invoiceID.";
}
?>