<?php
include 'connection/database.php';
session_start();
session_unset();
session_destroy();
header("Location: /Tugas-Akhir/login.php");
exit();
?>