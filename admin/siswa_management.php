<?php
include '../connection/database.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Hapus siswa
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $connection->query("DELETE FROM siswa WHERE id = $deleteId");
    header("Location: siswa_management.php");
    exit();
}

// Edit siswa
if (isset($_POST['edit_siswa'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    $stmt = $connection->prepare("UPDATE siswa SET username=?, nis=?, nama=?, kelas=? WHERE id=?");
    $stmt->bind_param("ssssi", $username, $nis, $nama, $kelas, $id);
    $stmt->execute();
    header("Location: siswa_management.php");
    exit();
}

$result = $connection->query("SELECT * FROM siswa ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun Siswa</title>
    <link rel="icon" href="../assects/images/pgri-putih.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
<?php include('../includes/admin_header.php'); ?>

<main class="flex-grow pb-10">
    <section class="max-w-6xl p-6 mx-auto mt-10 mb-10 bg-[#fc941e] rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-white">Manajemen Akun Siswa</h1>
        </div>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">ID</th>
                        <th class="px-4 py-2 border border-gray-300">Username</th>
                        <th class="px-4 py-2 border border-gray-300">NISN</th>
                        <th class="px-4 py-2 border border-gray-300">Nama Lengkap</th>
                        <th class="px-4 py-2 border border-gray-300">Kelas</th>
                        <th class="px-4 py-2 border border-gray-300 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr class="border-b border-gray-300">
    <td class="px-4 py-2 border border-gray-300"><?= $row['id'] ?></td>
    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['username']) ?></td>
    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['nis']) ?></td>
    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['nama']) ?></td>
    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($row['kelas']) ?></td>
    <td class="px-4 py-2 border border-gray-300 text-center">
        <button onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.remove('hidden')" class="text-blue-600 hover:underline mr-2">✏️ Edit</button>
        <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus siswa ini?')" class="text-red-600 hover:underline">🗑️ Hapus</a>
    </td>
</tr>

<!-- Modal Edit -->
<div id="editModal<?= $row['id'] ?>" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-md w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit Akun Siswa</h2>
        <form method="POST">
            <input type="hidden" name="edit_siswa" value="1">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label class="block mb-1 font-medium">Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" class="w-full mb-3 border rounded px-3 py-2" required>
            <label class="block mb-1 font-medium">NISN</label>
            <input type="text" name="nis" value="<?= htmlspecialchars($row['nis']) ?>" class="w-full mb-3 border rounded px-3 py-2">
            <label class="block mb-1 font-medium">Nama Lengkap</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" class="w-full mb-3 border rounded px-3 py-2">
            <label class="block mb-1 font-medium">Kelas</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($row['kelas']) ?>" class="w-full mb-4 border rounded px-3 py-2">

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

<?php if (file_exists('../includes/admin_footer.php')) include('../includes/admin_footer.php'); ?>
</body>
</html>
