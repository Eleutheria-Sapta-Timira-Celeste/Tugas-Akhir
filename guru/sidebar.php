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

<aside id="sidebar" class="bg-[#d49f5f] text-white h-screen w-64 fixed top-0 left-0 z-40 transition-all duration-300">
    <!-- Logo -->
    <div class="p-4 text-center border-b border-orange-300">
        <img src="../assects/images/defaults/logo_warna.png" alt="Logo" id="sidebar-logo" class="mx-auto mb-2 w-16 h-16 transition-all duration-300">
        <span class="text-sm font-bold block menu-text transition-all duration-300">SMP PGRI 371 Pondok Aren</span>
    </div>

    <!-- Menu -->
    <nav class="mt-4 flex flex-col px-2 space-y-1 text-sm">
        <button onclick="dashboard_guru()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 transition">
            <span class="text-xl">📝</span>
            <span class="menu-text">Dashboard</span>
        </button>
        <button onclick="input_absensi()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 transition">
            <span class="text-xl">📢</span>
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

<script>
    function dashboard_guru() { window.location.href = "index.php?page=dashboard"; }
    function input_absensi() { window.location.href = "index.php?page=inputabsensi"; }
    function pengaturan_guru() { window.location.href = "index.php?page=pengaturan"; }
    function logoutsession() {
        if (confirm("Yakin ingin logout?")) {
            window.location.href = "/Tugas-Akhir/logout.php";
        }
    }
</script>
