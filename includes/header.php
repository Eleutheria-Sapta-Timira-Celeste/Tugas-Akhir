<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Header -->
<header id="navbar"
    class="fixed top-0 z-50 py-0 w-full transition-all duration-300 ease-in-out text-white"
    style="background-color: transparent;">
    <div class="container mx-auto flex justify-center relative">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-6 p-4 md:p-5">

            <!-- Logo -->
            <a onclick="homepage()" class="flex items-center cursor-pointer">
                <img src="assects/images/defaults/logoo.png" alt="Logo" class="h-14 md:h-16 w-auto">
            </a>

            <!-- Menu Navigasi (Desktop Only) -->
            <nav class="hidden md:flex flex-wrap justify-center space-x-3 md:space-x-5 font-bold text-lg md:text-lg items-center">
                <a href="index.php" class="hover:text-[#a9745a] transition">Beranda</a>
                <a href="aboutus.php" class="hover:text-[#a9745a] transition">Tentang</a>
                <a href="notice.php" class="hover:text-[#a9745a] transition">Pengumuman</a>
                <a href="extras.php" class="hover:text-[#a9745a] transition">Informasi Sekolah</a>
                <a href="contactUs.php" class="hover:text-[#a9745a] transition">Hubungi</a>
                <a href="login.php" class="hover:text-[#a9745a] transition">Akses</a>
            </nav>

            <!-- Tombol SPMB (Desktop Only) -->
            <button onclick="window.location.href='spmb/index.php'"
                class="hidden md:flex text-white bg-[#a66c30] hover:bg-[#a66c30] font-medium rounded-md text-lg md:text-lg px-8 py-1 text-center transition items-center">
                SPMB
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" class="w-6 h-6 ml-1" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>

        <!-- Hamburger Toggle (Mobile Only) -->
        <button id="menu-toggle" class="absolute right-5 top-5 md:hidden focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden md:hidden flex flex-col space-y-2 px-4 pb-4 pt-2 bg-transparent font-semibold text-white shadow transition-all duration-300 ease-in-out">
        <a href="index.php" class="block hover:text-[#fbd4b5]">Beranda</a>
        <a href="aboutus.php" class="block hover:text-[#fbd4b5]">Tentang</a>
        <a href="notice.php" class="block hover:text-[#fbd4b5]">Pengumuman</a>
        <a href="extras.php" class="block hover:text-[#fbd4b5]">Informasi Sekolah</a>
        <a href="contactUs.php" class="block hover:text-[#fbd4b5]">Hubungi</a>
        <a href="login.php" class="block hover:text-[#fbd4b5]">Akses</a>
       <!-- Tombol SPMB untuk mobile, rata kiri -->
        <button onclick="window.location.href='spmb/index.php'"
            class="bg-white text-[#a66c30] px-4 py-2 rounded-md hover:bg-gray-100 flex items-center font-semibold w-fit">
            SPMB
            <svg fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5 ml-1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

    </div>
</header>

<!-- Script Toggle Hamburger -->
<script>
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('mobile-menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    function homepage() {
        window.location.replace('index.php');
    }
</script>

<script>
    const navbar = document.getElementById('navbar');
    const mobileMenu = document.getElementById('mobile-menu');

    window.addEventListener('scroll', () => {
        // Navbar
        if (window.scrollY > 50) {
            navbar.classList.remove('text-white');
            navbar.classList.add('text-white', 'shadow-lg');
            navbar.style.backgroundColor = '#d49f5f';

            // Mobile Menu background
            if (mobileMenu) {
                mobileMenu.classList.remove('bg-transparent');
                mobileMenu.classList.add('bg-[#a66c30]');
            }
        } else {
            navbar.classList.add('text-white');
            navbar.classList.remove('text-black', 'shadow-lg');
            navbar.style.backgroundColor = 'transparent';

            // Mobile Menu background
            if (mobileMenu) {
                mobileMenu.classList.remove('bg-[#a66c30]');
                mobileMenu.classList.add('bg-transparent');
            }
        }
    });
</script>
