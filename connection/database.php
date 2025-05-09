<?php 
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'db_pgri371'; 

$connection = mysqli_connect($server, $username, $password, $database);
$connectionobj = new mysqli($server, $username, $password, $database);
?>