<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek jika belum login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
