<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Tambah Admin
if (isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_admin = $_POST['nama_admin'];
    $email = $_POST['email'];
    $fileUploadName = $_FILES['file_upload']['name'];
    $fileUploadTmp = $_FILES['file_upload']['tmp_name'];
    $targetDirectory = '../assects/images/admin_and_scribe/';
    $targetFilePath = $targetDirectory . basename($fileUploadName);
    $logoPath = null;

    if (!empty($fileUploadName)) {
        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $logoPath = "assects/images/admin_and_scribe/" . basename($fileUploadName);
        }
    }

    $insert = $connectionobj->prepare("INSERT INTO admin (username, password, nama_admin, email, logo) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssss", $username, $password, $nama_admin, $email, $logoPath);
    if ($insert->execute()) {
        echo "<script>alert('Admin berhasil ditambahkan!'); window.location='index.php?page=admin_management';</script>";
    }
    $insert->close();
}

// Edit Admin
if (isset($_POST['edit_admin'])) {
    $id = $_POST['admin_id'];
    $username = $_POST['edit_username'];
    $nama_admin = $_POST['edit_nama_admin'];
    $email = $_POST['edit_email'];
    $fileUploadName = $_FILES['edit_file_upload']['name'];
    $fileUploadTmp = $_FILES['edit_file_upload']['tmp_name'];
    $targetDirectory = '../assects/images/admin_and_scribe/';
    $targetFilePath = $targetDirectory . basename($fileUploadName);
    $logoPath = $_POST['current_logo'];

    if (!empty($fileUploadName)) {
        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $logoPath = "assects/images/admin_and_scribe/" . basename($fileUploadName);
        }
    }

    $update = $connectionobj->prepare("UPDATE admin SET username=?, nama_admin=?, email=?, logo=? WHERE id=?");
    $update->bind_param("ssssi", $username, $nama_admin, $email, $logoPath, $id);
    if ($update->execute()) {
        echo "<script>alert('Admin berhasil diupdate!'); window.location='index.php?page=admin_management';</script>";
    }
    $update->close();
}

// Delete Admin
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $del = $connectionobj->prepare("DELETE FROM admin WHERE id = ?");
    $del->bind_param("i", $deleteId);
    if ($del->execute()) {
        $check = $connectionobj->query("SELECT COUNT(*) as total FROM admin");
        $row = $check->fetch_assoc();
        if ($row['total'] == 0) {
            $connectionobj->query("ALTER TABLE admin AUTO_INCREMENT = 1");
        }
        echo "<script>alert('Admin berhasil dihapus!'); window.location='index.php?page=admin_management';</script>";
    }
    $del->close();
}

$result = $connectionobj->query("SELECT * FROM admin ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Admin</title>
    <link rel="icon" href="../assects/images/pgri-putih.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">


<!-- Bagian main setelah include header -->
<main class="flex-grow pb-24">

    <!-- Header Deskripsi Halaman -->
    <section class="text-gray-600 body-font">
        <div class="container px-5 pt-5 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #ef6c00;">Kelola Data Admin</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    🔐 Selamat datang di halaman pengelolaan akun Admin SMP PGRI 371 Pondok Aren! 👩‍💻👨‍💻<br>
                    Di sini Anda dapat menambah, mengedit, atau menghapus data admin dengan mudah dan cepat.
                    Admin memiliki akses penuh untuk mengelola data penting sekolah, sehingga memastikan keamanan dan integritas sistem sangatlah krusial.
                    Pastikan hanya pengguna terpercaya yang diberikan hak akses ini. 💡
                </p>
            </div>
        </div>
    </section>

    <!-- Tabel dan Tombol Tambah -->
    <section class="max-w-6xl px-6 py-6 mx-auto bg-[#fc941e] rounded-md shadow-md mt-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-white">Manajemen Admin</h1>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                class="flex items-center gap-1 bg-white hover:bg-gray-100 text-[#5d2eff] font-semibold px-4 py-2 text-sm rounded shadow">
                ➕ Tambah Admin
            </button>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">ID</th>
                        <th class="px-4 py-2 border border-gray-300">USERNAME</th>
                        <th class="px-4 py-2 border border-gray-300">NAMA ADMIN</th>
                        <th class="px-4 py-2 border border-gray-300">EMAIL</th>
                        <th class="px-4 py-2 border border-gray-300 text-center">LOGO</th>
                        <th class="px-4 py-2 border border-gray-300 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 border border-gray-300"><?= $row['id'] ?></td>
                        <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['username']) ?></td>
                        <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['nama_admin']) ?></td>
                        <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            <?php if (!empty($row['logo'])): ?>
                                <img src="../<?= $row['logo'] ?>" class="h-10 mx-auto rounded">
                            <?php else: ?>
                                <span class="text-gray-400 italic">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 border border-gray-300 text-center">
                            <button onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.remove('hidden')" class="inline-flex items-center text-blue-600 hover:underline mr-2">✏️ Edit</button>
                            <a href="admin_management.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="inline-flex items-center text-red-600 hover:underline">🗑️ Hapus</a>

                        </td>
                    </tr>

                    <!-- Modal Edit Admin -->
                    <div id="editModal<?= $row['id'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white p-6 rounded-lg w-full max-w-md">
                            <h2 class="text-xl font-bold mb-4">Edit Admin</h2>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="edit_admin" value="1">
                                <input type="hidden" name="admin_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="current_logo" value="<?= $row['logo'] ?>">

                                <label class="block font-semibold mb-1">Username</label>
                                <input type="text" name="edit_username" value="<?= htmlspecialchars($row['username']) ?>" required class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block font-semibold mb-1">Nama Admin</label>
                                <input type="text" name="edit_nama_admin" value="<?= htmlspecialchars($row['nama_admin']) ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block font-semibold mb-1">Email</label>
                                <input type="email" name="edit_email" value="<?= htmlspecialchars($row['email']) ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block font-semibold mb-1">Foto / Logo (kosongkan jika tidak diubah)</label>
                                <input type="file" name="edit_file_upload" class="w-full border px-3 py-2 mb-4 rounded">

                                <div class="flex justify-between">
                                    <button type="button" onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                                    <button type="submit" class="bg-[#fc941e] text-white px-4 py-2 rounded hover:bg-[#e77b00]">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>


<!-- Modal Tambah Admin -->
<div id="addModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Admin Baru</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_admin" value="1">
            <label class="block font-semibold mb-1">Username</label>
            <input type="text" name="username" required class="w-full border px-3 py-2 mb-3 rounded">
            <label class="block font-semibold mb-1">Password</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 mb-3 rounded">
            <label class="block font-semibold mb-1">Nama Admin</label>
            <input type="text" name="nama_admin" class="w-full border px-3 py-2 mb-3 rounded">
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 mb-3 rounded">
            <label class="block font-semibold mb-1">Foto / Logo</label>
            <input type="file" name="file_upload" class="w-full border px-3 py-2 mb-4 rounded">
            <div class="flex justify-between">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-[#fc941e] text-white px-4 py-2 rounded hover:bg-[#e77b00]">Simpan</button>
            </div>
        </form>
    </div>
</div>


</body>
</html>