<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Hapus jadwal
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_routine'], $_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $connectionobj->prepare("DELETE FROM schoolroutine WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo '<script>alert("Jadwal berhasil dihapus."); window.location.replace("changeRoutine.php");</script>';
    } else {
        echo '<script>alert("Gagal menghapus.");</script>';
    }
    $stmt->close();
}

// Tambah atau update jadwal
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_notice'])) {
    $classId = $_POST["class_id"];
    $className = trim($_POST["class_name"]);
    $IDImage = 'file-upload-modified' . $classId;
    $fileUploadName = $_FILES[$IDImage]['name'] ?? '';
    $fileUploadTmp = $_FILES[$IDImage]['tmp_name'] ?? '';
    $targetDirectory = '../assects/images/Routines/';
    $sqlfileurl = "";

    if (!empty($fileUploadName)) {
        $targetFilePath = $targetDirectory . basename($fileUploadName);
        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "assects/images/Routines/" . basename($fileUploadName);
        }
    }

    date_default_timezone_set('Asia/Jakarta');
    $last_modified = date("H:i d/m/Y");

    if ($classId == 0) {
        $stmt = $connectionobj->prepare("INSERT INTO schoolroutine (class, routine_url, last_modified) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $className, $sqlfileurl, $last_modified);
    } else {
        if (!empty($sqlfileurl)) {
            $stmt = $connectionobj->prepare("UPDATE schoolroutine SET class=?, routine_url=?, last_modified=? WHERE id=?");
            $stmt->bind_param("sssi", $className, $sqlfileurl, $last_modified, $classId);
        } else {
            $stmt = $connectionobj->prepare("UPDATE schoolroutine SET class=?, last_modified=? WHERE id=?");
            $stmt->bind_param("ssi", $className, $last_modified, $classId);
        }
    }

    if ($stmt->execute()) {
        echo '<script>alert("Jadwal berhasil disimpan."); window.location.replace("changeRoutine.php");</script>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Jadwal Kelas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <style>
        html, body { margin: 0; padding: 0; background-color: #ffffff; min-height: 100%; display: flex; flex-direction: column; }
        main { flex: 1; }
        footer { margin-top: auto; }
        .btn-orange { background-color: #fc941e; color: white; }
        .btn-orange:hover { background-color: #e67c00; }
        .modal-bg { background-color: rgba(0, 0, 0, 0.4); }
        input[type="file"]::file-selector-button {
            background-color: #fc941e;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            margin-right: 10px;
            cursor: pointer;
        }
        input[type="file"]::file-selector-button:hover {
            background-color: #e67c00;
        }
    </style>
</head>
<body>
<?php include('../includes/admin_header.php'); ?>

<main class="py-7 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-[#fc941e]">Ubah Jadwal Kelas</h1>
        <p class="text-gray-600 max-w-3xl mx-auto">Halaman ini memungkinkan admin sekolah untuk mengelola jadwal pelajaran setiap kelas dalam bentuk gambar. 
            Admin dapat menambahkan, memperbarui, atau menghapus file jadwal agar siswa/siswi selalu memperoleh informasi terbaru terkait pembelajaran di kelas masing-masing. 
            Dengan pengelolaan yang terpusat dan fleksibel, penyampaian jadwal menjadi lebih praktis dan efisien.</p>
    </div>

    <div class="flex justify-end mb-2 max-w-6xl mx-auto">
        <button data-modal-target="modal0" data-modal-toggle="modal0" class="btn-orange px-4 py-2 rounded text-sm">+ Tambah Jadwal</button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto max-w-6xl mx-auto">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-white uppercase bg-[#fc941e]">
                <tr>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Terakhir Diperbarui</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php
                $result = mysqli_query($connection, "SELECT * FROM schoolroutine ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr class="hover:bg-orange-50 transition">
                        <td class="px-4 py-3">' . htmlspecialchars($row['class']) . '</td>
                        <td class="px-4 py-3">' . $row['last_modified'] . '</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button data-modal-target="modal' . $row['id'] . '" data-modal-toggle="modal' . $row['id'] . '" class="btn-orange px-3 py-1 rounded text-sm">Edit</button>
                            <button onclick="confirmDelete(' . $row['id'] . ')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden modal-bg fixed top-0 left-0 z-50 w-full h-full flex justify-center items-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm">
            <h3 class="text-lg font-bold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus jadwal ini?</p>
            <form method="post">
                <input type="hidden" name="delete_id" id="delete_id">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 rounded border">Batal</button>
                    <button type="submit" name="delete_routine" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Jadwal -->
    <div id="modal0" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <h3 class="text-xl font-semibold mb-6 text-center">Tambah Jadwal Kelas</h3>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="class_id" value="0">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="class_name" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Upload Jadwal (Gambar)</label>
                
                    <div class="w-full border rounded-lg p-1 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <!-- Tombol Upload -->
                        <label class="bg-[#fc941e] text-white px-4 py-2 text-sm font-medium cursor-pointer hover:bg-[#fc941e]">
                            Pilih
                            <input type="file" name="file-upload-modified0" id="file-upload-modified0"
                                class="hidden" required
                                onchange="document.getElementById('file-name-display').value = this.files[0]?.name || 'Belum ada file dipilih'">
                        </label>

                        <!-- Input tampilkan nama file -->
                        <input type="text" id="file-name-display" readonly
                            class="flex-1 px-4 py-2 text-sm  text-gray-700 border-0 bg-white focus:outline-none"
                            placeholder="Belum ada file dipilih">
                    </div>
                </div>


                <button name="update_notice" type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit (Loop) -->
    <?php
    $result = mysqli_query($connection, "SELECT * FROM schoolroutine ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <div id="modal' . $row['id'] . '" class="hidden modal-bg fixed top-0 left-0 z-50 w-full h-full flex justify-center items-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Edit Jadwal</h3>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="class_id" value="' . $row['id'] . '">
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium">Nama Kelas</label>
                        <input type="text" name="class_name" value="' . htmlspecialchars($row['class']) . '" required class="w-full border rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium">Upload Jadwal Baru (gambar)</label>
                        <input type="file" name="file-upload-modified' . $row['id'] . '" class="w-full border rounded p-2">
                    </div>
                    <button name="update_notice" type="submit" class="btn-orange w-full py-2 rounded">Simpan Perubahan</button>
                </form>
            </div>
        </div>';
    }
    ?>
</main>

<?php include('../includes/admin_footer.php'); ?>

<script>
function confirmDelete(id) {
    document.getElementById('delete_id').value = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}
</script>

</body>
</html>
