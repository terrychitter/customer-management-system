<?php
session_start();
include "../../config/keys.php";

$responseData = [];

if (isset($_POST['g-recaptcha-response'])) {

    // Checking if recaptcha is valid
    $responseKey = $_POST['g-recaptcha-response'];
    $secretRecpatchaKey = $recaptchaKey;
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretRecpatchaKey&response=$responseKey";
    $file = file_get_contents($url);

    $data = json_decode($file);
    if ($data->success == true) {
        $recaptchaStatus = true;
    } else {
        $recaptchaStatus = false;
    }

    // Checking if the token is valid
    $receivedToken = isset($_POST['token']) ? htmlspecialchars($_POST['token']) : '';

    $token = $secretLoginToken;

    if ($receivedToken === $token) {
        // Token is valid
        $_SESSION['isLoggedIn'] = true;
        ;
        $tokenStatus = true;
    } else {
        // Token is invalid
        $tokenStatus = false;
    }

    $responseData = ['valid' => $tokenStatus, 'recaptcha' => $recaptchaStatus];

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($responseData);

} else {
    header("Location: /login/login.php?status=55");
}
?>