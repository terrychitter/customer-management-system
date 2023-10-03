<?php
    require_once("../db_conn.php");
    
    // Intialising variables
    $customerActive = false;
    $customerID = '0';

    // Assigning variables
    if (isset($_GET['customer_id'])) {
      $customerActive = true;
      $customerID = $_GET['customer_id'];
    }

    // Getting customer data if a customer is selected
    if ($customerActive) {

    // Query the database to get the customer data
    $sql = "SELECT * FROM customers WHERE account_number = $customerID";

    // Execute the query and store the result in $result
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and fetch the customer data
    if ($result && mysqli_num_rows($result) > 0) {
          $customerData = mysqli_fetch_assoc($result);

          // Extract each field value and store them in variables
          $accountNumber = $customerData['account_number'];
          $title = $customerData['title'];
          $name = $customerData['name'];
          $surname = $customerData['surname'];
          $address = $customerData['address'];
          $suburb = $customerData['suburb'];
          $postalCode = $customerData['postal_code'];
          $active = $customerData['active'];
          $email = $customerData['email'];
          $origin = $customerData['origin'];
          $frequency = $customerData['frequency'];
          $day = $customerData['day'];
          $monthlyRate = $customerData['monthly_rate'];
          $dateJoined = $customerData['date_joined'];
          $dateAdded = $customerData['date_added'];
          $prefferedBank = $customerData['bank_account'];

          // Retrieve comments for the customer and store in an array
          $comments = array();
          $sql_comments = "SELECT * FROM comments WHERE customer_id = $customerID ORDER BY date_time_added DESC";
          $result_comments = mysqli_query($conn, $sql_comments);
          if ($result_comments) {
              while ($commentData = mysqli_fetch_assoc($result_comments)) {
                  $comments[] = $commentData;
              }
          }

          // Retrieve bins for the customer and store in an array
          $bins = array();
          $sql_bins = "SELECT * FROM bins WHERE customer_id = $customerID";
          $result_bins = mysqli_query($conn, $sql_bins);
          if ($result_bins) {
              while ($binData = mysqli_fetch_assoc($result_bins)) {
                  $bins[] = $binData;
              }
          }

          // Retrieve contacts for the customer and store in an array
          $contacts = array();
          $sql_contacts = "SELECT * FROM contacts WHERE customer_id = $customerID";
          $result_contacts = mysqli_query($conn, $sql_contacts);
          if ($result_contacts) {
              while ($contactData = mysqli_fetch_assoc($result_contacts)) {
                  $contacts[] = $contactData;
              }
          }

          // Retrieve payments for the customer and store in an array
          $payments = array();
          $sql_payments = "SELECT * FROM payments WHERE customer_id = $customerID";
          $result_payments = mysqli_query($conn, $sql_payments);
          if ($result_payments) {
              while ($paymentData = mysqli_fetch_assoc($result_payments)) {
                  $payments[] = $paymentData;
              }
          }

          // Retrieve invoices for the customer and store in an array
          $invoices = array();
          $sql_invoices = "SELECT * FROM invoices WHERE customer_id = $customerID";
          $result_invoices = mysqli_query($conn, $sql_invoices);
          if ($result_invoices) {
              while ($invoiceData = mysqli_fetch_assoc($result_invoices)) {
                  $invoices[] = $invoiceData;
              }
          }

          // Retrieve bank accounts and store in a variable
          $bank_accounts = array();
          $sql_bank_accounts = "SELECT * FROM bank_accounts";
          $result_bank_accounts = mysqli_query($conn, $sql_bank_accounts);
          if ($result_bank_accounts) {
            while ($bankAccountsData = mysqli_fetch_assoc($result_bank_accounts)) {
              $bank_accounts[] = $bankAccountsData;
            }
          }

      } else {

          // Customer could not be found
          header("Location: " . $_SERVER['HTTP_REFERER'] . "&status=1");
      }
          // Close the database connection
          mysqli_close($conn);
    }
?>