<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}
?>

<aside id="sidebar" class="bg-[#d49f5f] text-white h-screen fixed top-0 left-0 w-64 flex flex-col transition-all duration-300 ease-in-out z-40 overflow-y-auto mt-auto">
    <div class="p-4 text-center border-b border-orange-300">
        <img src="../assects/images/defaults/logo_warna.png" alt="Logo" class="mx-auto mb-2 w-16 h-16 transition-all duration-300" id="sidebar-logo">
        <span class="text-sm font-bold sidebar-label block transition-all duration-300">SMP PGRI 371 Pondok Aren</span>
    </div>

    <nav class="mt-4 flex flex-col px-2 space-y-1 text-sm">
        <button onclick="window.location.href='index.php?page=dashboard'" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            🏠 <span class="sidebar-label">Dashboard</span>
        </button>
        <button onclick="window.location.href='index.php?page=melihat_absensi'" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📝 <span class="sidebar-label">Absensi</span>
        </button>
        <button onclick="window.location.href='index.php?page=pengaturan'" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            ⚙️ <span class="sidebar-label">Pengaturan</span>
        </button>
        <button onclick="logoutsession()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3 mt-2">
            ⏻ <span class="sidebar-label">Logout (<?= $_SESSION["username"]; ?>)</span>
        </button>

        <div class="mt-auto px-3 pb-4"></div>
    </nav>
</aside>



<script>
    function toDashboard() { window.location.href = "index.php?page=dashboard"; }
    function toAbsensi() { window.location.href = "index.php?page=melihat_absensi"; }
    function toPengaturan() { window.location.href = "index.php?page=pengaturan"; }
    function logoutsession() {
        if (confirm("Yakin ingin logout?")) {
            window.location.href = "/Tugas-Akhir/logout.php";
        }
    }
</script>
