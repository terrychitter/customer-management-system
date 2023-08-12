<?php
require_once("../db_conn.php");

$accountNumber = $_GET["account_number"];

$query = "SELECT account_number FROM customers WHERE account_number = '$accountNumber'";
$result = mysqli_query($conn, $query);

if ($result) {
    $available = mysqli_num_rows($result) === 0;
    echo $available ? "true" : "false";
} else {
    echo "error";
}

mysqli_close($conn);
?>
