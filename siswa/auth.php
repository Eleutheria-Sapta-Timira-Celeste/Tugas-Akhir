<?php
session_start();
include 'koneksi.php';

$nis = $_POST['nis'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($nis) || empty($password)) {
    echo "<script>alert('Harap isi semua data.'); window.location='index.php';</script>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
$stmt->bind_param("s", $nis);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('NIS tidak ditemukan.'); window.location='index.php';</script>";
    exit;
}

$siswa = $result->fetch_assoc();

if (password_verify($password, $siswa['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['nis'] = $siswa['nis'];
    $_SESSION['nama'] = $siswa['nama'];
    header("Location: dashboard.php"); // atau halaman lain
    exit;
} else {
    echo "<script>alert('Password salah.'); window.location='index.php';</script>";
    exit;
}
?>