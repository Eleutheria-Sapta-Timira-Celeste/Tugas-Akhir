<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender - SMP PGRI 371</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/images/logo2.png">
    <style>
        input {
            border-radius: 20px;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php include("includes/header2.php") ?>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]">Kalender Akademik</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    Para siswa SMP PGRI 371 Pondok Aren, 📅 Berikut terlampir kalender akademik sebagai referensi kalian mengenai jadwal kegiatan dan hari libur sekolah. Disarankan untuk selalu memeriksa pengumuman resmi agar mendapatkan informasi yang akurat tentang jadwal dan hari libur. 📌
                </p>
            </div>

            <!-- Gambar Kalender -->
            <div class="flex justify-center">
                <img src="assects/images/calender/kalender-akademik.jpg" alt="Kalender Akademik SMP PGRI 371"
                     style="max-width: 100%; height: auto; border: 1px solid #ccc; border-radius: 10px;">
            </div>
        </div>
    </section>

    <?php include("includes/footer.php") ?>
</body>

<script>
    console.clear();
</script>

</html>
