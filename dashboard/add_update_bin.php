<?php
// Include the database connection
include "../session_check.php";
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if (isset($_GET['account_number'])) {
    // Sanitize the account number
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $binId = $_POST['modal-bin-id'];
        $serialNumber = $_POST['modal-serial-number'];

        // Check if bin ID is empty for adding new bin
        if ($binId === "") {
            // Prepare and execute the insert query for adding a new bin
            $stmt = $conn->prepare("INSERT INTO bins (customer_id, serial_number)
                                    VALUES (?, ?)");

            $stmt->bind_param("is", $accountNumber, $serialNumber);

            if ($stmt->execute()) {
                // Successfully added new bin, redirect with status 18
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=23");
                exit();
            } else {
                // Failed to add new bin, redirect with status 12
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=22");
                exit();
            }
        } else {
            // Prepare and execute the update query for updating an existing bin
            $stmt = $conn->prepare("UPDATE bins SET 
                                    serial_number = ?
                                    WHERE serial_number = ? AND customer_id = ?");

            $stmt->bind_param("ssi", $serialNumber, $binId, $accountNumber);

            if ($stmt->execute()) {
                // Successfully updated bin, redirect with status 15
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=25");
                exit();
            } else {
                // Failed to update bin, redirect with status 14
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=24");
                exit();
            }
        }
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=26");
    exit();
}
?>