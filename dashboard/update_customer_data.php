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
        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $surname = filter_var($_POST['surname'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $suburb = filter_var($_POST['suburb'], FILTER_SANITIZE_STRING);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $postalCode = filter_var($_POST['postal'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $origin = filter_var($_POST['origin'], FILTER_SANITIZE_STRING);

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE customers SET 
                                title = ?, 
                                name = ?, 
                                surname = ?, 
                                address = ?, 
                                suburb = ?, 
                                city = ?, 
                                postal_code = ?, 
                                email = ?, 
                                origin = ? 
                                WHERE account_number = ?");
        
        $stmt->bind_param("sssssssssi", $title, $name, $surname, $address, $suburb, $city, $postalCode, $email, $origin, $accountNumber);

        if ($stmt->execute()) {
            // Update successful, redirect to previous page with status 7
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=7");
            exit();
        } else {
            // Update failed, redirect to previous page with status 6
            header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=6");
            exit();
        }
    }

    // Fetch existing customer data based on account number
    $stmt = $conn->prepare("SELECT * FROM customers WHERE account_number = ?");
    $stmt->bind_param("i", $accountNumber);
    $stmt->execute();
    $customerData = $stmt->get_result()->fetch_assoc();

    // Close the database connection
    $conn->close();
} else {
    // Account number not provided
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=8");
    exit();

}
?>