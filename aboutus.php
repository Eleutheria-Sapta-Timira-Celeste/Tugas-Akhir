<?php
include 'connection/database.php';

try {

    $query = "SELECT * FROM web_content WHERE id = 2";
    $result = mysqli_query($connection, $query);


    if ($result) {

        $row = mysqli_fetch_assoc($result);
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
    <title>Tentang</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">

</head>

<body>
    <?php include('includes/header.php') ?>
    <main>



        <section class="text-gray-700 body-font animate-fadeIn">
    <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-center">
        <!-- Text Section -->
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 
            items-center text-center animate-fadeIn">
            <h1 class="title-font sm:text-4xl text-3xl mb-6 font-extrabold text-orange-700 animate-pulse">
                Perkenalan
                <br class="hidden lg:inline-block">
            </h1>
            <p class="text-justify text-sm md:text-base mb-8 leading-relaxed text-gray-600">
                <?php echo $row['one']; ?>
            </p>
            <div class="flex justify-center space-x-4">
                <button onclick="contactbtn()" class="inline-flex text-white border-0 py-2 px-6 focus:outline-none rounded-lg text-lg 
                    bg-orange-600 hover:bg-orange-500 transition duration-300 shadow-lg hover:shadow-xl">
                    Hubungi Kami
                </button>

                <button onclick="joinbtn()" class="inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none rounded-lg text-lg 
                    hover:bg-gray-200 transition duration-300 shadow-md hover:shadow-lg">
                    SPMB
                </button>
            </div>
        </div>

        <!-- Image Section -->
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded-lg shadow-lg transition duration-500 hover:scale-105 hover:shadow-xl" 
                alt="hero" src="assects/images/joinus/joinuss.png">
        </div>
    </div>
</section>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-5 mx-auto flex flex-col">
                <div class="lg:w-4/6 mx-auto">
                    <!-- <div class="rounded-lg h-64 overflow-hidden">
                        <img alt="content" class="object-cover object-center h-full w-full" src="assects/images/schoolImages/mainschool.jpg">
                    </div> -->
                    <div class="flex flex-col sm:flex-row mt-10">
                        <div class="sm:w-1/3 text-center sm:pr-8 sm:py-8">
                            <div class="w-20 h-20 rounded-full inline-flex items-center justify-center bg-gray-200 text-gray-400">

                                <img src="assects/images/staff/kepsek.png" alt="" srcset="">

                            </div>
                            <div class="flex flex-col items-center text-center justify-center">
                                <h2 class="font-medium title-font mt-4 text-gray-900 text-lg">Bapak Sukardi, S.Pd.I., M.M</h2>
                                <div class="w-12 h-1 rounded mt-2 mb-4" style="background-color: #ef6c00;"></div>
                                <p class="text-base">Sambutan Kepala Sekolah</p>
                            </div>
                        </div>
                        <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                            <p class="text-justify text-sm md:text-base leading-relaxed text-lg mb-4">
                            <?php echo $row['two'];?></p>
                           <a href="staffs.php" class="cursor-pointer inline-flex items-center" style="color: #ef9b00;">
        Pimpinan dan Staff Sekolah
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             class="w-4 h-4 ml-2" viewBox="0 0 24 24" style="stroke: #ef9b00;">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
        </svg>
    </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="text-gray-600 body-font animate-fadeIn">
    <div class="container px-5 py-5 mx-auto">
        <div class="text-center mb-10">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-orange-700 animate-pulse">
                Tata Tertib dan Peraturan Sekolah
            </h1>
            <p class="text-justify text-sm md:text-base text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto animate-fadeIn">
                <?php echo $row['three']; ?>
            </p>
        </div>
    </div>
</section>
                <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['four'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['five'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['six'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['seven'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['eight'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                            <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['nine'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['ten'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['eleven'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                             <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['twelve'];?></span>
                        </div>
                    </div>
                    <div class="p-2 sm:w-1/2 w-full">
                        <div class="bg-gray-100 rounded flex p-4 h-full items-center">
                           <svg fill="none" stroke="#ef6c00" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                <path d="M22 4L12 14.01l-3-3"></path>
                            </svg>
                            <span class="text-sm md:text-base title-font font-medium"><?php echo $row['thirteen'];?></span>
                        </div>
                    </div>
                </div>
                <!-- <button class="flex mx-auto mt-16 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Button</button> -->
            </div>
        </section>

        <section id="courses" class="text-gray-700 body-font animate-fadeIn">
    <div class="container px-5 py-24 mx-auto">
        <div class="text-center mb-12">
            <h1 class="title-font sm:text-4xl text-3xl mb-6 font-extrabold text-orange-700 animate-pulse">
                Kegiatan Sekolah
            </h1>
            <p class="text-justify text-sm md:text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto animate-fadeIn">
                <?php echo $row['fourteen']; ?>
            </p>
        </div>

        <div class="flex flex-wrap -mx-4 -mb-10 text-center">
            <!-- Left Section -->
            <div class="sm:w-1/2 mb-10 px-4 animate-fadeIn">
                <div class="rounded-lg h-64 overflow-hidden shadow-lg transition duration-500 hover:scale-105 hover:shadow-xl">
                    <img alt="content" class="object-cover object-center h-full w-full" src="assects/images/courses/pramuka.jpg">
                </div>
                <h2 class="title-font text-2xl font-semibold mt-6 mb-3 text-gray-900">
                    Perkemahan Pramuka
                </h2>
                <p class="text-justify text-sm md:text-base leading-relaxed text-gray-700">
                    <?php echo $row['fifteen']; ?>
                </p>
            </div>

            <!-- Right Section -->
            <div class="sm:w-1/2 mb-10 px-4 animate-fadeIn">
                <div class="rounded-lg h-64 overflow-hidden shadow-lg transition duration-500 hover:scale-105 hover:shadow-xl">
                    <img alt="content" class="object-cover object-center h-full w-full" src="assects/images/schoolImages/beranda2.jpg">
                </div>
                <h2 class="title-font text-2xl font-semibold mt-6 mb-3 text-gray-900">
                    Peringatan Hari Guru
                </h2>
                <p class="text-justify text-sm md:text-base leading-relaxed text-gray-700">
                    <?php echo $row['sixteen']; ?>
                </p>
            </div>
        </div>
    </div>
</section>



       <section class="text-gray-700 body-font animate-fadeIn">
    <div class="container px-5 py-16 mx-auto">
        <div class="w-full mb-12 text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-6 font-extrabold text-orange-700 animate-pulse">
                🏫 Fasilitas Sekolah
            </h1>
            <div class="w-12 h-1 rounded mt-2 mx-auto bg-orange-500 animate-pulse"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fadeIn">
            <!-- Facility Cards -->
            <?php 
                $facilities = [
                    ["Ruang Kelas AC", "assects/images/facilities/ruang_kelas.jpg", $row['eighteen']],
                    ["Perpustakaan", "assects/images/facilities/perpustakaan.jpg", $row['ninteen']],
                    ["Lapangan Olahraga", "assects/images/facilities/lapangan.jpg", $row['twenty']],
                    ["UKS", "assects/images/facilities/Uks.jpg", $row['twentyone']]
                ];
                
                foreach ($facilities as $facility) : 
            ?>
                <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-105">
                    <img class="h-48 rounded-xl w-full object-cover object-center mb-6" src="<?php echo $facility[1]; ?>" alt="content">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                        <?php echo $facility[0]; ?>
                    </h2>
                    <p class="text-sm md:text-base leading-relaxed text-gray-700">
                        <?php echo $facility[2]; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
    </main>


    <?php include('includes/footer.php') ?>

</body>
<script>
    function joinbtn() {
        window.location.href = "joinus.php";
    }

    function contactbtn() {
        window.location.href = "contactUs.php";
    }
    console.clear();
</script>

</html>