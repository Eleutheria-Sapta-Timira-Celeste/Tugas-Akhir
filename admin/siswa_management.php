<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Tambah Siswa
if (isset($_POST['add_siswa'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];

    $fotoName = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $targetDir = '../siswa/uploads/';
    $fotoPath = null;

    if (!empty($fotoName)) {
        if (move_uploaded_file($fotoTmp, $targetDir . $fotoName)) {
            $fotoPath = $fotoName;
        }
    }

    $stmt = $connectionobj->prepare("INSERT INTO siswa (username, email, nama, nis, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu, foto, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $username, $email, $nama, $nis, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $fotoPath, $password);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Siswa berhasil ditambahkan!'); window.location='index.php?page=siswa_management';</script>";
}

// Edit Siswa
if (isset($_POST['edit_siswa'])) {
    $id = $_POST['siswa_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $nama = $_POST['edit_nama'];
    $nis = $_POST['edit_nis'];
    $kelas = $_POST['edit_kelas'];
    $tempat_lahir = $_POST['edit_tempat_lahir'];
    $tanggal_lahir = $_POST['edit_tanggal_lahir'];
    $nama_ayah = $_POST['edit_nama_ayah'];
    $nama_ibu = $_POST['edit_nama_ibu'];
    $fotoLama = $_POST['current_foto'];

    $fotoName = $_FILES['edit_foto']['name'];
    $fotoTmp = $_FILES['edit_foto']['tmp_name'];
    $fotoPath = $fotoLama;

    if (!empty($fotoName)) {
        $targetDir = '../siswa/uploads/';
        if (move_uploaded_file($fotoTmp, $targetDir . $fotoName)) {
            $fotoPath = $fotoName;
        }
    }

    $stmt = $connectionobj->prepare("UPDATE siswa SET username=?, email=?, nama=?, nis=?, kelas=?, tempat_lahir=?, tanggal_lahir=?, nama_ayah=?, nama_ibu=?, foto=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $username, $email, $nama, $nis, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $fotoPath, $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data siswa berhasil diupdate!'); window.location='index.php?page=siswa_management';</script>";
}

// Delete siswa
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $connectionobj->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Siswa berhasil dihapus!'); window.location='index.php?page=siswa_management';</script>";
    } else {
        echo "Gagal menghapus siswa: " . $stmt->error;
    }

    $stmt->close();
}


// Filter Kelas dan Search Nama
$whereClause = '';
if (isset($_GET['filter_kelas']) && $_GET['filter_kelas'] !== '') {
    $kelasFilter = $connectionobj->real_escape_string($_GET['filter_kelas']);
    $whereClause .= ($whereClause ? " AND " : "WHERE ") . "kelas = '$kelasFilter'";
}
if (isset($_GET['search_nama']) && $_GET['search_nama'] !== '') {
    $namaSearch = $connectionobj->real_escape_string($_GET['search_nama']);
    $whereClause .= ($whereClause ? " AND " : "WHERE ") . "nama LIKE '%$namaSearch%'";
}
$result = $connectionobj->query("SELECT * FROM siswa $whereClause ORDER BY id ASC");
?>

<!-- Bagian HTML -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Siswa</title>
    <link rel="icon" href="../assects/images/pgri-putih.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

<main class="flex-grow pb-24">
            <section class="text-gray-600 body-font">
            <div class="container px-5 py-5 mx-auto">
                <div class="flex flex-col text-center w-full mb-2">
                    <h1 class="text-3xl font-bold text-[#a9745a]">Kelola Data Akun Siswa </h1>
                        <p class="text-sm text-gray-600 mt-2 max-w-2xl mx-auto">
                        Selamat datang di halaman akun Siswa SMP PGRI 371 Pondok Aren!
                        Kelola data akun siswa dengan mudah tambahkan, ubah, atau hapus sesuai kebutuhan. 
                        Data ini digunakan untuk akses dan identitas siswa dalam sistem.


                    </p>
                </div>
            </div>
        </section>

           

        <!-- TABEL SISWA -->
        <!-- Section Konten Tabel -->

        
    <section class="max-w-6xl px-6 py-6 mx-auto bg-[#a9745a] rounded-md shadow-md mt-6">
    <div class="flex justify-between items-center mt-4 mb-4">
    <!-- KIRI: Judul -->
    <h1 class="text-xl font-bold text-white">MANAJEMEN SISWA</h1>

    <!-- KANAN: Form Filter -->
    <form method="GET" action="index.php">
    <div class="flex gap-2 items-center">
        <!-- Hidden input untuk tetap menyertakan "page=siswa_management" -->
        <input type="hidden" name="page" value="siswa_management">

        <select name="filter_kelas" class="px-3 py-2 rounded text-sm border border-gray-300">
            <option value="">-- Semua Kelas --</option>
            <?php
            $kelasList = ['VII', 'VIII', 'IX'];
            foreach ($kelasList as $kelas) {
                $selected = (isset($_GET['filter_kelas']) && $_GET['filter_kelas'] == $kelas) ? 'selected' : '';
                echo '<option value="' . $kelas . '" ' . $selected . '>' . $kelas . '</option>';
            }
            ?>
        </select>
            <input type="text" name="search_nama" value="<?= isset($_GET['search_nama']) ? htmlspecialchars($_GET['search_nama']) : '' ?>" placeholder="Cari nama..." class="px-3 py-2 rounded text-sm border border-gray-300">

            <button type="submit" class="bg-white text-[#a9745a] text-sm font-semibold px-4 py-2 rounded hover:bg-gray-100 shadow">🔍 Cari</button>

            <?php if (!empty($_GET['filter_kelas']) || !empty($_GET['search_nama'])): ?>
                <a href="index.php?page=siswa_management" class="bg-red-500 text-white px-3 py-2 rounded text-sm hover:bg-red-600">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>


                
        <div class="flex justify-end items-center mt-4 mb-4">
   
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-white px-4 py-2 rounded text-sm font-semibold text-[#a9745a] hover:bg-gray-100 shadow"> Tambah Siswa</button>
</div>

            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="w-full text-sm text-left text-gray-500 border">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border">ID</th>
                            <th class="px-3 py-2 border">USERNAME</th>
                            <th class="px-3 py-2 border">NAMA</th>
                            <th class="px-3 py-2 border">NIS</th>
                            <th class="px-3 py-2 border">EMAIL</th>
                            <th class="px-3 py-2 border">KELAS</th>
                            <th class="px-3 py-2 border">TTL</th>
                            <th class="px-3 py-2 border">NAMA AYAH</th>
                            <th class="px-3 py-2 border">NAMA IBU</th>
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
                            <td class="px-3 py-2 border"><?= $row['nis'] ?></td>
                            <td class="px-3 py-2 border"><?= $row['email'] ?></td>
                            <td class="px-3 py-2 border"><?= $row['kelas'] ?></td>
                            <td class="px-3 py-2 border"><?= $row['tempat_lahir'] . ', ' . $row['tanggal_lahir'] ?></td>
                            <td class="px-3 py-2 border"><?= $row['nama_ayah'] ?></td>
                            <td class="px-3 py-2 border"><?= $row['nama_ibu'] ?></td>
                            <td class="px-3 py-2 border text-center">
                                <?php if ($row['foto']): ?>
                                    <img src="../siswa/uploads/<?= $row['foto'] ?>" class="h-10 rounded mx-auto">
                                <?php else: ?>
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-3 py-2 border text-center">
                                <button onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.remove('hidden')" class="text-blue-600 hover:underline mr-2">✏️ Edit</button>
                                <a href="index.php?page=siswa_management&delete_id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus siswa ini?')" class="text-red-600 hover:underline">🗑️</a>

                            </td>
                        </tr>

                        <!-- Modal Edit (scrollable) -->
                        <div id="editModal<?= $row['id'] ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 overflow-y-auto">
                            <div class="bg-white p-6 rounded-lg w-full max-w-md my-10 max-h-screen overflow-y-auto">
                                <h2 class="text-xl font-bold mb-4">Edit Siswa</h2>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="edit_siswa" value="1">
                                    <input type="hidden" name="siswa_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="current_foto" value="<?= $row['foto'] ?>">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="edit_siswa" value="1">
                                    <input type="hidden" name="siswa_id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="current_foto" value="<?= $row['foto'] ?>">

                                    <label class="block mb-1 font-medium">Username</label>
                                    <input type="text" name="edit_username" value="<?= $row['username'] ?>" class="w-full border px-3 py-2 mb-3 rounded" required>

                                    <label class="block mb-1 font-medium">Email</label>
                                    <input type="email" name="edit_email" value="<?= $row['email'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Nama Lengkap</label>
                                    <input type="text" name="edit_nama" value="<?= $row['nama'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">NIS</label>
                                    <input type="text" name="edit_nis" value="<?= $row['nis'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Kelas</label>
                                    <input type="text" name="edit_kelas" value="<?= $row['kelas'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Tempat Lahir</label>
                                    <input type="text" name="edit_tempat_lahir" value="<?= $row['tempat_lahir'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Tanggal Lahir</label>
                                    <input type="date" name="edit_tanggal_lahir" value="<?= $row['tanggal_lahir'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Nama Ayah</label>
                                    <input type="text" name="edit_nama_ayah" value="<?= $row['nama_ayah'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Nama Ibu</label>
                                    <input type="text" name="edit_nama_ibu" value="<?= $row['nama_ibu'] ?>" class="w-full border px-3 py-2 mb-3 rounded">

                                    <label class="block mb-1 font-medium">Foto (kosongkan jika tidak diubah)</label>
                                    <input type="file" name="edit_foto" class="w-full border px-3 py-2 mb-4 rounded">

                                    <div class="flex justify-between mt-4">
                                        <button type="button" onclick="document.getElementById('editModal<?= $row['id'] ?>').classList.add('hidden')" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                                        <button type="submit" class="bg-[#5c3d15] text-white px-4 py-2 rounded hover:bg-[#4b320f]">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Modal Tambah Siswa -->

                    

                    <div id="addModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 overflow-y-auto">
                    <div class="bg-white p-6 rounded-lg w-full max-w-md my-10 max-h-screen overflow-y-auto">
                        <h2 class="text-xl font-bold mb-4">Tambah Siswa</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="add_siswa" value="1">

                        <label class="block mb-1 font-medium">Username</label>
                        <input type="text" name="username" class="w-full border px-3 py-2 mb-3 rounded" required>

                        <label class="block mb-1 font-medium">Password</label>
                        <input type="password" name="password" class="w-full border px-3 py-2 mb-3 rounded" required>

                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" name="email" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">NIS</label>
                        <input type="text" name="nis" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Kelas</label>
                        <input type="text" name="kelas" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="w-full border px-3 py-2 mb-3 rounded">

                        <label class="block mb-1 font-medium">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="w-full border px-3 py-2 mb-3 rounded">

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
