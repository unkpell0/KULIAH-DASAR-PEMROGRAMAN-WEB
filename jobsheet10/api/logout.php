<?php
require __DIR__ . '/includes/auth.php';

// Hanya lewat POST (dan token CSRF sudah dicek di auth.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION = [];
    session_destroy();
}
header('Location: login.php');
exit;