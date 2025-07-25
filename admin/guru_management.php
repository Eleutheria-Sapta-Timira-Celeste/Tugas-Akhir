<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Tambah Guru
if (isset($_POST['add_guru'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $gelar = $_POST['gelar'];
    $mapel = $_POST['mapel'];
    $posisi = $_POST['posisi_staff'];

    $fotoName = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $targetDir = '../guru/uploads/';
    $fotoPath = null;

    if (!empty($fotoName)) {
        if (move_uploaded_file($fotoTmp, $targetDir . $fotoName)) {
            $fotoPath = $fotoName;
        }
    }

    $stmt = $connectionobj->prepare("INSERT INTO guru (username, email, password, nama, nip, gelar, mapel, foto, posisi_staff) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $email, $password, $nama, $nip, $gelar, $mapel, $fotoPath, $posisi);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Guru berhasil ditambahkan!'); window.location='index.php?page=guru_management';</script>";
}

// Edit Guru
if (isset($_POST['edit_guru'])) {
    $id = $_POST['guru_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $nama = $_POST['edit_nama'];
    $nip = $_POST['edit_nip'];
    $gelar = $_POST['edit_gelar'];
    $mapel = $_POST['edit_mapel'];
    $posisi = $_POST['edit_posisi_staff'];
    $fotoLama = $_POST['current_foto'];

    $fotoName = $_FILES['edit_foto']['name'];
    $fotoTmp = $_FILES['edit_foto']['tmp_name'];
    $fotoPath = $fotoLama;

    if (!empty($fotoName)) {
        $targetDir = '../guru/uploads/';
        if (move_uploaded_file($fotoTmp, $targetDir . $fotoName)) {
            $fotoPath = $fotoName;
        }
    }

    $stmt = $connectionobj->prepare("UPDATE guru SET username=?, email=?, nama=?, nip=?, gelar=?, mapel=?, foto=?, posisi_staff=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $username, $email, $nama, $nip, $gelar, $mapel, $fotoPath, $posisi, $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data guru berhasil diupdate!'); window.location='index.php?page=guru_management';</script>";
}

// Hapus Guru
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $connectionobj->prepare("DELETE FROM guru WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Guru berhasil dihapus!'); window.location='index.php?page=guru_management';</script>";
}

$result = $connectionobj->query("SELECT * FROM guru ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Guru</title>
    <link rel="icon" href="../assects/images/pgri-putih.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">


<main class="flex-grow pb-24">
    <section class="text-gray-600 body-font">
        <div class="container px-5 pt-5 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #ef6c00;">Kelola Data Guru</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    👩‍🏫 Halaman pengelolaan data Guru SMP PGRI 371 Pondok Aren. Tambahkan, ubah, atau hapus informasi guru untuk keperluan akademik dan administratif sekolah. 📚
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl px-6 py-6 mx-auto bg-[#fc941e] rounded-md shadow-md mt-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-white">Manajemen Guru</h1>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-white px-4 py-2 rounded text-sm font-semibold text-[#5d2eff] hover:bg-gray-100 shadow">➕ Tambah Guru</button>
        </div>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm text-left text-gray-500 border">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 border">ID</th>
                        <th class="px-3 py-2 border">USERNAME</th>
                        <th class="px-3 py-2 border">NAMA</th>
                        <th class="px-3 py-2 border">NIP</th>
                        <th class="px-3 py-2 border">EMAIL</th>
                        <th class="px-3 py-2 border">GELAR</th>
                        <th class="px-3 py-2 border">MAPEL</th>
                        <th class="px-3 py-2 border">POSISI</th>
                        <th class="px-3 py-2 border text-center">FOTO</th>
                        <th class="px-3 py-2 border text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-b">
                        <td class="px-3 py-2 border"><?= $row['id'] ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($row['username']) ?></td>
                        <td class="px-3 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                        <td class="px-3 py-2 border"><?= $row['nip'] ?></td>
                        <td class="px-3 py-2 border"><?= $row['email'] ?></td>
                        <td class="px-3 py-2 border"><?= $row['gelar'] ?></td>
                        <td class="px-3 py-2 border"><?= $row['mapel'] ?></td>
                        <td class="px-3 py-2 border"><?= $row['posisi_staff'] ?></td>
                        <td class="px-3 py-2 border text-center">
                            <?php if ($row['foto']): ?>
                                <img src="../guru/uploads/<?= $row['foto'] ?>" class="h-10 rounded mx-auto">
                            <?php else: ?>
                                <span class="text-gray-400 italic">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2 border text-center">
                            <div class="flex justify-center space-x-4">
                                <button onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.remove('hidden')" class="text-sm text-gray-700 hover:underline">✏️ Edit</button>
                               <a href="guru_management.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus guru ini?')" class="text-sm text-gray-700 hover:underline">🗑️ Hapus</a>

                            </div>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div id="editModal<?= $row['id'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 overflow-y-auto">
                        <div class="bg-white p-6 rounded-lg w-full max-w-md my-10 max-h-screen overflow-y-auto">
                            <h2 class="text-xl font-bold mb-4">Edit Guru</h2>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="edit_guru" value="1">
                                <input type="hidden" name="guru_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="current_foto" value="<?= $row['foto'] ?>">

                                <label class="block mb-1 font-medium">Username</label>
                                <input type="text" name="edit_username" value="<?= $row['username'] ?>" class="w-full border px-3 py-2 mb-3 rounded" required>

                                <label class="block mb-1 font-medium">Email</label>
                                <input type="email" name="edit_email" value="<?= $row['email'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">Nama Lengkap</label>
                                <input type="text" name="edit_nama" value="<?= $row['nama'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">NIP</label>
                                <input type="text" name="edit_nip" value="<?= $row['nip'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">Gelar</label>
                                <input type="text" name="edit_gelar" value="<?= $row['gelar'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">Mapel</label>
                                <input type="text" name="edit_mapel" value="<?= $row['mapel'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">Posisi Staff</label>
                                <input type="text" name="edit_posisi_staff" value="<?= $row['posisi_staff'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                <label class="block mb-1 font-medium">Foto (kosongkan jika tidak diubah)</label>
                                <input type="file" name="edit_foto" class="w-full border px-3 py-2 mb-4 rounded">

                                <div class="flex justify-between mt-4">
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

    <!-- Modal Tambah Guru -->
    <div id="addModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 overflow-y-auto">
        <div class="bg-white p-6 rounded-lg w-full max-w-md my-10 max-h-screen overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Tambah Guru</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add_guru" value="1">

                <label class="block mb-1 font-medium">Username</label>
                <input type="text" name="username" class="w-full border px-3 py-2 mb-3 rounded" required>

                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 mb-3 rounded" required>

                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">NIP</label>
                <input type="text" name="nip" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">Gelar</label>
                <input type="text" name="gelar" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">Mapel</label>
                <input type="text" name="mapel" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">Posisi Staff</label>
                <input type="text" name="posisi_staff" class="w-full border px-3 py-2 mb-3 rounded">

                <label class="block mb-1 font-medium">Foto</label>
                <input type="file" name="foto" class="w-full border px-3 py-2 mb-4 rounded">

                <div class="flex justify-between mt-4">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-[#fc941e] text-white px-4 py-2 rounded hover:bg-[#e77b00]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>


</body>
</html>
