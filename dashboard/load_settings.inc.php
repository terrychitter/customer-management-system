<?php
require_once("../db_conn.php");
// Retrieve bank accounts and store in a variable
$bank_accounts = array();
$sql_bank_accounts = "SELECT * FROM bank_accounts";
$result_bank_accounts = mysqli_query($conn, $sql_bank_accounts);
if ($result_bank_accounts) {
    while ($bankAccountsData = mysqli_fetch_assoc($result_bank_accounts)) {
        $bank_accounts[] = $bankAccountsData;
    }
}
?>