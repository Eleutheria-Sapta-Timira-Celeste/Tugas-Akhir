<?php
include '../connection/database.php';
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}

// Check if the user is not an admin
if ($_SESSION["isadmin"] != 1) {
    header("Location: guru_dashboard.php");
    exit();
}

try {

    $query = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";

    $result = mysqli_query($connection, $query);
    $feedback_result = mysqli_query($connection, $query2);



    if ($result) {

        $row = mysqli_fetch_assoc($result);
        $feedback = mysqli_fetch_assoc($feedback_result);

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
    <title>Admin</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <style>

    </style>
</head>

<body>
    <?php include('../includes/admin_header.php') ?>

    <main>
        <section class="text-gray-600 body-font">

            <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-20">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]"> Selamat Datang di Panel Admin</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                Selamat Datang di Panel Admin SMP PGRI 371 Pondok Aren 🏫
                Di sini, Anda akan menemukan semua alat dan sumber daya yang Anda butuhkan untuk mengelola operasional sekolah secara efisien. Mulai dari data siswa hingga penjadwalan, semuanya tersedia untuk mendukung kelancaran kegiatan sekolah. 📊
                </p>
            </div>
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="flash_notice()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/flash_notice.png">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium"> Kartu Sambutan</h2>
                                <p class="text-sm md:text-base text-gray-500">Buat baru kartu sambutan</p>
                            </div>
                        </div>
                    </div>



                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_notice()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/notice.jpg">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium"> Tambah Pengumuman</h2>
                                <p class="text-sm md:text-base text-gray-500">Tambah atau Ubah Pengumuman
                            </div>
                        </div>
                    </div>
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="registered_students()">
                        <span class="relative">
                            <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                                <img alt="team"
                                    class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                    src="../assects/images/adminavatars/registered.png">
                                <div class="flex-grow">
                                    <h2 class="text-[#ef6c00] title-font font-medium"> Lihat Siswa yang Mendaftar</h2>
                                    <p class="text-sm md:text-base text-gray-500">Siswa yang mendaftar secara online</p>
                                </div>
                            </div>
                            <?php if($row['total_notification']!=0){
                                echo '
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                '.$row['total_notification'].'</div>';

                            }
                            ?>

                        </span>
                    </div>
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeRoutine()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/routine.png">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium"> Jadwal Kelas</h2>
                                <p class="text-sm md:text-base text-gray-500">Ubah Jadwal Kelas</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeStaff()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/staffs.png">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium"> Ubah Detail Staff Sekolah</h2>
                                <p class="text-sm md:text-base text-gray-500">Tambah dan Ubah Data Staff Sekolah</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="site_content()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/site content.jpg">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium"> Ubah Isi Konten Website</h2>
                                <p class="text-sm md:text-base text-gray-500">Ubah Seluruh Isi Konten Website</p>
                            </div>
                        </div>
                    </div>



                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_gallery()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/add gallery.png">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium">Tambah Galeri</h2>
                                <p class="text-sm md:text-base text-gray-500">Tambahkan momen seperti kegiatan sekolah dan lainnya</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="feedback_page()">
                        <span class="relative">
                            <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                                <img alt="team"
                                    class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                    src="../assects/images/adminavatars/feedback.png">
                                <div class="flex-grow">
                                    <h2 class="text-[#ef6c00] title-font font-medium">Lihat Umpan Balik</h2>
                                    <p class="text-sm md:text-base text-gray-500">Umpan balik yang diberikan di situs web</p>
                                </div>
                            </div>
                            <?php if($feedback['total_notification']!=0){
                                echo '
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                '.$feedback['total_notification'].'</div>';
                            }
                            ?>
                        </span>
                    </div>

                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="adminAndScribe()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4"
                                src="../assects/images/adminavatars/adminadd.png">
                            <div class="flex-grow">
                                <h2 class="text-[#ef6c00] title-font font-medium">Tambah atau Hapus Data Admin</h2>
                                <p class="text-sm md:text-base text-gray-500">Admin dapat mengubah pengumuman sekolah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('../includes/admin_footer.php') ?>
    
</body>
<script>
function add_notice() {
    window.location.href = "add_notice.php";
}

function site_content() {
    window.location.href = "site_content.php";
}

function feedback_page() {
    window.location.href = "feedback.php";
}

function flash_notice() {
    window.location.href = "flash_notice.php";
}

function add_gallery() {
    window.location.href = "add_gallery.php";
}

function registered_students() {
    window.location.href = "registered_students.php";
}

function changeRoutine(){
    window.location.href = "changeRoutine.php";

}

function changeStaff(){
    window.location.href = "changeStaff.php";

}
function adminAndScribe(){
    window.location.href = "adminandscribe.php";

}


    console.clear();

</script>

</html>