<?php
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if(isset($_GET['account_number'])) {
    // Sanitize the account number
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate the data from the form
        $frequency = filter_var($_POST['frequency'], FILTER_SANITIZE_NUMBER_INT);
        $day = filter_var($_POST['sanitizing-day'], FILTER_SANITIZE_STRING);
        $monthlyRate = filter_var($_POST['monthly-fee'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $monthlyRate = round($monthlyRate, 2); // Round to 2 decimal places

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE customers SET 
                                frequency = ?, 
                                day = ?, 
                                monthly_rate = ? 
                                WHERE account_number = ?");
        
        $stmt->bind_param("issi", $frequency, $day, $monthlyRate, $accountNumber);

        if ($stmt->execute()) {
            // Update successful, redirect to previous page with status 10
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=10");
            exit();
        } else {
            // Update failed, redirect to previous page with status 9
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=9");
            exit();
        }
    }
    
    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=11");
    exit();
}
?>