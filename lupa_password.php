<?php
session_start();
include 'connection/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi tidak cocok!';
    } else {
        // Coba cari di semua role
        $roles = ['admin', 'guru', 'siswa'];
        $found = false;

        foreach ($roles as $role) {
            $query = "SELECT * FROM $role WHERE username = '$username'";
            $result = $connection->query($query);

            if ($result && $result->num_rows === 1) {
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $update = "UPDATE $role SET password = '$password_hash' WHERE username = '$username'";
                if ($connection->query($update)) {
                    $success = "Password berhasil diubah untuk $role!";
                    $found = true;
                    break;
                } else {
                    $error = 'Gagal mengubah password.';
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $error = 'Username tidak ditemukan!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Lupa Password - Multi Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-6">Lupa Password</h2>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $error ?>
            </div>
        <?php elseif ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" required
                    class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" name="new_password" required
                    class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" required
                    class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit"
                class="w-full bg-[#ef6c00] text-white py-2 rounded hover:bg-[#ef6c00]">Ubah Password</button>
        </form>

        <div class="text-center mt-6">
            <a href="login.php" class="text-blue-500 hover:text-blue-700">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>
