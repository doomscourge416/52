<?php
session_start();

function generateCSRFToken() {
    if (empty($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['CSRF'];
}

function validateCSRFToken($token) {
    return hash_equals($_SESSION['CSRF'], $token);
}
?>