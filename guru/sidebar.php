<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">

<!-- Sidebar -->
<aside id="sidebar" class="bg-[#d49f5f] text-white h-screen fixed top-0 left-0 w-64 flex flex-col transition-all duration-300 ease-in-out z-40 overflow-y-auto">
    <div class="p-4 text-center border-b border-orange-300">
        <img src="../assects/images/defaults/logo_warna.png" alt="Logo" class="mx-auto mb-2 w-16 h-16">
        <span class="text-sm font-bold sidebar-label block">SMP PGRI 371 Pondok Aren</span>
    </div>

    <!-- Menu -->
    <nav class="mt-4 flex flex-col px-2 space-y-1 text-sm">
        <button onclick="dashboard_guru()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 transition">
            <span class="text-xl">🏠</span>
            <span class="menu-text">Dashboard</span>
        </button>
        <button onclick="input_absensi()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 transition">
            <span class="text-xl">📝</span>
            <span class="menu-text">Absensi</span>
        </button>
        <button onclick="pengaturan_guru()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 transition">
            <span class="text-xl">⚙️</span>
            <span class="menu-text">Pengaturan</span>
        </button>
        <button onclick="logoutsession()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 mt-2 transition">
            <span class="text-xl">⏻</span>
            <span class="menu-text">Logout (<?= $_SESSION["username"]; ?>)</span>
        </button>
    </nav>
</aside>

<!-- Header -->
<header id="header" class="ml-64 bg-[#bd8035] h-16 text-white flex items-center px-4 fixed top-0 left-0 right-0 z-30 transition-all duration-300">
    <button id="toggleSidebar" class="text-2xl mr-4 focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>
    <h1 class="font-bold text-lg">Dashboard Guru</h1>
</header>

<!-- Main Content -->


<!-- Script Navigasi -->
<script>
    function dashboard_guru() {
        window.location.href = "index.php?page=dashboard";
    }
    function input_absensi() {
        window.location.href = "index.php?page=inputabsensi";
    }
    function pengaturan_guru() {
        window.location.href = "index.php?page=pengaturan";
    }
    function logoutsession() {
        if (confirm("Yakin ingin logout?")) {
            window.location.href = "/Tugas-Akhir/logout.php";
        }
    }
</script>

<!-- Script Toggle Sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const header = document.getElementById('header');
        const mainContent = document.getElementById('main-content');
        const menuTexts = document.querySelectorAll('.menu-text');
        const labels = document.querySelectorAll('.sidebar-label');

        let sidebarCollapsed = false;

        toggleButton.addEventListener('click', () => {
            sidebarCollapsed = !sidebarCollapsed;

            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');

            header.classList.toggle('ml-64');
            header.classList.toggle('ml-20');

            mainContent.classList.toggle('ml-64');
            mainContent.classList.toggle('ml-20');

            labels.forEach(label => label.classList.toggle('hidden'));
            menuTexts.forEach(text => text.classList.toggle('hidden'));
        });
    });
</script>

</body>
</html>
