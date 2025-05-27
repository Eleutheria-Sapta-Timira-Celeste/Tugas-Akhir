<?php
include 'connection/database.php';

try {

    $query = "SELECT * FROM web_content WHERE id = 1";
    $flash_query = "SELECT * FROM flash_notice WHERE id = 1";

    $result = mysqli_query($connection, $query);
    $flash_result = mysqli_query($connection, $flash_query);



    if ($result) {

        $row = mysqli_fetch_assoc($result);
        $flash_notice = mysqli_fetch_assoc($flash_result);

    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {

    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">
    <link rel="stylesheet" href="css/animation.css">
    <style>

    </style>
</head>

<body>
   
<?php include('includes/header.php') ?>



    <!-- This is an example component -->
    <div class="mx-auto">

        <div id="default-carousel" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <span
                        class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800">First
                        Slide</span>
                    <img src="assects/images/schoolImages/gedung_utama.jpg"
                        class="object-contain block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                        alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="assects/images/schoolImages/beranda2.jpg"
                        class="object-contain block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                        alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="assects/images/schoolImages/beranda3.jpg"
                        class="object-contain block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2"
                        alt="...">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                    data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    <span class="hidden">Sebelumnya</span>
                </span>
            </button>
            <button type="button"
                class="nextimage flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="hidden">Selanjutnya</span>
                </span>
            </button>
        </div>

        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    </div>


<h1 class="mt-10 mx-6 text-6xl font-black uppercase tracking-wider text-center 
    bg-gradient-to-r from-amber-300 to-rose-400 via-yellow-200 text-gray-900 
    py-8 px-6 rounded-2xl shadow-3xl border-4 border-yellow-500 
    transition-all duration-500 ease-in-out 
    hover:animate-[gradient-shift_1s_linear_infinite]">
     SMP PGRI 371 Pondok Aren 
</h1>





        <!-- <p><?php echo $row['one']; ?></p> -->

        
        
        <section class="container mx-auto p-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card with Scaling, Rotation, and Glow -->
    <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
        <h3 class="text-2xl font-bold text-gray-800">📚 Pendidikan Berkualitas</h3>
        <p class="text-gray-600">Menyediakan kurikulum terbaik dengan tenaga pendidik berpengalaman.</p>
    </div>

    <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
        <h3 class="text-2xl font-bold text-gray-800">🏆 Prestasi Luar Biasa</h3>
        <p class="text-gray-600">Murid-murid kami telah meraih keberhasilan akademik dan non-akademik.</p>
    </div>

    <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
        <h3 class="text-2xl font-bold text-gray-800">🌎 Fasilitas Modern</h3>
        <p class="text-gray-600">Laboratorium, perpustakaan, dan ruang kelas yang nyaman untuk pembelajaran maksimal.</p>
    </div>

    <!-- Interactive Gradient Card with Animated Color Flow -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-110 hover:shadow-2xl flex flex-col items-center justify-center hover:bg-gradient-to-l">
        <h3 class="text-2xl font-extrabold">🚀 Bergabung Bersama Kami!</h3>
        <p class="text-lg text-gray-100 text-center mt-2">Jadilah bagian dari perjalanan pendidikan yang luar biasa.</p>
        <a href="spmb/index.php" class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg shadow-md transition hover:scale-105 hover:rotate-2">
            🔰 Daftar Sekarang
        </a>
    </div>
</section>

    </div>
</div>
</div>
<section class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Left Column -->
    <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-orange-600 pb-2">
            🏫 Kenapa Memilih SMP PGRI 371 Pondok Aren?
        </h1>
        <p class="text-lg text-gray-700 leading-relaxed">
            <?php echo $row['two']; ?>
        </p>
    </div>

    <!-- Right Column -->
    <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-blue-600 pb-2">
            💬 Apa yang Murid Katakan Tentang Sekolah?
        </h1>
        <p class="text-lg text-gray-700 leading-relaxed">
            <?php echo $row['seven']; ?>
        </p>
    </div>
</section>

<section class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Left Column -->
    <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-orange-600 pb-2">
            📚 Ujian Berbasis Online
        </h1>
        <p class="text-lg text-gray-700 leading-relaxed">
            <?php echo $row['eight']; ?>
        </p>
    </div>

    <!-- Right Column -->
    <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 hover:scale-105 hover:shadow-lg hover:bg-gray-100">
        <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-green-600 pb-2">
            🔍 Fasilitas & Teknologi di SMP PGRI 371
        </h1>
        <p class="text-lg text-gray-700 leading-relaxed">
            Sekolah kami menyediakan fasilitas modern yang mendukung pembelajaran berbasis teknologi. Mulai dari laboratorium komputer terkini hingga sistem ujian online, kami memastikan setiap murid memperoleh pengalaman pendidikan terbaik.
        </p>
    </div>
</section>

    <?php include('includes/footer.php') ?>


    

<?php 
if($flash_notice['trun_flash'] == "1"){
echo '
<div id="info-popup" tabindex="-1" class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-cream-800 md:p-8">
            <div class="mb-4 text-sm font-light text-black-500 dark:text-black-400">
                <h3 class="mb-3 text-2xl font-bold text-gray-900 dark:text-black">'. $flash_notice['title'] .'</h3>
                <img class="object-cover w-full rounded-lg" src="'. $flash_notice['image_url'] .'" alt="">
                <p class="mt-3 font-bold">
                    '. $flash_notice['message'] . '
                </p>
            </div>
            <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">
               <a href="aboutus.php" style="color: #ef6c00;" class="font-medium hover:underline">Lihat Tentang Sekolah</a>

                <div class="items-center space-y-4 sm:space-x-4 sm:flex sm:space-y-0">                 
                    <button id="close-modal" type="button"
                        style="background-color: #ef6c00;"
                        class="py-2 px-4 w-full text-sm font-medium text-center text-white rounded-lg sm:w-auto hover:brightness-110 focus:ring-4 focus:outline-none focus:ring-orange-300">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
';
}
?>
</body>
<script>
const modalEl = document.getElementById('info-popup');
const privacyModal = new Modal(modalEl, {
    placement: 'center'
});

privacyModal.show();

const closeModalEl = document.getElementById('close-modal');
closeModalEl.addEventListener('click', function() {
    privacyModal.hide();
});

setInterval(updatecarsoul, 5000);

function updatecarsoul() {
    document.getElementsByClassName('nextimage')[0].click();
}
//console.clear();
</script>

</html>