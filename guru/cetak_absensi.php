<?php
include '../connection/database.php';

$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

if (!$kelas) {
    die("Kelas tidak ditentukan.");
}

session_start();
$info = ['kelas' => $kelas, 'mapel' => '', 'tanggal' => '', 'jam' => '', 'guru' => ''];

// Cek apakah guru login
if (isset($_SESSION['nama'])) {
    $info['guru'] = $_SESSION['nama'];

    // Ambil mapel dari tabel guru berdasarkan nama
    $stmtMapel = $connection->prepare("SELECT mapel FROM guru WHERE nama = ?");
    $stmtMapel->bind_param("s", $info['guru']);
    $stmtMapel->execute();
    $resultMapel = $stmtMapel->get_result();
    if ($rowMapel = $resultMapel->fetch_assoc()) {
        $info['mapel'] = $rowMapel['mapel'];
    }
}

// Ambil data absensi dari tabel absensi
$stmt = $connection->prepare("SELECT nama_siswa, status, tanggal, jam FROM absensi WHERE kelas = ? ORDER BY tanggal DESC, jam DESC, nama_siswa ASC");
$stmt->bind_param("s", $kelas);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;

    // Ambil tanggal & jam dari data pertama saja
    if (!$info['tanggal'] && !$info['jam']) {
        $info['tanggal'] = $row['tanggal'];
        $info['jam']     = $row['jam'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Absensi Kelas <?= htmlspecialchars($kelas) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 20px; }
        h2    { text-align: center; margin-bottom: 5px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        .info { margin-bottom: 10px; }
        .info td { border: none; text-align: left; }
        .print-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 16px;
            background-color: #ef6c00;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #d95c00;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak -->
    <div class="no-print">
        <button class="print-btn" onclick="window.print()">🖨️ Cetak Halaman</button>
    </div>

    <h2>SMP PGRI 371 PONDOK AREN</h2>
    <h2>Daftar Absensi Siswa</h2>
<div style="font-size: 14px; line-height: 1.8;">
    <div><span style="display: inline-block; width: 80px;">Guru</span>   : <?= htmlspecialchars($info['guru']) ?></div>
    <div><span style="display: inline-block; width: 80px;">Mapel</span>  : <?= htmlspecialchars($info['mapel']) ?></div>
    <div><span style="display: inline-block; width: 80px;">Kelas</span>  : <?= htmlspecialchars($info['kelas']) ?></div>
    <div><span style="display: inline-block; width: 80px;">Tanggal</span> : <?= $info['tanggal'] ? date('d-m-Y', strtotime($info['tanggal'])) : '-' ?></div>
    <div><span style="display: inline-block; width: 80px;">Jam</span>    : <?= $info['jam'] ? htmlspecialchars($info['jam']) : '-' ?></div>
</div>





    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th style="width: 40px; text-align: center; padding: 8px; border: 1px solid #ddd;">No</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Nama Siswa</th>
            <th style="text-align: center; padding: 8px; border: 1px solid #ddd;">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($data) > 0): ?>
        <?php $no = 1; foreach ($data as $row): ?>
        <tr>
            <td style="text-align: center; padding: 6px; border: 1px solid #ddd;"><?= $no++ ?></td>
            <td style="text-align: left; padding: 6px; border: 1px solid #ddd;"><?= htmlspecialchars($row['nama_siswa']) ?></td>
            <td style="text-align: center; padding: 6px; border: 1px solid #ddd;"><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" style="text-align: center; padding: 8px; border: 1px solid #ddd;">Tidak ada data absensi ditemukan.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>


</body>
</html>
