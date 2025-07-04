<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

try {

    $query1 = "SELECT * FROM web_content WHERE id = 1";
    $query2 = "SELECT * FROM web_content WHERE id = 2";
    $query3 = "SELECT * FROM web_content WHERE id = 4";
    $query4 = "SELECT * FROM web_content WHERE id = 5";
    $query5 = "SELECT * FROM web_content WHERE id = 6";

    $result1 = mysqli_query($connection, $query1);
    $result2 = mysqli_query($connection, $query2);
    $result3 = mysqli_query($connection, $query3);
    $result4 = mysqli_query($connection, $query4);
    $result5 = mysqli_query($connection, $query5);


    if ($result1) {

        $home = mysqli_fetch_assoc($result1);
        $about = mysqli_fetch_assoc($result2);
        $contactus = mysqli_fetch_assoc($result3);
        $joinus = mysqli_fetch_assoc($result4);
        $extras = mysqli_fetch_assoc($result5);
    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {

    mysqli_close($connection);
}

// Updating Web Content from here php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {




    if ($connectionobj->connect_error) {
        die("Connection failed: " . $connectionobj->connect_error);
    }

    //HOME PAGE - Variables to get new site content
    $homeOne = $_POST['homeOne'];
    $homeTwo = $_POST['homeTwo'];
    $homeThree = $_POST['homeThree'];
    $homeFour = $_POST['homeFour'];
    $homeFive = $_POST['homeFive'];
    $homeSix = $_POST['homeSix'];
    $homeSeven = $_POST['homeSeven'];
    $homeEight = $_POST['homeEight'];

    //ABOUT PAGE - Variables to get new site content
    $aboutOne = $_POST['aboutOne'];
    $aboutTwo = $_POST['aboutTwo'];
    $aboutThree = $_POST['aboutThree'];
    $aboutFour = $_POST['aboutFour'];
    $aboutFive = $_POST['aboutFive'];
    $aboutSix = $_POST['aboutSix'];
    $aboutSeven = $_POST['aboutSeven'];
    $aboutEight = $_POST['aboutEight'];
    $aboutNine = $_POST['aboutNine'];
    $aboutTen = $_POST['aboutTen'];
    $aboutEleven = $_POST['aboutEleven'];
    $aboutTwelve = $_POST['aboutTwelve'];
    $aboutThirteen = $_POST['aboutThirteen'];
    $aboutFourteen = $_POST['aboutFourteen'];
    $aboutFifteen = $_POST['aboutFifteen'];
    $aboutSixteen = $_POST['aboutSixteen'];
    $aboutSeventeen = $_POST['aboutSeventeen'];
    $aboutEighteen = $_POST['aboutEighteen'];
    $aboutNinteen = $_POST['aboutNinteen'];
    $aboutTwenty = $_POST['aboutTwenty'];
    $aboutTwentyone = $_POST['aboutTwentyone'];

    //Extra PAGE - Variables to get new site content
    $extraOne = $_POST['extraOne'];

    //Contact Us PAGE - Variables to get new site content
    $contactOne = $_POST['contactOne'];

    //Join Us Us PAGE - Variables to get new site content
    $joinOne = $_POST['joinOne'];

    
    //Preparing Querry for each site
    $homequerry = "UPDATE `web_content` SET `one` = ?, `two` = ?, `three`= ?, `four` = ?, `five` = ?, `six` = ?,  `seven`= ?, `eight`= ? WHERE `web_content`.`id` = 1;";

    $aboutquerry = "UPDATE `web_content` SET `one` = ?, `two` = ?, `three`= ?, `four` = ?, `five` = ?, `six` = ?,  `seven`= ?, `eight`= ?, `nine`= ?, `ten`= ?, `eleven`= ?, `twelve`= ?, `thirteen`= ?, `fourteen`= ?, `fifteen`= ?, `sixteen`= ?, `seventeen`= ?, `eighteen`= ?, `ninteen`= ?, `twenty`= ?, `twentyone`= ? WHERE `web_content`.`id` = 2;";

    $extraquerry = "UPDATE `web_content` SET `one` = ? WHERE `web_content`.`id` = 6;";

    $contactquerry = "UPDATE `web_content` SET `one` = ? WHERE `web_content`.`id` = 4;";

    $joinquerry = "UPDATE `web_content` SET `one` = ? WHERE `web_content`.`id` = 5;";



    $stmt = $connectionobj->prepare($homequerry);
    $aboutExecute = $connectionobj->prepare($aboutquerry);
    $extraExecute = $connectionobj->prepare($extraquerry);
    $contactExecute = $connectionobj->prepare($contactquerry);
    $joinExecute = $connectionobj->prepare($joinquerry);




    // Binding String param each page
    $stmt->bind_param("ssssssss", $homeOne, $homeTwo, $homeThree, $homeFour, $homeFive, $homeSix, $homeSeven, $homeEight);

    $aboutExecute->bind_param("sssssssssssssssssssss", $aboutOne, $aboutTwo, $aboutThree, $aboutFour, $aboutFive, $aboutSix, $aboutSeven, $aboutEight, $aboutNine, $aboutTen, $aboutEleven, $aboutTwelve, $aboutThirteen, $aboutFourteen, $aboutFifteen, $aboutSixteen, $aboutSeventeen, $aboutEighteen, $aboutNinteen, $aboutTwenty, $aboutTwentyone);

    $extraExecute->bind_param("s", $extraOne);
    $contactExecute->bind_param("s", $contactOne);
    $joinExecute->bind_param("s", $joinOne);



    // Executing and alerting site sucess
    if ($stmt->execute() && $aboutExecute->execute() && $extraExecute->execute() && $contactExecute->execute() && $joinExecute->execute()) {
        echo "
            <script>
            alert('Content Update Sucessfully!');
            window.location.replace('site_content.php');
            </script>
        ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $aboutExecute->close();
    $extraExecute->close();
    $contactExecute->close();
    $joinExecute->close();

    $connectionobj->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situs Konten</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body>
    <?php include('../includes/admin_header.php') ?>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-5">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #e65100;">
Ubah Isi Konten Situs</h1>
                     <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                     Harap diperhatikan bahwa konten pada setiap halaman dapat mengalami perubahan atau modifikasi mulai saat ini. Sebelum menyimpan konten apa pun, sangat disarankan untuk melakukan konfirmasi dan validasi terhadap perubahan yang telah dilakukan. Terima kasih atas perhatian Anda dalam menjaga keakuratan dan integritas informasi yang disajikan.</p>
                </div>
            </div>
        </section>
        <form action="" method="POST">
        <div class="m-5" id="accordion-collapse" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span>Beranda</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">SMP PGRI 371 Pondok Aren</p>
            <textarea name="homeOne" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['one']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Kenapa SMP PGRI 371 Pondok Aren ?</p>
            <textarea name="homeTwo" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['two']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Kenapa SMP PGRI 371 Pondok Aren ? - Guru Berkualitas Tinggi</p>
            <textarea name="homeThree" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['three']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Kenapa SMP PGRI 371 Pondok Aren ? - Lingkungan yang Nyaman</p>
            <textarea name="homeFour" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['four']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Kenapa SMP PGRI 371 Pondok Aren ? - Pembelajaran Digtial</p>
            <textarea name="homeFive" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['five']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Kenapa SMP PGRI 371 Pondok Aren ? - Fasilitas yang Lengkap</p>
            <textarea name="homeSix" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['six']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Apa yang Murid Katakan Tentang SMP PGRI 371 Pondok Aren ?</p>
            <textarea name="homeSeven" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['seven']; ?></textarea>

            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Ujian Berbasis Online</p>
            <textarea name="homeEight" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $home['eight']; ?></textarea>

            </div>
        </div>

        <!-- About Section Started from here -->

        <h2 id="accordion-collapse-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span>Tentang</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Perkenalan</p>
                <textarea name="aboutOne" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['one']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Sambutan Kepala Sekolah</p>
                <textarea name="aboutTwo" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['two']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Tata Tertib dan Peraturan Sekolah</p>
                <textarea name="aboutThree" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['three']; ?></textarea>

                <textarea name="aboutFour" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['four']; ?></textarea>
                <textarea name="aboutFive" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['five']; ?></textarea>
                <textarea name="aboutSix" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['six']; ?></textarea>
                <textarea name="aboutSeven" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['seven']; ?></textarea>
                <textarea name="aboutEight" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['eight']; ?></textarea>
                <textarea name="aboutNine" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['nine']; ?></textarea>
                <textarea name="aboutTen" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['ten']; ?></textarea>
                <textarea name="aboutEleven" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['eleven']; ?></textarea>
                <textarea name="aboutTwelve" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-2"><?php echo $about['twelve']; ?></textarea>
                <textarea name="aboutThirteen" rows="1" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['thirteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Mata Pelajaran Kami</p>
                <textarea name="aboutFourteen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['fourteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Mata Pelajaran - Matematika</p>
                <textarea name="aboutFifteen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['fifteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Mata Pelajaran - Bahasa Indonesia</p>
                <textarea name="aboutSixteen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['sixteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Fasilitas Kami</p>
                <textarea name="aboutSeventeen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['seventeen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Fasilitas Kami - Ruang Kelas AC</p>
                <textarea name="aboutEighteen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['eighteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Fasilitas Kami - Lab Komputer</p>
                <textarea name="aboutNinteen" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['ninteen']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Fasilitas Kami - Ruang Kesehatan Siswa</p>
                <textarea name="aboutTwenty" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['twenty']; ?></textarea>

                <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Fasilitas Kami - Lab IPA</p>
                <textarea name="aboutTwentyone" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $about['twentyone']; ?></textarea>
            </div>
        </div>
        <h2 id="accordion-collapse-heading-5">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-5" aria-expanded="false" aria-controls="accordion-collapse-body-5">
            <span>Extra</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Deskripsi Lanjutan</p>
                <textarea name="extraOne" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $extras['one']; ?></textarea>
            </div>
        </div>
        <h2 id="accordion-collapse-heading-6">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-6" aria-expanded="false" aria-controls="accordion-collapse-body-6">
            <span>Hubungi</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-6" class="hidden" aria-labelledby="accordion-collapse-heading-6">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Deskripsi Kontak Sekolah</p>
                <textarea name="contactOne" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $contactus['one']; ?></textarea>
            </div>
        </div>
        
        <h2 id="accordion-collapse-heading-3">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span>SPMB</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
            <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
            <p class="mb-2 font-bold text-gray-500 dark:text-gray-600">Deskripsi SPMB</p>
                <textarea name="joinOne" rows="5" type="text" class="w-full text-gray-500 dark:text-gray-400 mb-5"><?php echo $joinus['one']; ?></textarea>
            </div>
        </div>
        
        </div>
        

        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a class="flex items-center space-x-3 rtl:space-x-reverse">
                
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="submit"
  class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2 text-center"
  style="background-color: #ef6c00; 
         box-shadow: 0 0 0 4px rgba(239, 108, 0, 0.3);"
  onmouseover="this.style.backgroundColor='#d55a00';"
  onmouseout="this.style.backgroundColor='#ef6c00';"
>
  Simpan Konten
</button>

                    
                
            </div>
        
        </div>
    </form>

        

    <?php include('../includes/admin_footer.php') ?>

<script>

console.clear();

</script>

</body>


</html>