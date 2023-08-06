<?php
// Include the database connection
require_once("../db_conn.php");

// Check if the account_number parameter is present in the GET request
if(isset($_GET['account_number'])) {
    // Sanitize the account number
    $accountNumber = filter_var($_GET['account_number'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the form was submitted using POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contactId = filter_var($_POST['modal-contact-id'], FILTER_SANITIZE_NUMBER_INT);
        $contactName = filter_var($_POST['modal-contact-name'], FILTER_SANITIZE_STRING);
        $contactNumber = filter_var($_POST['modal-contact-number'], FILTER_SANITIZE_STRING);
        $countryCode = filter_var($_POST['modal-country-code'], FILTER_SANITIZE_STRING);

        // Check if contact ID is empty for adding new contact
        if ($contactId === "") {
            // Prepare and execute the insert query for adding a new contact
            $stmt = $conn->prepare("INSERT INTO contacts (customer_id, contact_title, contact, country_code)
                                    VALUES (?, ?, ?, ?)");
            
            $stmt->bind_param("isss", $accountNumber, $contactName, $contactNumber, $countryCode);

            if ($stmt->execute()) {
                // Successfully added new contact, redirect with status 13
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=13");
                exit();
            } else {
                // Failed to add new contact, redirect with status 12
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=12");
                exit();
            }
        } else {
            // Prepare and execute the update query for updating an existing contact
            $stmt = $conn->prepare("UPDATE contacts SET 
                                    contact_title = ?, 
                                    contact = ?, 
                                    country_code = ? 
                                    WHERE contact_id = ? AND customer_id = ?");
            
            $stmt->bind_param("sssii", $contactName, $contactNumber, $countryCode, $contactId, $accountNumber);

            if ($stmt->execute()) {
                // Successfully updated contact, redirect with status 15
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=15");
                exit();
            } else {
                // Failed to update contact, redirect with status 14
                header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=14");
                exit();
            }
        }
    }

    // Close the database connection
    $conn->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=16");
    exit();
}
?>