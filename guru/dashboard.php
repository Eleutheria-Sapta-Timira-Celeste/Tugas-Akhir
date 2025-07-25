<?php
include '../connection/database.php';



if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}


$username = $_SESSION['username'];
$foto     = $_SESSION['foto'] ?? 'default.png';

// Ambil data dari database
$query = "SELECT * FROM guru WHERE username = ?";
$stmt  = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'foto'  => $foto,
        'nip'   => '',
        'nama'  => '',
        'gelar' => '',
        'mapel' => ''
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">



<div class="flex flex-1">


    <!-- Main Content -->
    <main class="flex-1 p-6 bg-[#FFF9F0]">
        <div class="mb-6">
            <h2 class="text-3xl font-bold  text-[#a9745a]">Halo, <?= htmlspecialchars($user['nama']) ?> 👋</h2>
            <p class="text-gray-700 mt-1">Selamat datang di Dashboard Guru SMP PGRI 371 Pondok Aren</p>
        </div>

        <!-- Profil Guru -->
        <div class="bg-white rounded-lg p-6 shadow border border-[#E4C988]">
            <h3 class="text-xl font-semibold mb-4 text-[#C08261]">Profil Guru</h3>
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-40 h-40 overflow-hidden rounded-full border-4 border-[#F5E8C7] shadow">
                    <img src="uploads/<?= htmlspecialchars($user['foto']) ?>" alt="Foto Profil" class="w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full mt-4 md:mt-0">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" value="<?= htmlspecialchars($user['nip']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" value="<?= htmlspecialchars($user['nama']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gelar</label>
                        <input type="text" value="<?= htmlspecialchars($user['gelar']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mata Pelajaran yang Diampu</label>
                        <input type="text" value="<?= htmlspecialchars($user['mapel']) ?>" disabled class="w-full mt-1 px-3 py-2 border rounded bg-gray-100">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


</body>
</html>