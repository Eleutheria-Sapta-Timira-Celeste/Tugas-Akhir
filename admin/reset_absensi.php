<?php
include '../connection/database.php';

// Move student attendance to history
$query = "INSERT INTO riwayat_absensi_murid (murid_name, date, status)
          SELECT murid_name, date, status FROM absensi_murid";
mysqli_query($connection, $query);

// Move teacher attendance to history
$query = "INSERT INTO riwayat_absensi_guru (nama_guru, date, status)
          SELECT nama_guru, date, status FROM absensi_guru";
mysqli_query($connection, $query);

// Clear current attendance tables
mysqli_query($connection, "DELETE FROM absensi_murid");
mysqli_query($connection, "DELETE FROM absensi_guru");

echo "Attendance records reset successfully!";
?>
