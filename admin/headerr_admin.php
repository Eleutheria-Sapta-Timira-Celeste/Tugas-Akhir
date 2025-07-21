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


<header class="bg-blue-700 text-white flex items-center justify-between h-16 w-full transition-all duration-300 pl-4 pr-6">
    <div class="flex items-center gap-4">
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
        <span class="font-bold text-lg">SMP PGRI 371 Pondok Aren</span>
    </div>
    <div class="flex items-center gap-4">
        <img src="<?= $logo ?>" class="w-8 h-8 rounded-full border-2 border-white object-cover" alt="Admin">
         <button onclick="logoutsession()" class="inline-flex items-center border-0 py-1 px-3 focus:outline-none rounded text-base mt-4 md:mt-0 text-white bg-[#e65c00] hover:bg-[#cc5200] focus:ring-4 focus:ring-[#ff944d] font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">
            Logout  <?php echo $_SESSION["username"]; ?>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</header>
