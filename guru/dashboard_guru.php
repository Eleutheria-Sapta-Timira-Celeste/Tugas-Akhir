<?php
session_start();
require 'db.php';

if (!isset($_SESSION['guru'])) {
    header("Location: login.php");
    exit();
}

$guru = $_SESSION['guru'];

// Fetch Data Dynamically
$siswa_absen = $conn->query("SELECT COUNT(*) AS total FROM absensiswa")->fetch_assoc();
$guru_count = $conn->query("SELECT COUNT(*) AS total FROM guru")->fetch_assoc();
$jadwal_count = $conn->query("SELECT COUNT(*) AS total FROM jadwalmengajar")->fetch_assoc();
$guru_absen = $conn->query("SELECT COUNT(*) AS total FROM absenguru")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graphs -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar Navigation -->
    <div class="flex">
        <nav id="sidebar" class="w-64 h-screen bg-blue-900 text-white p-6 fixed transition-transform transform">
            <h2 class="text-2xl font-bold mb-6">Admin Guru</h2>
            <ul class="space-y-4">
                <li><a href="absensisiswa.php" class="hover:bg-blue-700 p-2 block rounded">Absen Siswa (<?= $siswa_absen['total'] ?>)</a></li>
                <li><a href="dataguru.php" class="hover:bg-blue-700 p-2 block rounded">Data Guru (<?= $guru_count['total'] ?>)</a></li>
                <li><a href="jadwalmengajar.php" class="hover:bg-blue-700 p-2 block rounded">Jadwal Mengajar (<?= $jadwal_count['total'] ?>)</a></li>
                <li><a href="absenguru.php" class="hover:bg-blue-700 p-2 block rounded">Absen Guru (<?= $guru_absen['total'] ?>)</a></li>
                <li><a href="generate_qr.php" class="hover:bg-blue-700 p-2 block rounded">Generate QR Code</a></li>
                <li><a href="scan_qr.php" class="hover:bg-green-700 p-2 block rounded">Scan QR Code</a></li>
                <li><a href="logout.php" class="bg-red-600 hover:bg-red-700 p-2 block rounded">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="ml-64 p-6 flex-1">
            <button onclick="toggleSidebar()" class="bg-blue-500 text-white p-2 rounded mb-4">Toggle Sidebar</button>
            <h1 class="text-3xl font-bold mb-4">Selamat datang, <?= htmlspecialchars($guru['name']) ?>!</h1>
            
            <!-- Dashboard Stats -->
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold">NIP</h2>
                    <p><?= $guru['nip'] ?></p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold">Mapel</h2>
                    <p><?= $guru['mapel'] ?></p>
                </div>
            </div>

            <!-- Attendance Chart -->
            <div class="bg-white p-6 rounded shadow mt-6">
                <h2 class="text-xl font-bold">Grafik Absensi</h2>
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-64');
        }

        // Chart.js Graph for Attendance
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Alpha', 'Izin', 'Sakit'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: [<?= $siswa_absen['total'] ?>, 10, 5, 3], // Replace values dynamically
                    backgroundColor: ['#4CAF50', '#F44336', '#FFC107', '#2196F3']
                }]
            }
        });
    </script>

</body>
</html>