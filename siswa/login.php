<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $password = $_POST['password'];

    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE nis = ?");
    $stmt->bind_param("s", $nis);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['nis'] = $user['nis'];
            $_SESSION['nama'] = $user['nama'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "NIS tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login Siswa</h2>

        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-700">NIS</label>
                <input type="text" name="nis" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Login
            </button>
        </form>
        <p class="text-center mt-4 text-sm">Belum punya akun? <a href="register.php" class="text-blue-500 underline">Daftar</a></p>
    </div>
</body>
</html>
