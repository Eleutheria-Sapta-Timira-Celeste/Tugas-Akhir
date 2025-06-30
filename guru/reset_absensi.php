<?php
session_start();
include '../connection/database.php';

// Cek login dan role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Ambil kelas dari URL
if (!isset($_GET['kelas']) || empty($_GET['kelas'])) {
    die("Kelas tidak ditentukan.");
}

$kelas = $_GET['kelas'];

// Hapus data absensi berdasarkan kelas
$stmt = $connection->prepare("DELETE FROM absensi WHERE kelas = ?");
$stmt->bind_param("s", $kelas);

if ($stmt->execute()) {
    // Redirect kembali ke halaman sebelumnya atau dashboard
    header("Location: inputabsensi.php?reset=success");
    exit();
} else {
    echo "Gagal mereset absensi.";
}
?>
