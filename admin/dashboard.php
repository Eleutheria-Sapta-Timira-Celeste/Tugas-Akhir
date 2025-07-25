<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

$username = $_SESSION['username'] ?? '';
$default_foto = 'default.png';

// Ambil data admin dari database
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $foto = (!empty($user['logo']) && file_exists("../assets/images/admin_and_scribe/" . $user['logo']))
        ? $user['logo']
        : $default_foto;
} else {
    $user = [
        'nama_admin' => 'Admin',
        'username' => $username,
        'email'    => '',
    ];
    $foto = $default_foto;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">

<div class="flex flex-1">
    <main class="flex-1 p-6 bg-[#FFF9F0]">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Halo, <?= htmlspecialchars($user['nama_admin']) ?> 👋</h2>
            <p class="text-gray-700 mt-1">Selamat datang di Dashboard Admin SMP PGRI 371 Pondok Aren</p>
        </div>

        <!-- Profil Admin -->
        <div class="bg-white rounded-lg p-6 shadow border border-[#E4C988]">
            <h3 class="text-xl font-semibold mb-4 text-[#C08261]">Profil Admin</h3>
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-40 h-40 overflow-hidden rounded-full border-4 border-[#F5E8C7] shadow">
                    <img src="../assets/images/admin_and_scribe/<?= htmlspecialchars($foto) ?>" alt="Foto Profil" class="w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full mt-4 md:mt-0">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Admin</label>
                        <input type="text" value="<?= htmlspecialchars($user['nama_admin']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" value="<?= htmlspecialchars($user['email']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>
