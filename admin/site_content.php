<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($connectionobj->connect_error) {
        die("Connection failed: " . $connectionobj->connect_error);
    }

    $homeOne = $_POST['homeOne'];
    $homeTwo = $_POST['homeTwo'];
    $homeThree = $_POST['homeThree'];
    $homeFour = $_POST['homeFour'];
    $homeFive = $_POST['homeFive'];
    $homeSix = $_POST['homeSix'];
    $homeSeven = $_POST['homeSeven'];
    $homeEight = $_POST['homeEight'];

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

    $extraOne = $_POST['extraOne'];
    $contactOne = $_POST['contactOne'];
    $joinOne = $_POST['joinOne'];

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

    $stmt->bind_param("ssssssss", $homeOne, $homeTwo, $homeThree, $homeFour, $homeFive, $homeSix, $homeSeven, $homeEight);
    $aboutExecute->bind_param("sssssssssssssssssssss", $aboutOne, $aboutTwo, $aboutThree, $aboutFour, $aboutFive, $aboutSix, $aboutSeven, $aboutEight, $aboutNine, $aboutTen, $aboutEleven, $aboutTwelve, $aboutThirteen, $aboutFourteen, $aboutFifteen, $aboutSixteen, $aboutSeventeen, $aboutEighteen, $aboutNinteen, $aboutTwenty, $aboutTwentyone);
    $extraExecute->bind_param("s", $extraOne);
    $contactExecute->bind_param("s", $contactOne);
    $joinExecute->bind_param("s", $joinOne);

    if ($stmt->execute() && $aboutExecute->execute() && $extraExecute->execute() && $contactExecute->execute() && $joinExecute->execute()) {
        echo "<script>alert('Content Update Sucessfully!'); window.location.replace('index.php?page=site_content');</script>";
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
    <title>Edit Konten Situs</title>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <style>
      body,
      section,
      .border,
      textarea,
      .dark\:bg-gray-900,
      .dark\:hover\:bg-gray-800,
      .hover\:bg-gray-100,
      .dark\:text-gray-400,
      .dark\:text-gray-600,
      .text-gray-500,
      .dark\:border-gray-700,
      .border-gray-200 {
        background-color: white !important;
        color: #333 !important;
      }
      textarea {
        background-color: white !important;
        color: #333 !important;
        border: 1px solid #ccc !important;
      }
      .hover\:bg-gray-100:hover,
      .dark\:hover\:bg-gray-800:hover {
        background-color: #f9f9f9 !important;
      }

      button:focus, button:active, button:focus-visible {
        outline: none !important;
        box-shadow: none !important;
      }
    </style>
</head>

<body>


    <section class="text-gray-600 body-font">
            <div class="container px-5 py-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-2">
                    <h1 class="text-3xl font-bold text-[#a9745a]">Ubah Isi Konten Situs </h1>
                        <p class="text-sm text-gray-600 mt-2 max-w-2xl mx-auto">
                       Halaman ini digunakan untuk mengubah, menambah, atau menghapus konten situs seperti profil sekolah, visi misi, informasi kepala sekolah, dan lainnya.
                       Sistem ini dirancang agar admin dapat memperbarui informasi dengan mudah demi menjaga situs tetap informatif dan relevan.
                    </p>
                </div>
            </div>
    </section>        
<form action="" method="POST" class="px-6 pb-10">
    <div id="accordion-collapse" data-accordion="collapse">

        <!-- START: SECTION TEMPLATE -->
        <!-- Copy & modify untuk setiap bagian: Beranda, Tentang, Extra, Hubungi, SPMB -->
        <div class="mb-4 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <h2>
                <button type="button" class="flex justify-between items-center w-full px-5 py-4 bg-[#f6f6f6] text-base font-semibold text-gray-700 hover:bg-[#efefef] transition"
                    data-accordion-target="#accordion-home" aria-expanded="true" aria-controls="accordion-home">
                    <span>📌 Beranda</span>
                    <svg class="w-4 h-4 shrink-0 rotate-180 transition-transform" data-accordion-icon fill="none" viewBox="0 0 10 6">
                        <path d="M9 5L5 1 1 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-home" class="hidden" aria-labelledby="heading-home">
                <div class="p-5 bg-white space-y-4">
                    <?php 
                        $homeFields = [
                            "one" => "SMP PGRI 371 Pondok Aren",
                            "two" => "Kenapa SMP PGRI 371 Pondok Aren ?",
                            "three" => "Kenapa SMP PGRI 371 Pondok Aren ? - Guru Berkualitas Tinggi",
                            "four" => "Kenapa SMP PGRI 371 Pondok Aren ? - Lingkungan yang Nyaman",
                            "five" => "Kenapa SMP PGRI 371 Pondok Aren ? - Pembelajaran Digital",
                            "six" => "Kenapa SMP PGRI 371 Pondok Aren ? - Fasilitas yang Lengkap",
                            "seven" => "Apa yang Murid Katakan Tentang SMP PGRI 371 Pondok Aren ?",
                            "eight" => "Ujian Berbasis Online"
                        ];
                        foreach ($homeFields as $key => $label) {
                            echo '
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-700">' . $label . '</label>
                                <textarea name="home' . ucfirst($key) . '" rows="4" class="w-full p-3 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#fc941e] focus:border-[#fc941e] transition">' . htmlspecialchars($home[$key]) . '</textarea>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- About Section Started from here -->
 <div class="mb-4 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <h2>
                <button type="button" class="flex justify-between items-center w-full px-5 py-4 bg-[#f6f6f6] text-base font-semibold text-gray-700 hover:bg-[#efefef] transition"
                    data-accordion-target="#accordion-about" aria-expanded="false" aria-controls="accordion-about">
                    <span>📖 Tentang</span>
                    <svg class="w-4 h-4 shrink-0 transition-transform" data-accordion-icon fill="none" viewBox="0 0 10 6">
                        <path d="M9 5L5 1 1 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-about" class="hidden">
                <div class="p-5 bg-white space-y-4">
                    <?php 
                        $aboutFields = [
                            "one" => "Perkenalan",
                            "two" => "Sambutan Kepala Sekolah",
                            "three" => "Tata Tertib dan Peraturan Sekolah",
                            "four" => "Visi",
                            "five" => "Misi",
                            "six" => "Nilai",
                            "seven" => "Prestasi",
                            "eight" => "Ekstrakurikuler",
                            "nine" => "Struktur Organisasi",
                            "ten" => "Pendidik",
                            "eleven" => "Tenaga Kependidikan",
                            "twelve" => "Fasilitas",
                            "thirteen" => "Kegiatan Sekolah",
                            "fourteen" => "Mata Pelajaran Kami",
                            "fifteen" => "Mata Pelajaran - Matematika",
                            "sixteen" => "Mata Pelajaran - Bahasa Indonesia",
                            "seventeen" => "Fasilitas Kami",
                            "eighteen" => "Fasilitas - Ruang Kelas AC",
                            "ninteen" => "Fasilitas - Lab Komputer",
                            "twenty" => "Fasilitas - Ruang Kesehatan Siswa",
                            "twentyone" => "Fasilitas - Lab IPA"
                        ];
                        foreach ($aboutFields as $key => $label) {
                            echo '
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-700">' . $label . '</label>
                                <textarea name="about' . ucfirst($key) . '" rows="4" class="w-full p-3 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#fc941e] focus:border-[#fc941e] transition">' . htmlspecialchars($about[$key]) . '</textarea>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- extra -->
        <div class="mb-4 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <h2>
        <button type="button" class="flex justify-between items-center w-full px-5 py-4 bg-[#f6f6f6] text-base font-semibold text-gray-700 hover:bg-[#efefef] transition"
            data-accordion-target="#accordion-extra" aria-expanded="false" aria-controls="accordion-extra">
            <span>✨ Extra</span>
            <svg class="w-4 h-4 shrink-0 transition-transform" data-accordion-icon fill="none" viewBox="0 0 10 6">
                <path d="M9 5L5 1 1 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </h2>
    <div id="accordion-extra" class="hidden">
        <div class="p-5 bg-white space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi Lanjutan</label>
                <textarea name="extraOne" rows="5" class="w-full p-3 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#fc941e] focus:border-[#fc941e] transition"><?php echo htmlspecialchars($extras['one']); ?></textarea>
            </div>
        </div>
    </div>
</div>

<!-- SECTION: Hubungi -->
<div class="mb-4 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <h2>
        <button type="button" class="flex justify-between items-center w-full px-5 py-4 bg-[#f6f6f6] text-base font-semibold text-gray-700 hover:bg-[#efefef] transition"
            data-accordion-target="#accordion-contact" aria-expanded="false" aria-controls="accordion-contact">
            <span>📞 Hubungi</span>
            <svg class="w-4 h-4 shrink-0 transition-transform" data-accordion-icon fill="none" viewBox="0 0 10 6">
                <path d="M9 5L5 1 1 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </h2>
    <div id="accordion-contact" class="hidden">
        <div class="p-5 bg-white space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi Kontak Sekolah</label>
                <textarea name="contactOne" rows="5" class="w-full p-3 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#fc941e] focus:border-[#fc941e] transition"><?php echo htmlspecialchars($contactus['one']); ?></textarea>
            </div>
        </div>
    </div>
</div>

<!-- spmb -->
        
<!-- SECTION: SPMB -->
<div class="mb-4 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <h2>
        <button type="button" class="flex justify-between items-center w-full px-5 py-4 bg-[#f6f6f6] text-base font-semibold text-gray-700 hover:bg-[#efefef] transition"
            data-accordion-target="#accordion-spmb" aria-expanded="false" aria-controls="accordion-spmb">
            <span>📋 SPMB</span>
            <svg class="w-4 h-4 shrink-0 transition-transform " data-accordion-icon fill="none" viewBox="0 0 10 6">
                <path d="M9 5L5 1 1 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </h2>
    <div id="accordion-spmb" class="hidden">
        <div class="p-5 bg-white space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi SPMB</label>
                <textarea name="joinOne" rows="5" class="w-full p-3 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#fc941e] focus:border-[#fc941e] transition"><?php echo htmlspecialchars($joinus['one']); ?></textarea>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-center mt-8">
    <button type="submit"
        class="text-white bg-[#5c3d15] hover:bg-[#4b320f] focus:ring-4 focus:outline-none focus:ring-[#5c3d15]/40 font-semibold rounded-lg text-sm px-6 py-2 shadow-md hover:shadow-lg transition">
         Simpan Konten
    </button>
</div>

    </form>


</body>
</html>
