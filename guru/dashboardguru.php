<?php
include 'cek_login.php';
include 'koneksi.php';

$username = $_SESSION['username'];
$nip      = $_SESSION['nip'];
$nama     = $_SESSION['nama'];
$mapel    = $_SESSION['mapel'];
$foto     = $_SESSION['foto'] ?? 'default.png';

$query = "SELECT * FROM guru WHERE username = ?";
$stmt  = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'foto'  => $foto,
        'nip'   => $nip,
        'nama'  => $nama,
        'gelar' => '',
        'mapel' => $mapel
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

<!-- HEADER SISWA -->
<?php include('../includes/header_siswa.php'); ?>

<div class="flex flex-1">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#F5E8C7] text-gray-800 min-h-full p-6 shadow-md">
        <nav class="space-y-4">
            <a href="dashboardguru.php" class="block px-4 py-2 bg-[#E4C988] rounded hover:bg-[#D9C38C]">🏠 Dashboard</a>
            <a href="melihat_absensi.php" class="block px-4 py-2 rounded hover:bg-[#D9C38C]">📝 Absensi </a>
            <a href="jadwalmengajar.php" class="block px-4 py-2 rounded hover:bg-[#D9C38C]">📝 Jadwal Mengajar </a>
            <a href="Pengaturan.php" class="block px-4 py-2 rounded hover:bg-[#D9C38C]">📝 Pengaturan </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-[#FFF9F0]">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Halo, <?= htmlspecialchars($user['nama']) ?> 👋</h2>
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

<!-- FOOTER -->
<?php include('../includes/admin_footer.php'); ?>

</body>
</html>
