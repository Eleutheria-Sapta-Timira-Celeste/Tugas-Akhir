<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Header -->
<header id="navbar"
    class="fixed top-0 z-50 w-full text-white bg-[#d49f5f] shadow-md">
    <div class="container mx-auto flex justify-center">
    <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-6 p-4 md:p-5">
        
        <!-- Logo -->
        <a onclick="homepage()" class="flex items-center cursor-pointer">
            <img src="assects/images/defaults/logoo.png" alt="Logo" class="h-14 md:h-16 w-auto">
        </a>

        <!-- Navigasi Menu -->
       <nav class="flex flex-wrap justify-center space-x-3 md:space-x-5 font-bold text-lg md:text-lg items-center">
            <a href="index.php" class="hover:text-white transition">Beranda</a>
            <a href="aboutus.php" class="hover:text-white transition">Tentang</a>
            <a href="notice.php" class="hover:text-white transition">Pengumuman</a>
            <a href="extras.php" class="hover:text-white transition">Informasi Sekolah</a>
            <a href="contactUs.php" class="hover:text-white transition">Hubungi</a>
            <a href="login.php" class="hover:text-white transition">Akses</a>
        </nav>

        <!-- Tombol SPMB -->
        <button onclick="window.location.href='spmb/index.php'"
            class="text-white bg-[#a66c30] hover:bg-[#a66c30] font-medium rounded-md text-lg md:text-lg px-8 py-1 text-center transition flex items-center">
            SPMB
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" class="w-6 h-6 ml-1" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</header>

<!-- Spacer supaya konten tidak ketimpa header -->
<div class="h-[100px]"></div>

<script>
    function homepage() {
        window.location.replace('index.php');
    }
</script>
