<?php
if ($_SERVER['REQUEST_URI'] === '/') {
    header('Location: /dashboard/customer.php', true, 301);
    exit();
}