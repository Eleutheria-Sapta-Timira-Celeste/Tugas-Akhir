<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Untuk icon FontAwesome -->

<!-- Script untuk navigasi -->
<script>
    function logoutsession() {
        window.location.replace('/Tugas-Akhir/logout.php');
    }

    function indexme() {
        window.location.replace('/Tugas-Akhir/guru/dashboard.php');
    }

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("main-content");

       sidebar.classList.toggle("w-64");
sidebar.classList.toggle("w-16");

mainContent.classList.toggle("ml-64");
mainContent.classList.toggle("ml-16");

    }
</script>

<aside id="sidebar" class="bg-[#d49f5f] text-white h-screen fixed top-0 left-0 w-64 flex flex-col transition-transform transform -translate-x-full duration-300 z-50">
    <div class="p-4 text-center border-b border-orange-300">
        <span class="text-sm font-bold block">Sidebar Aktif</span>
    </div>
    <nav class="p-4">
        <button onclick="logoutsession()" class="hover:bg-[#bd8035] p-2 rounded w-full text-left">Logout</button>
    </nav>
</aside>

<header class="bg-[#bd8035] text-white flex items-center justify-between h-16 w-full transition-all duration-300 pl-6 pr-6">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" id="toggleSidebar" class="text-white text-2xl focus:outline-none ml-2">
            <i class="fas fa-bars"></i>
        </button>
        <span class="font-bold text-lg">SMP PGRI 371 Pondok Aren</span>
    </div>
</header>


