<?php
include '../connection/database.php';
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

try {
    // Query notifikasi
    $query1 = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";

    $result1 = mysqli_query($connection, $query1);
    $result2 = mysqli_query($connection, $query2);

    if ($result1 && $result2) {
        $row = mysqli_fetch_assoc($result1);
        $feedback = mysqli_fetch_assoc($result2);
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
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
</head>

<body class="bg-gray-100">

    <?php include('../includes/admin_header.php'); ?>

    <main class="p-6">
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-10">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]">
                        Selamat Datang di Panel Admin
                    </h1>
                    <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                        Selamat datang, <b><?= $_SESSION['username']; ?></b> di Panel Admin SMP PGRI 371 Pondok Aren 🏫.
                        Di sini Anda dapat mengelola seluruh data dan konten sekolah. 📊
                    </p>
                </div>

                <div class="flex flex-wrap -m-2">

                    <!-- Kartu Sambutan -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="flash_notice()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/flash_notice.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Kartu Sambutan</h2>
                                <p class="text-sm text-gray-500">Buat baru kartu sambutan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tambah Pengumuman -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_notice()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/notice.jpg" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Tambah Pengumuman</h2>
                                <p class="text-sm text-gray-500">Tambah atau ubah pengumuman</p>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Mendaftar -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="registered_students()">
                        <div class="relative h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/registered.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Lihat Siswa yang Mendaftar</h2>
                                <p class="text-sm text-gray-500">Siswa yang mendaftar online</p>
                            </div>
                            <?php if ($row['total_notification'] != 0): ?>
                                <div class="absolute w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full flex items-center justify-center -top-2 -right-2">
                                    <?= $row['total_notification']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Jadwal Kelas -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeRoutine()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/routine.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Jadwal Kelas</h2>
                                <p class="text-sm text-gray-500">Ubah jadwal kelas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ubah Staff -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="changeStaff()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/staffs.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Ubah Detail Staff</h2>
                                <p class="text-sm text-gray-500">Tambah/ubah data staff sekolah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ubah Konten Website -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="site_content()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/site content.jpg" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Ubah Konten Website</h2>
                                <p class="text-sm text-gray-500">Ubah seluruh isi konten website</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tambah Galeri -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="add_gallery()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/add gallery.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Tambah Galeri</h2>
                                <p class="text-sm text-gray-500">Tambah galeri kegiatan sekolah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="feedback_page()">
                        <div class="relative h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/feedback.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Lihat Umpan Balik</h2>
                                <p class="text-sm text-gray-500">Feedback dari pengunjung</p>
                            </div>
                            <?php if ($feedback['total_notification'] != 0): ?>
                                <div class="absolute w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full flex items-center justify-center -top-2 -right-2">
                                    <?= $feedback['total_notification']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Admin dan Scribe -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="admin()">
                        <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <img src="../assects/images/adminavatars/adminadd.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                            <div>
                                <h2 class="text-[#ef6c00] font-medium">Tambah / Hapus Admin</h2>
                                <p class="text-sm text-gray-500">Kelola data admin sekolah</p>
                            </div>
                        </div>
                    </div>
                    <!-- Kelola Akun Siswa -->
                <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="siswa_management()">
                    <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                        <img src="../assects/images/adminavatars/kelola_akun_icon.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h2 class="text-[#ef6c00] font-medium">Kelola Akun Siswa</h2>
                            <p class="text-sm text-gray-500">Lihat dan kelola data akun siswa</p>
                        </div>
                    </div>
                </div>

                <!-- Kelola Akun Guru -->
                <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="guru_management()">
                    <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                        <img src="../assects/images/adminavatars/kelola_akun_icon.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h2 class="text-[#ef6c00] font-medium">Kelola Akun Guru</h2>
                            <p class="text-sm text-gray-500">Lihat dan kelola data akun guru</p>
                        </div>
                    </div>
                </div>
                
<!-- Kelola Kurikulum -->
                <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="kelola_kurikulum()">
                    <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                        <img src="../assects/images/adminavatars/kelola_akun_icon.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h2 class="text-[#ef6c00] font-medium">Kelola Kurikulum</h2>
                            <p class="text-sm text-gray-500">Kelola Kurikulum</p>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="homepage_media()">
                    <div class="h-full flex items-center border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                        <img src="../assects/images/adminavatars/kelola_akun_icon.png" alt="icon" class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h2 class="text-[#ef6c00] font-medium">Home Page Media</h2>
                            <p class="text-sm text-gray-500">Kelola Media Halaman Beranda</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('../includes/admin_footer.php'); ?>

    <script>
        function add_notice() { window.location.href = "add_notice.php"; }
        function site_content() { window.location.href = "site_content.php"; }
        function feedback_page() { window.location.href = "feedback.php"; }
        function flash_notice() { window.location.href = "flash_notice.php"; }
        function add_gallery() { window.location.href = "add_gallery.php"; }
        function registered_students() { window.location.href = "registered_students.php"; }
        function changeRoutine() { window.location.href = "changeRoutine.php"; }
        function changeStaff() { window.location.href = "changeStaff.php"; }
        function admin() { window.location.href = "admin_management.php"; }
        function siswa_management() { window.location.href = "siswa_management.php"; }
        function guru_management() { window.location.href = "guru_management.php"; }
        function kelola_kurikulum() { window.location.href = "kelola_kurikulum.php"; }
        function homepage_media() { window.location.href = "media_upload.php"; }
    </script>

</body>
</html>
