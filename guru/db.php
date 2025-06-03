<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db_pgri371';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
