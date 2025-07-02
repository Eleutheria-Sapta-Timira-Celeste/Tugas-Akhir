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
                    <li><a href="login.php" class="text-sm md:text-base hover:text-gray-900">Akses</a></li>

           <button onclick="window.location.href='spmb/index.php'"
    class="inline-flex items-center border-0 py-1 px-3 focus:outline-none rounded text-base mt-4 md:mt-0 text-white bg-[#ef6c00] hover:bg-[#e65c00] focus:ring-4 focus:ring-[#ef6c00] font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">
    SPMB
    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
    </svg>
</button>

        </div>
    </header>