<?php
include 'connection/database.php';
$defaultavatar = "assects/images/defaults/defaultaltimage.jpg"
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Sekolah</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">


</head>

<body>
    <?php include("includes/header.php") ?>

    <section class="bg-white dark:bg-white">

    
  <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]"></h1>
                
            </div>

   <div class="flex justify-center">
                <img src="assects/images/defaults/struktur-1.png" alt="Kalender Akademik SMP PGRI 371"
                     style="max-width: 70%; height: auto; border: 1px solid #ccc; border-radius: 10px;">
            </div>
/>

        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
               <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-[#ef6c00] dark:text-[#ef6c00]">Pimpinan Sekolah</h2>
                <p class="font-light text-gray-600 sm:text-xl dark:text-gray-600">SMP PGRI 371 Pondok Aren dipimpin oleh seorang Kepala Sekolah yang bertanggung jawab dalam mengarahkan visi, misi, serta kebijakan sekolah untuk menciptakan lingkungan belajar yang kondusif dan berprestasi.</p>
            </div>

            <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                <?php


                $pimpinan_sekolah = "SELECT * FROM `pimpinan_sekolah`;";
                $management_committee_members = mysqli_query($connection, $pimpinan_sekolah);
                $total_management_committee_members = mysqli_num_rows($management_committee_members);


                if ($total_management_committee_members > 0) {
                    while ($row = mysqli_fetch_assoc($management_committee_members)) {
                        echo '
                    <div class="text-center text-gray-600 dark:text-gray-600">
                        <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="' . $row['image_src'] . '" onerror="this.src=`' . $defaultavatar . '`">
                            <h3 class="mb-1 text-2xl font-bold tracking-tight text-[#ef6c00] dark:text-[#ef6c00]">

                                <a>' . $row['name'] . '</a>
                            </h3>
                            <p>' . $row['position'] . '</p>
                    </div>
                    
            ';
                    }
                }

                ?>

            </div>
        </div>
    </section>
    <section class="bg-white dark:bg-white">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-[#ef6c00] dark:[#ef6c00]">Staff Sekolah</h2>
                <p class="font-light text-gray-500 sm:text-xl dark:text-gray-600">Kepala Sekolah dibantu oleh jajaran staf sekolah yang terdiri dari bendahara, wakil bidang kurikulum, wakil bidang kesiswaan, 
                    kepala tata usaha, kepala laboratorium IPA, wali kelas, pembina OSIS, dan pembina Rohis. Seluruh tim bekerja sama dalam mengelola kegiatan akademik, kesiswaan, dan administrasi sekolah demi kelancaran proses pendidikan.</p>
            </div>

            <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                <?php


                $staffs = "SELECT * FROM `staffs`;";
                $staffs_members = mysqli_query($connection, $staffs);
                $total_staffs = mysqli_num_rows($staffs_members);


                if ($total_staffs > 0) {
                    while ($row_staff = mysqli_fetch_assoc($staffs_members)) {
                        echo '
                                <div class="text-center text-gray-500 dark:text-gray-600">
                                    <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="' . $row_staff['image_src'] . '" onerror="this.src=`' . $defaultavatar . '`">
                                       <h3 class="mb-1 text-2xl font-bold tracking-tight text-[#ef6c00] dark:text-[#ef6c00]">

                                            <a>' . $row_staff['name'] . ' ' . $row_staff['qualification'] . '</a>
                                        </h3>
                                        <p>' . $row_staff['post'] . ' </p>
                                </div>
                                
                                    ';
                    }
                }

                ?>

            </div>
        </div>
    </section>


    <?php include("includes/footer.php") ?>
</body>
<script>console.clear();</script>
</html>