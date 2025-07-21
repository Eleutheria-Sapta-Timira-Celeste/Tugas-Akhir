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
        window.location.replace('/Tugas-Akhir/admin/dashboard.php'); // dashboard admin
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
