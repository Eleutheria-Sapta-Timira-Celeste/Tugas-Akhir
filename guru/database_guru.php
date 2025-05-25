<?php
$koneksi = new mysqli("localhost", "root", "", "db_pgri371");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
