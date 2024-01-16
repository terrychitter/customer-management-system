<?php
include "../session_check.php";
require_once("../db_conn.php");

$modalConfirmBankAccountId = $_POST['modal-confirm-bank-account-id'];

// Get current default bank account
$sql = "SELECT id FROM bank_accounts WHERE is_default = true";
$defaultResult = mysqli_query($conn, $sql);

if (!$defaultResult) {
    die("Error: " . mysqli_error($conn));
}

$defaultAccount = mysqli_fetch_assoc($defaultResult)['id'];

// Set all customer's linked to $modalConfirmBankAccountId to be linked to default account
$updateAllQuery = "UPDATE customers SET bank_account = '$defaultAccount' WHERE bank_account = '$modalConfirmBankAccountId'";
$updateAllResult = mysqli_query($conn, $updateAllQuery);

if (!$updateAllResult) {
    die("Error: " . mysqli_error($conn));
}

// Delete the bank account
$deleteBankAccountQuery = "DELETE from bank_accounts WHERE id ='$modalConfirmBankAccountId'";
$deleteBankAccountResult = mysqli_query($conn, $deleteBankAccountQuery);

if (!$deleteBankAccountResult) {
    die("Error: " . mysqli_error($conn));
}

header("Location: " . $_SERVER['HTTP_REFERER'] . "?status=60");
exit();

?>