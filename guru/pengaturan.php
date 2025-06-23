<?php
include 'cek_login.php';
include 'koneksi.php';

$username = $_SESSION['username'];
$msg = "";

// Ambil data guru
$query = $conn->prepare("SELECT * FROM guru WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$data = $query->get_result()->fetch_assoc();

// Update profil
if (isset($_POST['update_profile'])) {
    $nip   = $_POST['nip'];
    $nama  = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $mapel = $_POST['mapel'];

    // Update foto jika upload baru
    $foto = $data['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $foto_name = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $foto_name);
        $foto = $foto_name;
    }

    $stmt = $conn->prepare("UPDATE guru SET nip=?, nama=?, gelar=?, mapel=?, foto=? WHERE username=?");
    $stmt->bind_param("ssssss", $nip, $nama, $gelar, $mapel, $foto, $username);
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
        $stmt = $conn->prepare("UPDATE guru SET password=? WHERE username=?");
        $stmt->bind_param("ss", $hash, $username);
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
    <title>Pengaturan Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">

<!-- HEADER -->
<?php include('../includes/header_guru.php'); ?>

<div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#F5E8C7] text-gray-800 min-h-full p-6 shadow-md">
        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 rounded hover:bg-[#D9C38C]">🏠 Dashboard</a>
            <a href="inputabsensi.php" class="block px-4 py-2 rounded hover:bg-[#D9C38C]">📝 Absensi </a>
            <a href="pengaturan.php" class="block px-4 py-2 bg-[#E4C988] rounded hover:bg-[#D9C38C]">⚙️ Pengaturan </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-[#FFF9F0]">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Pengaturan Profil Guru</h2>
        <?= $msg ?>

        <!-- Update Profile -->
        <form method="post" enctype="multipart/form-data" class="space-y-4 mb-8 bg-white p-6 rounded-lg shadow border border-[#E4C988]">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Username</label>
                <input type="text" value="<?= htmlspecialchars($data['username']) ?>" disabled class="w-full p-3 border border-gray-200 rounded bg-gray-100">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">NIP</label>
                <input type="text" name="nip" value="<?= htmlspecialchars($data['nip']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Gelar</label>
                <input type="text" name="gelar" value="<?= htmlspecialchars($data['gelar']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Mata Pelajaran</label>
                <input type="text" name="mapel" value="<?= htmlspecialchars($data['mapel']) ?>" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Foto</label>
                <?php if ($data['foto']) { ?>
                    <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Foto Profil" class="w-20 h-20 rounded-full mb-2 shadow">
                <?php } ?>
                <input type="file" name="foto" accept="image/*" class="w-full p-2 border border-gray-200 rounded">
            </div>
            <button type="submit" name="update_profile" class="w-full py-3 rounded bg-gradient-to-r from-orange-500 to-yellow-400 text-white font-bold text-lg shadow hover:scale-105 transition duration-300">
                Simpan Perubahan Profil
            </button>
        </form>

        <!-- Update Password -->
        <h3 class="text-xl font-bold mb-4 text-orange-600">Ubah Password</h3>
        <form method="post" class="space-y-4 bg-white p-6 rounded-lg shadow border border-[#E4C988]">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password Baru</label>
                <input type="password" name="password1" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="password2" required class="w-full p-3 border border-orange-200 rounded focus:outline-none focus:ring-2 focus:ring-orange-400 transition">
            </div>
            <button type="submit" name="update_password" class="w-full py-3 rounded bg-gradient-to-r from-orange-500 to-amber-400 text-white font-bold text-lg shadow hover:scale-105 transition duration-300">
                Ubah Password
            </button>
        </form>

    </main>
</div>

<!-- FOOTER -->
<?php include('../includes/footer_guru.php'); ?>

</body>
</html>
