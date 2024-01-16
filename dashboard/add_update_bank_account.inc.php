<?php
include "../session_check.php";
require_once("../db_conn.php");

// Retrieve and assign POST variables to their own variables
$modalBankAccountId = $_POST['modal-bank-account-id'] ?? "";
$modalBankAccountName = $_POST['modal-bank-account-name'] ?? null;
$modalBankAccountBankName = $_POST['modal-bank-account-bank-name'] ?? null;
$modalBankAccountBankType = $_POST['modal-bank-account-bank-type'] ?? null;
$modalBankAccountHolderName = $_POST['modal-bank-account-account-holder-name'] ?? null;
$modalBankAccountNumber = $_POST['modal-bank-account-account-number'] ?? null;
$modalBankAccountBranchCode = $_POST['modal-bank-account-branch-code'] ?? null;
$modalBankAccountBranchName = $_POST['modal-bank-account-branch-name'] ?? null;
$bankAccountIsDefault = isset($_POST['bank-account-is-default-check']) ? ($_POST['bank-account-is-default-check'] === 'on' ? true : false) : false;
$defaultOptions = $_POST['default-options'] ?? null;

// Search if the bank account ID exists in the database
$sql = "SELECT * FROM bank_accounts WHERE id = '$modalBankAccountId'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$existingAccount = mysqli_fetch_assoc($result);

if ($existingAccount) {
    $type = 'editing';
    // Update existing record
    $sql = "UPDATE bank_accounts SET private_name='$modalBankAccountName', bank='$modalBankAccountBankName', type='$modalBankAccountBankType', name='$modalBankAccountHolderName', account_number='$modalBankAccountNumber', branch_code='$modalBankAccountBranchCode', branch='$modalBankAccountBranchName' WHERE id='$modalBankAccountId'";
    $updateResult = mysqli_query($conn, $sql);

    if (!$updateResult) {
        die("Error: " . mysqli_error($conn));
    }
} else {
    $type = 'creating';
    // Create new record
    $sql = "INSERT INTO bank_accounts (private_name, bank, type, name, account_number, branch_code, branch) VALUES ('$modalBankAccountName', '$modalBankAccountBankName', '$modalBankAccountBankType', '$modalBankAccountHolderName', '$modalBankAccountNumber', '$modalBankAccountBranchCode', '$modalBankAccountBranchName')";
    $insertResult = mysqli_query($conn, $sql);

    if (!$insertResult) {
        die("Error: " . mysqli_error($conn));
    }

    // Get the ID of the newly created record
    $modalBankAccountId = mysqli_insert_id($conn);
}

if ($defaultOptions === "default-immediate-partial") {
    // Get the ID of the old default bank account
    $sql = "SELECT id FROM bank_accounts WHERE is_default = true AND id != '$modalBankAccountId'";
    $oldDefaultResult = mysqli_query($conn, $sql);

    if (!$oldDefaultResult) {
        die("Error: " . mysqli_error($conn));
    }

    $oldDefaultAccount = mysqli_fetch_assoc($oldDefaultResult);

    if ($oldDefaultAccount) {
        $oldDefaultBankAccountID = $oldDefaultAccount['id'];

        // Update customers table to set bank_account field to the new bank account ID
        $updateAllQuery = "UPDATE customers SET bank_account = '$modalBankAccountId' WHERE bank_account = '$oldDefaultBankAccountID'";
        $updateAllResult = mysqli_query($conn, $updateAllQuery);

        if (!$updateAllResult) {
            die("Error: " . mysqli_error($conn));
        }
    }
} elseif ($defaultOptions === "default-immediate-all") {
    // Update all customers' bank_account field to the new bank account ID
    $updateAllQuery = "UPDATE customers SET bank_account = '$modalBankAccountId' WHERE bank_account != '$modalBankAccountId'";
    $updateAllResult = mysqli_query($conn, $updateAllQuery);

    if (!$updateAllResult) {
        die("Error: " . mysqli_error($conn));
    }
}

// Setting the new default bank account
if ($bankAccountIsDefault) {
    toggleDefaultBankAccount($modalBankAccountId, $conn);
}

// Going back to the previous page
if ($type == 'editing') {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=58");
    exit();
} elseif ($type == 'creating') {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=59");
    exit();
}

function toggleDefaultBankAccount($newBankAccountID, $conn)
{

    // Update all records in the bank_accounts table to set "is_default" to false
    $updateAllQuery = "UPDATE bank_accounts SET is_default = false";
    $updateAllResult = mysqli_query($conn, $updateAllQuery);

    if (!$updateAllResult) {
        die("Error: " . mysqli_error($conn));
    }

    // Update the specific record with $newBankAccountID to set "is_default" to true
    $updateSpecificQuery = "UPDATE bank_accounts SET is_default = true WHERE id = '$newBankAccountID'";
    $updateSpecificResult = mysqli_query($conn, $updateSpecificQuery);

    if (!$updateSpecificResult) {
        die("Error: " . mysqli_error($conn));
    }
}
?>