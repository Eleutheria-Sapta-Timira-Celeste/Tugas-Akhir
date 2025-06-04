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
    
<div class="flex flex-col">
    <!-- Top Navbar -->
    <nav id="navbar" class="w-full h-auto bg-gray-100 text-black p-4 fixed top-0 left-0 flex flex-row items-center z-10 shadow">
        <h2 class="text-2xl font-bold mr-8">Admin Guru</h2>
        <ul class="flex space-x-4">
            <li>
                <a href="absensisiswa.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700
                          hover:text-white hover:shadow-lg">
                    Absen Siswa (<?= $siswa_absen['total'] ?>)
                </a>
            </li>
            <li>
                <a href="dataguru.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700
                          hover:text-white hover:shadow-lg">
                    Data Guru (<?= $guru_count['total'] ?>)
                </a>
            </li>
            <li>
                <a href="jadwalmengajar.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700
                          hover:text-white hover:shadow-lg">
                    Jadwal Mengajar (<?= $jadwal_count['total'] ?>)
                </a>
            </li>
            <li>
                <a href="absenguru.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700
                          hover:text-white hover:shadow-lg">
                    Absen Guru (<?= $guru_absen['total'] ?>)
                </a>
            </li>
            <li>
                <a href="generate_qr.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-700
                          hover:text-white hover:shadow-lg">
                    Generate QR Code
                </a>
            </li>
            <li>
                <a href="scan_qr.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          hover:scale-110
                          hover:bg-gradient-to-r hover:from-green-500 hover:to-green-700
                          hover:text-white hover:shadow-lg">
                    Scan QR Code
                </a>
            </li>
            <li>
                <a href="logout.php"
                   class="transition-all duration-500 ease-in-out px-4 py-2 rounded
                          bg-red-600 hover:bg-gradient-to-r hover:from-red-600 hover:to-red-800
                          hover:scale-110 hover:text-white hover:shadow-lg">
                    Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="pt-24 px-6 flex-1">
        <!-- ...existing code... -->

        <!-- Main Content -->
        
            
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