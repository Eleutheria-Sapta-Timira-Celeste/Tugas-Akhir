<?php
session_start();
if (!isset($_SESSION['guru'])) {
    header("Location: index.php");
    exit;
}
?>
