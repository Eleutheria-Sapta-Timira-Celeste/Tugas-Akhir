<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nis'])) {
    header("Location: index.php");
    exit;
}

$nis = $_SESSION['nis'];
$nama = $_SESSION['nama'];

$query = $conn->prepare("SELECT * FROM absensiswa WHERE nama = ? ORDER BY tanggal DESC");
$query->bind_param("s", $nama);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-100 via-white to-yellow-100 min-h-screen p-6">
    <div class="max-w-3xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-3xl font-extrabold mb-4 flex items-center gap-2 text-orange-600">
            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 17v-2a4 4 0 0 1 8 0v2M5 21h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2z"></path>
            </svg>
            Riwayat Absensi Saya
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-gradient-to-r from-orange-500 to-yellow-400 text-white">
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Kelas</th>
                        <th class="p-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { 
                        $badgeColor = [
                            'Hadir' => 'bg-green-100 text-green-700',
                            'Alpha' => 'bg-red-100 text-red-700',
                            'Izin'  => 'bg-yellow-100 text-yellow-700',
                            'Sakit' => 'bg-blue-100 text-blue-700'
                        ];
                        $ket = htmlspecialchars($row['keterangan']);
                        $color = $badgeColor[$ket] ?? 'bg-gray-100 text-gray-700';
                    ?>
                    <tr class="hover:bg-orange-50 transition-colors duration-200 even:bg-gray-50">
                        <td class="p-3"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['kelas']) ?></td>
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
</body>
</html>
