<?php

include '../connection/database.php';

// Pastikan siswa sudah login
if (!isset($_SESSION['nis'])) {
    header("Location: index.php");
    exit;
}

$nis = $_SESSION['nis'];
$msg = "";

// Ambil data siswa
$query = $connection->prepare("SELECT * FROM siswa WHERE nis = ?");
$query->bind_param("s", $nis);
$query->execute();
$data = $query->get_result()->fetch_assoc();

// Update profile
if (isset($_POST['update_profile'])) {
    $nama           = $_POST['nama'];
    $kelas          = $_POST['kelas'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $nama_ayah      = $_POST['nama_ayah'];
    $nama_ibu       = $_POST['nama_ibu'];
    $alamat         = $_POST['alamat'];
    $no_telepon     = $_POST['no_telepon'];

    $foto = $data['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $foto = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto);
    }

    $stmt = $conn->prepare("UPDATE siswa SET nama=?, kelas=?, tempat_lahir=?, tanggal_lahir=?, nama_ayah=?, nama_ibu=?, alamat=?, no_telepon=?, foto=? WHERE nis=?");
    $stmt->bind_param("ssssssssss", $nama, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $alamat, $no_telepon, $foto, $nis);

    if ($stmt->execute()) {
        $msg = "<div class='text-green-600 font-bold mb-2'>Profil berhasil diperbarui.</div>";
        $_SESSION['nama'] = $nama;
        $data = array_merge($data, $_POST, ['foto' => $foto]);
    } else {
        $msg = "<div class='text-red-600 font-bold mb-2'>Gagal memperbarui profil.</div>";
    }
}

// Update password
if (isset($_POST['update_password'])) {
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    if ($pass1 !== $pass2) {
        $msg = "<div class='text-red-600 font-bold mb-2'>Password baru tidak sama.</div>";
    } else {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("UPDATE siswa SET password=? WHERE nis=?");
        $stmt->bind_param("ss", $hash, $nis);
        if ($stmt->execute()) {
            $msg = "<div class='text-green-600 font-bold mb-2'>Password berhasil diubah.</div>";
        } else {
            $msg = "<div class='text-red-600 font-bold mb-2'>Gagal mengubah password.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">



<div class="flex flex-1">

  

    <main class="flex-1 p-6 bg-[#FFF9F0]">
        <h2 class="text-3xl font-bold text-[#a9745a] mb-6">Pengaturan Profil Siswa</h2>
        <?= $msg ?>

        <!-- Update Profil -->
        <form method="post" enctype="multipart/form-data" class="space-y-4 mb-8 bg-white p-6 rounded-lg shadow border border-[#E4C988]">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">NIS</label>
                <input type="text" value="<?= htmlspecialchars($data['nis']) ?>" disabled class="w-full p-3 border border-gray-200 rounded bg-gray-100">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Jenis Kelamin</label>
                <input type="text" value="<?= htmlspecialchars($data['jenis_kelamin']) ?>" disabled class="w-full p-3 border border-gray-200 rounded bg-gray-100">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Kelas</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir']) ?>" required class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-300 transition">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']) ?>" required class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-300 transition">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="<?= htmlspecialchars($data['nama_ayah']) ?>" required class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="<?= htmlspecialchars($data['nama_ibu']) ?>" required class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"><?= htmlspecialchars($data['alamat']) ?></textarea>
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">No Telepon</label>
                    <input type="text" name="no_telepon" value="<?= htmlspecialchars($data['no_telepon']) ?>" class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                </div>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Foto</label>
                <?php if ($data['foto']) { ?>
                    <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Profil" class="w-20 h-20 rounded-full mb-2 shadow">
                <?php } ?>
                <input type="file" name="foto" accept="image/*" class="w-full p-2 border border-gray-200 rounded">
            </div>
            <button type="submit" name="update_profile" class="w-full py-3 rounded bg-[#5c3d15] hover:bg-[#4b320f] text-white font-bold text-lg shadow transition duration-300">
                Simpan Perubahan Profil
            </button>
        </form>

        <!-- Ubah Password -->
        <h3 class="text-xl font-bold mb-4 text-[#a9745a]">Ubah Password</h3>
        <form method="post" class="space-y-4 bg-white p-6 rounded-lg shadow border border-[#E4C988]">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password Baru</label>
                <input type="password" name="password1" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="password2" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <button type="submit" name="update_password" class="w-full py-3 rounded bg-[#5c3d15] hover:bg-[#4b320f] text-white font-bold text-lg shadow transition duration-300">
                Ubah Password
            </button>
        </form>
    </main>
</div>
</body>
</html>