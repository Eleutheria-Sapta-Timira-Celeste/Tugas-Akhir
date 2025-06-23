<?php
include '../connection/database.php';
session_start();

// Cek login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Ambil data admin berdasarkan ID dari URL
if (!isset($_GET['id'])) {
    echo "ID Admin tidak ditemukan.";
    exit();
}

$admin_id = intval($_GET['id']);
$query = $connectionobj->prepare("SELECT * FROM admin WHERE id = ?");
$query->bind_param("i", $admin_id);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    echo "Data admin tidak ditemukan.";
    exit();
}

$defaultLogo = "../assects/defaults/logo_admin.png";

// Jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $email = $_POST['email'];

    // Upload logo
    $logoPath = $admin['logo'];
    if (!empty($_FILES['logo']['name'])) {
        $fileName = $_FILES['logo']['name'];
        $tmpName = $_FILES['logo']['tmp_name'];
        $uploadDir = '../assects/images/admin_and_scribe/';
        $newPath = $uploadDir . basename($fileName);
        if (move_uploaded_file($tmpName, $newPath)) {
            $logoPath = "assects/images/admin_and_scribe/" . basename($fileName);
        }
    }

    // Jika ingin ganti password
    $newPassword = $_POST['new_password'];
    $hashedPassword = $admin['password'];
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    $update = $connectionobj->prepare("UPDATE admin SET username=?, nama_admin=?, email=?, password=?, logo=? WHERE id=?");
    $update->bind_param("sssssi", $username, $nama_admin, $email, $hashedPassword, $logoPath, $admin_id);

    if ($update->execute()) {
        echo "<script>alert('Data admin berhasil diperbarui!'); window.location='admin_management.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui: {$update->error}');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 px-6 py-8">

    <h1 class="text-3xl mb-6 font-bold text-orange-600">✏️ Edit Admin</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-6 py-8 w-full max-w-xl">

        <input type="hidden" name="update_admin" value="1">

        <div class="mb-4">
            <label class="block font-semibold mb-2">Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($admin['username']) ?>" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Nama Admin</label>
            <input type="text" name="nama_admin" value="<?= htmlspecialchars($admin['nama_admin']) ?>" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Ganti Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="new_password" class="w-full border px-3 py-2 rounded" minlength="8">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Ganti Logo</label>
            <?php if (!empty($admin['logo'])): ?>
                <img src="../<?= $admin['logo'] ?>" class="h-24 mb-2 rounded border">
            <?php else: ?>
                <img src="<?= $defaultLogo ?>" class="h-24 mb-2 rounded border">
            <?php endif; ?>
            <input type="file" name="logo" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="flex justify-between">
            <a href="admin_management.php" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">← Kembali</a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">Simpan</button>
        </div>

    </form>

</body>
</html>
