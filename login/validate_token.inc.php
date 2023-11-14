<?php
include "../../config/keys.php";

$receivedToken = isset($_POST['token']) ? htmlspecialchars($_POST['token']) : '';

$token = $loginToken;
if ($receivedToken === $token) {
    // Token is valid
    $_SESSION['isLoggedIn'] = true;
    $responseData = ['valid' => true, 'recaptcha' => true];
} else {
    // Token is invalid
    $responseData = ['valid' => false, 'recaptcha' => true];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($responseData);
?>