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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../assects/images/defaults/logoweb.png" type="image/x-icon">
</head>

<body class="flex flex-col min-h-screen">
    <?php include('../includes/admin_header.php'); ?>

    <main class="flex flex-1">
        <aside class="w-75 bg-yellow-100 p-5 space-y-4">
            
            <a href="flash_notice.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">🧾Kartu Sambutan</a>
            <a href="add_notice.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">📢Tambah Pengumuman</a>
            <a href="registered_students.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium"> 🧑‍🎓Lihat Siswa yang Mendaftar</a>
              <a href="changeRoutine.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">📆Jadwal Kelas</a>
                <a href="changeStaff.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Ubah Detail Staff</a>
                <a href="site_content.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Ubah Konten Website</a>
                  <a href="add_gallery.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Galery</a>
                    <a href="feedback.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Lihat Umpan Balik</a>
                      <a href="admin_management.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Tambah atau Hapus Admin</a>
                        <a href="siswa_management.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Kelola kaun Siswa</a>
                          <a href="guru_management.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Kelola Akun Guru</a>
                            <a href="kelola_kurikulum.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Kelola Kurikulum</a>
                              <a href="media_upload.php" class="block py-2 px-3 rounded-lg hover:bg-yellow-200 font-medium">Home Page Media</a>


        </aside>

        <section id="konten" class="flex-1 p-6 bg-orange-50">
            <div id="dashboard" class="space-y-4">
                <h2 class="text-2xl font-bold">Halo, <?= $_SESSION['username']; ?> 👋</h2>
                <p class="text-gray-700">Selamat datang di Dashboard Admin SMP PGRI 371 Pondok Aren</p>
               

            <div id="absensi" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Absensi Guru</h2>
                <p class="text-gray-700">Fitur untuk mengelola absensi guru akan tampil di sini.</p>
            </div>

            <div id="pengaturan" class="hidden">
                <h2 class="text-2xl font-bold mb-4">Pengaturan</h2>
                <p class="text-gray-700">Fitur pengaturan admin akan ditampilkan di sini.</p>
            </div>
        </section>
    </main>

    <?php include('../includes/admin_footer.php'); ?>

    <script>
        function showSection(id) {
            const sections = document.querySelectorAll('#konten > div');
            sections.forEach(section => section.classList.add('hidden'));
            document.getElementById(id).classList.remove('hidden');
        }
    </script>
</body>

</html>
