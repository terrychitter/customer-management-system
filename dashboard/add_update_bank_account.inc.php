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

echo "modalBankAccountId: $modalBankAccountId <br>";
echo "modalBankAccountName: $modalBankAccountName <br>";
echo "modalBankAccountBankName: $modalBankAccountBankName <br>";
echo "modalBankAccountBankType: $modalBankAccountBankType <br>";
echo "modalBankAccountHolderName: $modalBankAccountHolderName <br>";
echo "modalBankAccountNumber: $modalBankAccountNumber <br>";
echo "modalBankAccountBranchCode: $modalBankAccountBranchCode <br>";
echo "modalBankAccountBranchName: $modalBankAccountBranchName <br>";
echo "bankAccountIsDefault: " . ($bankAccountIsDefault ? 'true' : 'false') . "<br>";
echo "defaultOptions: $defaultOptions <br>";

// Search if the bank account ID exists in the database
$sql = "SELECT * FROM bank_accounts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $modalBankAccountId);
$stmt->execute();
$result = $stmt->get_result();
$existingAccount = $result->fetch_assoc();

if ($existingAccount) {
    $type = 'editing';
    // Update existing record
    $sql = "UPDATE bank_accounts SET private_name=?, bank=?, type=?, name=?, account_number=?, branch_code=?, branch=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssissi", $modalBankAccountName, $modalBankAccountBankName, $modalBankAccountBankType, $modalBankAccountHolderName, $modalBankAccountNumber, $modalBankAccountBranchCode, $modalBankAccountBranchName, $modalBankAccountId);
    $stmt->execute();
} else {
    $type = 'creating';
    // Create new record
    $sql = "INSERT INTO bank_accounts (private_name, bank, type, name, account_number, branch_code, branch) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiss", $modalBankAccountName, $modalBankAccountBankName, $modalBankAccountBankType, $modalBankAccountHolderName, $modalBankAccountNumber, $modalBankAccountBranchCode, $modalBankAccountBranchName);
    $stmt->execute();

    // Get the ID of the newly created record
    $modalBankAccountId = $stmt->insert_id;
}
echo "Default Options: $defaultOptions";

if ($defaultOptions === "default-immediate-partial") {
    // Get the ID of the old default bank account
    $sql = "SELECT id FROM bank_accounts WHERE is_default = true AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $modalBankAccountId);
    $stmt->execute();
    $oldDefaultResult = $stmt->get_result();
    $oldDefaultAccount = $oldDefaultResult->fetch_assoc();

    if ($oldDefaultAccount) {
        $oldDefaultBankAccountID = $oldDefaultAccount['id'];

        // Update customers table to set bank_account field to the new bank account ID
        $sql = "UPDATE customers SET bank_account = ? WHERE bank_account = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $modalBankAccountId, $oldDefaultBankAccountID);
        $stmt->execute();

        // Print SQL statement with parameters
        echo "SQL: UPDATE customers SET bank_account = $modalBankAccountId WHERE bank_account = $oldDefaultBankAccountID;";
    }
} elseif ($defaultOptions === "default-immediate-all") {
    // Update all customers' bank_account field to the new bank account ID
    $sql = "UPDATE customers SET bank_account = ? WHERE bank_account != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $modalBankAccountId, $modalBankAccountId);
    $stmt->execute();

    // Print SQL statement with parameters
    echo "SQL: UPDATE customers SET bank_account = $modalBankAccountId WHERE bank_account != $modalBankAccountId;";
}

// Setting the new default bank account
if ($bankAccountIsDefault) {
    toggleDefaultBankAccount($modalBankAccountId, $conn);
}

// Going back to previous page
if ($type == 'editing') {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=58");
    exit();
} elseif ($type == 'creating') {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=59");
    exit();
}

function toggleDefaultBankAccount($newBankAccountID, $conn)
{
    echo "$newBankAccountID";

    // Update all records in the bank_accounts table to set "is_default" to false
    $updateAllQuery = "UPDATE bank_accounts SET is_default = false";
    mysqli_query($conn, $updateAllQuery);

    // Update the specific record with $newBankAccountID to set "is_default" to true
    $updateSpecificQuery = "UPDATE bank_accounts SET is_default = true WHERE id = '$newBankAccountID'";
    echo $updateSpecificQuery;
    mysqli_query($conn, $updateSpecificQuery);
}
?>