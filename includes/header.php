    <script src="https://cdn.tailwindcss.com"></script>
    <script>
function homepage() {
    window.location.replace('index.php');
}
    </script>
    <script src="javaScript/header_footer.js"></script>
    <!-- unpkg -->
    <script src="https://unpkg.com/@barba/core"></script>

    <!-- jsdelivr -->
    <script src="https://cdn.jsdelivr.net/npm/@barba/core"></script>
    <header class="shadow-inherit text-black-600 body-font sticky top-0 z-50 opacity-95"
        style="box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); background-image: url(assects/images/defaults/header_bg4.png); background-size:cover; background-repeat:no-repeat;">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-black-900 mb-4 md:mb-0">

                <img onclick="homepage()" style="cursor: pointer;" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    class="w-80 h-22 bg-black-500 rounded-full" viewBox="0 0 24 24"
                    src="assects/images/defaults/logoadmin.png">

                <!-- <span class="ml-3 text-xl">SMP PGRI 371 Pondok Aren</span> -->
            </a>
           <nav class="md:ml-auto flex flex-wrap items-center text-base md:font-bold justify-center">
                <ul class="flex space-x-4 items-center">
                    <li><a href="index.php" class="text-sm md:text-base hover:text-gray-900">Beranda</a></li>
                    <li><a href="aboutus.php" class="text-sm md:text-base hover:text-gray-900">Tentang</a></li>
                    <li><a href="notice.php" class="text-sm md:text-base hover:text-gray-900">Pengumuman</a></li>
                    <li><a href="extras.php" class="text-sm md:text-base hover:text-gray-900">Informasi Sekolah</a></li>
                    <li><a href="contactUs.php" class="text-sm md:text-base hover:text-gray-900">Hubungi</a></li>

                    <!-- Dropdown Akses -->
                   <div class="relative group">
                <button class="text-sm md:text-base mr-5 hover:text-gray-900 inline-flex items-center">
                    Akses
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.25 7.5l4.5 4.5 4.5-4.5" />
                    </svg>
                </button>
                <ul class="absolute hidden group-hover:block bg-white shadow-lg mt-2 rounded z-10 min-w-max">
                    <li><a href="admin/login.php" class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Login Admin</a></li>
                    <li><a href="guru/index_guru.php" class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Login Guru</a></li>
                    <li><a href="siswa/login.php" class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Login Siswa</a></li>
                </ul>
                </div>
                </ul>
        </nav>

            <button onclick="spmb()"
                class="inline-flex items-center border-0 py-1 px-3 focus:outline-none rounded text-base mt-4 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-[#ef6c00] dark:hover:bg-blue-700 dark:focus:ring-blue-800">SPMB
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </header>