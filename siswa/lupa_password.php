<?php
include 'koneksi.php';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis  = $_POST['nis'];
    $nama = $_POST['nama'];

    // Cek NIS + Nama
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE nis = ? AND nama = ?");
    $stmt->bind_param("ss", $nis, $nama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Buat password baru random
        $new_password_plain = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $new_password_hash  = password_hash($new_password_plain, PASSWORD_DEFAULT);

        // Update password ke database
        $update = $conn->prepare("UPDATE siswa SET password = ? WHERE nis = ?");
        $update->bind_param("ss", $new_password_hash, $nis);

        if ($update->execute()) {
            $success = "Password baru: <strong>$new_password_plain</strong>. Silakan login dengan password baru.";
        } else {
            $error = "Gagal reset password. Silakan coba lagi.";
        }
    } else {
        $error = "Data tidak ditemukan. Pastikan NIS dan Nama sesuai.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Lupa Password Siswa</h2>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block">NIS</label>
            <input type="text" name="nis" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block">Nama</label>
            <input type="text" name="nama" required class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Reset Password
        </button>
    </form>
    <p class="text-center mt-4 text-sm"><a href="login.php" class="text-blue-500 underline">Kembali ke Login</a></p>
</div>
</body>
</html>
