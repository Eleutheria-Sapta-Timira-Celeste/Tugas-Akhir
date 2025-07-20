<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

try {
    $query1 = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";
    $result1 = mysqli_query($connection, $query1);
    $result2 = mysqli_query($connection, $query2);

    if ($result1 && $result2) {
        $row = mysqli_fetch_assoc($result1);
        $feedback = mysqli_fetch_assoc($result2);
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
    <title>Dashboard Admin - SMP PGRI 371 Pondok Aren</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../assects/images/defaults/logo_warna.png" />
</head>
<body class="flex bg-gray-100 min-h-screen">
    

    <!-- Sidebar -->
    <aside class="w-64 bg-[#d49f5f] text-white flex-shrink-0 min-h-screen shadow-lg">
        <div class="p-6 text-center font-bold text-xs tracking-wide border-b border-orange-300">
            <img src="../assects/images/defaults/logo_warna.png" alt="Logo" class="mx-auto mb-2 w-16 h-16 ">
            SMP PGRI 371 Pondok Aren
        </div>
        <nav class="mt-6 flex flex-col space-y-2 px-4">
            <button onclick="flash_notice()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📝 Kartu Sambutan</button>
            <button onclick="add_notice()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📢 Tambah Pengumuman</button>
            <button onclick="registered_students()" class="hover:bg-orange-600 p-3 rounded flex items-center justify-between">
                <span>👨‍🎓 Pendaftar</span>
                <?php if ($row['total_notification'] != 0): ?>
                    <span class="bg-red-600 px-2 py-0.5 text-xs rounded-full"><?= $row['total_notification']; ?></span>
                <?php endif; ?>
            </button>
            <button onclick="changeRoutine()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📅 Jadwal Kelas</button>
            <button onclick="changeStaff()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">👥 Ubah Staff</button>
            <button onclick="site_content()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">🌐 Konten Website</button>
            <button onclick="add_gallery()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">🖼️ Tambah Galeri</button>
            <button onclick="feedback_page()" class="hover:bg-orange-600 p-3 rounded flex justify-between">
                <span>💬 Feedback</span>
                <?php if ($feedback['total_notification'] != 0): ?>
                    <span class="bg-red-600 px-2 py-0.5 text-xs rounded-full"><?= $feedback['total_notification']; ?></span>
                <?php endif; ?>
            </button>
            <button onclick="admin()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">🔐 Kelola Admin</button>
            <button onclick="siswa_management()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📋 Akun Siswa</button>
            <button onclick="guru_management()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📘 Akun Guru</button>
            <button onclick="kelola_kurikulum()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">📚 Kurikulum</button>
            <button onclick="homepage_media()" class="hover:bg-orange-600 p-3 rounded flex items-center gap-2">🏠 Media Beranda</button>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#ef6c00]">Dashboard Admin</h1>
                <p class="text-sm text-gray-500">SMP PGRI 371 Pondok Aren</p>
            </div>
            <div class="text-gray-600">
                👤 <span class="font-semibold"><?= $_SESSION['username']; ?></span>
            </div>
        </header>

        <main class="p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang, <span class="text-[#ef6c00]"><?= $_SESSION['username']; ?></span> 👋</h2>
            <p class="text-gray-600 mb-8">Silakan pilih menu di sebelah kiri untuk mulai mengelola sistem sekolah.</p>

            <!-- Konten Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-lg text-[#ef6c00] mb-2">Kartu Sambutan</h3>
                    <p class="text-gray-600 text-sm">Buat atau ubah sambutan dari kepala sekolah untuk halaman utama.</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-lg text-[#ef6c00] mb-2">Pengumuman</h3>
                    <p class="text-gray-600 text-sm">Kelola informasi penting yang akan tampil di halaman siswa/guru.</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
                    <h3 class="font-semibold text-lg text-[#ef6c00] mb-2">Jadwal Kelas</h3>
                    <p class="text-gray-600 text-sm">Atur jadwal pelajaran untuk masing-masing kelas.</p>
                </div>
            </div>
        </main>
    </div>

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
