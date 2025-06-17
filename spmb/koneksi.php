<?php
// koneksi.php
$koneksi = mysqli_connect("localhost", "root", "", "db_pgri371");

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
