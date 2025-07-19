<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Header -->
<header id="navbar"
    class="fixed top-0 z-50 py-0 w-full transition-all duration-300 ease-in-out text-white"
    style="background-color: transparent;">
    <div class="container mx-auto flex justify-center">
    <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-6 p-4 md:p-5">

       <!-- Logo -->
<a onclick="homepage()" class="flex items-center cursor-pointer">
    <img src="assects/images/defaults/logoo.png" alt="Logo" class="h-14 md:h-16 w-auto">
</a>

<!-- Menu Navigasi -->
<nav class="flex flex-wrap justify-center space-x-3 md:space-x-5 font-bold text-lg md:text-xl items-center">
    <a href="index.php" class="hover:text-orange-600 transition">Beranda</a>
    <a href="aboutus.php" class="hover:text-orange-600 transition">Tentang</a>
    <a href="notice.php" class="hover:text-orange-600 transition">Pengumuman</a>
    <a href="extras.php" class="hover:text-orange-600 transition">Informasi Sekolah</a>
    <a href="contactUs.php" class="hover:text-orange-600 transition">Hubungi</a>
    <a href="login.php" class="hover:text-orange-600 transition">Akses</a>
</nav>

<!-- Tombol SPMB -->
<button onclick="window.location.href='spmb/index.php'"
    class="text-white bg-[#a66c30] hover:bg-[#a66c30] font-medium rounded-md text-lg md:text-xl px-5 py-2 text-center transition flex items-center">
    SPMB
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
        stroke-width="2" class="w-6 h-6 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
    </svg>
</button>



</header>

<!-- Scroll Script -->
<script>
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.remove('text-white');
            navbar.classList.add('text-white', 'shadow-lg');
            navbar.style.backgroundColor = '#d49f5f';
        } else {
            navbar.classList.add('text-white');
            navbar.classList.remove('text-black', 'shadow-lg');
            navbar.style.backgroundColor = 'transparent';
        }
    });

    function homepage() {
        window.location.replace('index.php');
    }
</script>
