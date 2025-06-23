<?php
include '../connection/database.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

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
        echo "<script>alert('Admin berhasil ditambahkan!'); window.location='admin_management.php';</script>";
    }
    $insert->close();
}

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
        echo "<script>alert('Admin berhasil dihapus!'); window.location='admin_management.php';</script>";
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

<body class="bg-gray-100">
<?php include('../includes/admin_header.php'); ?>

<main>
    <section class="max-w-6xl p-6 mx-auto mt-10 bg-[#fc941e] rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-white">Manajemen Admin</h1>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                class="flex items-center gap-1 bg-white hover:bg-gray-100 text-[#5d2eff] font-semibold px-4 py-2 text-sm rounded shadow">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>
                Tambah Admin
            </button>
        </div>

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
                            <a href="admin_update.php?id=<?= $row['id'] ?>" class="inline-flex items-center text-blue-600 hover:underline mr-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/></svg>
                                Edit
                            </a>
                            <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="inline-flex items-center text-red-600 hover:underline">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                Hapus
                            </a>
                        </td>
                    </tr>
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

<?php if (file_exists('../includes/admin_footer.php')) include('../includes/admin_footer.php'); ?>
</body>
</html>
