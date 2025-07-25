<?php
include '../connection/database.php';

// Validasi role siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

$username = $_SESSION['username'];
$foto     = $_SESSION['foto'] ?? 'default.png';

// Ambil data siswa
$query = "SELECT * FROM siswa WHERE username = ?";
$stmt  = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'nis'           => '',
        'nama'          => '',
        'kelas'         => '',
        'tempat_lahir'  => '',
        'tanggal_lahir' => '',
        'nama_ayah'     => '',
        'nama_ibu'      => '',
        'foto'          => $foto
    ];
}

// Ambil data absensi lengkap dengan mapel
$data_absensi = $connection->query("
    SELECT tanggal, jam, mapel, status 
    FROM absensi 
    WHERE username = '$username' 
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">


<div class="flex flex-1">

   

    <!-- Konten Utama -->
   <main class="flex-1 p-6 bg-gradient-to-br from-[#f7e5dc] via-white to-[#f7e5dc]">
    <div class="max-w-5xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl">
        <h2 class="text-3xl font-extrabold mb-4 flex items-center gap-2 text-[#a9745a]">
            <svg class="w-8 h-8 text-[#a9745a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 17v-2a4 4 0 0 1 8 0v2M5 21h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2z"></path>
            </svg>
            Riwayat Absensi Saya
        </h2>

        <div class="overflow-x-auto mt-6">
            <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-[#a9745a] text-white">
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Jam</th>
                        <th class="p-3 text-left">Mata Pelajaran</th>
                        <th class="p-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $data_absensi->fetch_assoc()) {
                        $badgeColor = [
                            'Hadir' => 'bg-green-100 text-green-700',
                            'Alpha' => 'bg-red-100 text-red-700',
                            'Izin'  => 'bg-yellow-100 text-yellow-700',
                            'Sakit' => 'bg-blue-100 text-blue-700'
                        ];
                        $ket = htmlspecialchars($row['status']);
                        $color = $badgeColor[$ket] ?? 'bg-gray-100 text-gray-700';
                    ?>
                    <tr class="hover:bg-[#f4e6df] transition-colors duration-200 even:bg-gray-50">
                        <td class="p-3"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="p-3"><?= htmlspecialchars(date('H:i', strtotime($row['jam']))) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['mapel']) ?></td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $color ?>">
                                <?= $ket ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</main>


</body>
</html>
