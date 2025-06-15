<?php
// filepath: c:\xampp\htdocs\Tugas-Akhir\siswa\pengaturan.php
session_start();
include 'koneksi.php';

// Pastikan siswa sudah login
if (!isset($_SESSION['nis'])) {
    header("Location: index.php");
    exit;
}

$nis = $_SESSION['nis'];
$msg = "";

// Ambil data siswa
$query = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
$query->bind_param("s", $nis);
$query->execute();
$data = $query->get_result()->fetch_assoc();

// Update profile
if (isset($_POST['update_profile'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];

    // Update foto jika ada upload baru
    $foto = $data['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $foto = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto);
    }

    $stmt = $conn->prepare("UPDATE siswa SET nama=?, kelas=?, tempat_lahir=?, tanggal_lahir=?, nama_ayah=?, nama_ibu=?, foto=? WHERE nis=?");
    $stmt->bind_param("ssssssss", $nama, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $foto, $nis);
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
        $stmt = $conn->prepare("UPDATE siswa SET password=? WHERE nis=?");
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
    <title>Pengaturan Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-100 via-white to-yellow-100 min-h-screen p-6">
<div class="max-w-2xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
    <h2 class="text-3xl font-extrabold mb-6 flex items-center gap-2 text-orange-600">
        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        Pengaturan Profil
    </h2>
    <?= $msg ?>
    <form method="post" enctype="multipart/form-data" class="space-y-4 mb-8">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">NIS</label>
            <input type="text" value="<?= htmlspecialchars($data['nis']) ?>" disabled class="w-full p-3 border border-gray-200 rounded-lg bg-gray-100">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required class="w-full p-3 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Kelas</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required class="w-full p-3 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir']) ?>" required class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-300 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']) ?>" required class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-300 transition">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama Ayah</label>
                <input type="text" name="nama_ayah" value="<?= htmlspecialchars($data['nama_ayah']) ?>" required class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama Ibu</label>
                <input type="text" name="nama_ibu" value="<?= htmlspecialchars($data['nama_ibu']) ?>" required class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
            </div>
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Foto</label>
            <?php if ($data['foto']) { ?>
                <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Profil" class="w-20 h-20 rounded-full mb-2 shadow">
            <?php } ?>
            <input type="file" name="foto" accept="image/*" class="w-full p-2 border border-gray-200 rounded-lg">
        </div>
        <button type="submit" name="update_profile" class="w-full py-3 rounded-lg bg-gradient-to-r from-orange-500 to-yellow-400 text-white font-bold text-lg shadow-lg hover:scale-105 transition-all duration-300">
            Simpan Perubahan Profil
        </button>
    </form>

    <h3 class="text-xl font-bold mb-2 mt-8 text-orange-600">Ubah Password</h3>
    <form method="post" class="space-y-4">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Password Baru</label>
            <input type="password" name="password1" required class="w-full p-3 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password Baru</label>
            <input type="password" name="password2" required class="w-full p-3 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
        </div>
        <button type="submit" name="update_password" class="w-full py-3 rounded-lg bg-gradient-to-r from-orange-500 to-amber-400 text-white font-bold text-lg shadow-lg hover:scale-105 transition-all duration-300">
            Ubah Password
        </button>
    </form>
</div>
</body>
</html>
