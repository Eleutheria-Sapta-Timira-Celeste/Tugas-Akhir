<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Script untuk navigasi -->
<script>
    function logoutsession() {
        window.location.replace('/Tugas-Akhir/logout.php'); // arahkan ke root logout.php
    }

    function indexme() {
        window.location.replace('/Tugas-Akhir/guru/dashboard.php'); // dashboard admin
    }
</script>


<header class="bg-[#bd8035] text-white flex items-center justify-between h-16 w-full transition-all duration-300 pl-4 pr-6">
    <div class="flex items-center gap-4">
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
        <span class="font-bold text-lg">SMP PGRI 371 Pondok Aren</span>
    </div>
    <div class="flex items-center gap-4">
        


    </div>
</header>

<!-- Toggle Sidebar Script -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const logo = document.getElementById("sidebar-logo");
        const menuTexts = document.querySelectorAll(".menu-text");
        const mainContent = document.getElementById("main-content");

        const isExpanded = sidebar.classList.contains("w-64");

        if (isExpanded) {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-20");
            mainContent.classList.remove("ml-64");
            mainContent.classList.add("ml-20");

            logo.classList.add("w-10", "h-10");
            logo.classList.remove("w-16", "h-16");
            menuTexts.forEach(text => text.classList.add("hidden"));

            localStorage.setItem('sidebarState', 'collapsed');
        } else {
            sidebar.classList.remove("w-20");
            sidebar.classList.add("w-64");
            mainContent.classList.remove("ml-20");
            mainContent.classList.add("ml-64");
 logo.classList.add("w-16", "h-16");
            logo.classList.remove("w-10", "h-10");
            menuTexts.forEach(text => text.classList.remove("hidden"));

            localStorage.setItem('sidebarState', 'expanded');
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById("sidebar");
        const logo = document.getElementById("sidebar-logo");
        const menuTexts = document.querySelectorAll(".menu-text");
        const mainContent = document.getElementById("main-content");
        const state = localStorage.getItem("sidebarState");

        if (state === "collapsed") {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-20");
            mainContent.classList.remove("ml-64");
            mainContent.classList.add("ml-20");
            logo.classList.add("w-10", "h-10");
            logo.classList.remove("w-16", "h-16");
            menuTexts.forEach(text => text.classList.add("hidden"));
        }
    });
</script>

