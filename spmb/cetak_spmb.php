<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_pgri371';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "ID tidak valid!";
    exit;
}

$query = $conn->query("SELECT * FROM spmb_siswa WHERE id = $id");
$data = $query->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .print-area { border: 1px solid #ccc; padding: 20px; }
        .section { margin-bottom: 25px; }
        .section h3 { border-bottom: 1px solid #999; padding-bottom: 5px; margin-bottom: 10px; }
        .item { margin-bottom: 5px; }
        .label { font-weight: bold; display: inline-block; width: 250px; }
        .btn-print { margin-top: 20px; padding: 10px 20px; background-color: #ef6c00; color: white; border: none; cursor: pointer; }
        .btn-print:hover { background-color: #cc5a00; }
    </style>
</head>
<body>
    <div class="print-area">
        <h2>Bukti Pendaftaran Siswa Baru</h2>

        <!-- Data Siswa -->
        <div class="section">
            <h3>Data Siswa</h3>
            <div class="item"><span class="label">Nama Lengkap:</span> <?= htmlspecialchars($data['nama_lengkap']) ?></div>
            <div class="item"><span class="label">Jenis Kelamin:</span> <?= htmlspecialchars($data['jenis_kelamin']) ?></div>
            <div class="item"><span class="label">NIS:</span> <?= htmlspecialchars($data['nis']) ?></div>
            <div class="item"><span class="label">NIK:</span> <?= htmlspecialchars($data['nik']) ?></div>
            <div class="item"><span class="label">Tempat & Tanggal Lahir:</span> <?= htmlspecialchars($data['tempat_lahir']) ?>, <?= htmlspecialchars($data['tanggal_lahir']) ?></div>
            <div class="item"><span class="label">Agama:</span> <?= htmlspecialchars($data['agama']) ?></div>
            <div class="item"><span class="label">Alamat Tinggal:</span> <?= htmlspecialchars($data['alamat_tinggal']) ?></div>
            <div class="item"><span class="label">Tempat Tinggal:</span> <?= htmlspecialchars($data['tempat_tinggal']) ?></div>
            <div class="item"><span class="label">Moda Transportasi:</span> <?= htmlspecialchars($data['moda_transportasi']) ?></div>
            <div class="item"><span class="label">Anak ke-:</span> <?= htmlspecialchars($data['anak_keberapa']) ?></div>
            <div class="item"><span class="label">Jumlah Saudara Kandung:</span> <?= htmlspecialchars($data['jumlah_saudara_kandung']) ?></div>
            <div class="item"><span class="label">No. Telp:</span> <?= htmlspecialchars($data['no_telp']) ?></div>
            <div class="item"><span class="label">Penerima KIP:</span> <?= htmlspecialchars($data['penerima_kip']) ?></div>
            <div class="item"><span class="label">No. KIP:</span> <?= htmlspecialchars($data['no_kip']) ?></div>
            <div class="item"><span class="label">Tinggi Badan (cm):</span> <?= htmlspecialchars($data['tinggi_cm']) ?></div>
            <div class="item"><span class="label">Berat Badan (kg):</span> <?= htmlspecialchars($data['berat_kg']) ?></div>
            <div class="item"><span class="label">Jarak Tempat Tinggal (km):</span> <?= htmlspecialchars($data['jarak_tempat_tinggal']) ?></div>
        </div>

        <!-- Data Ayah -->
        <div class="section">
            <h3>Data Ayah</h3>
            <div class="item"><span class="label">Nama Ayah:</span> <?= htmlspecialchars($data['nama_ayah']) ?></div>
            <div class="item"><span class="label">NIK Ayah:</span> <?= htmlspecialchars($data['nik_ayah']) ?></div>
            <div class="item"><span class="label">Tempat & Tanggal Lahir Ayah:</span> <?= htmlspecialchars($data['tempat_lahir_ayah']) ?>, <?= htmlspecialchars($data['tanggal_lahir_ayah']) ?></div>
            <div class="item"><span class="label">Pendidikan Ayah:</span> <?= htmlspecialchars($data['pendidikan_ayah']) ?></div>
            <div class="item"><span class="label">Pekerjaan Ayah:</span> <?= htmlspecialchars($data['pekerjaan_ayah']) ?></div>
            <div class="item"><span class="label">Penghasilan Ayah:</span> <?= htmlspecialchars($data['penghasilan_ayah']) ?></div>
        </div>

        <!-- Data Ibu -->
        <div class="section">
            <h3>Data Ibu</h3>
            <div class="item"><span class="label">Nama Ibu:</span> <?= htmlspecialchars($data['nama_ibu']) ?></div>
            <div class="item"><span class="label">NIK Ibu:</span> <?= htmlspecialchars($data['nik_ibu']) ?></div>
            <div class="item"><span class="label">Tempat & Tanggal Lahir Ibu:</span> <?= htmlspecialchars($data['tempat_lahir_ibu']) ?>, <?= htmlspecialchars($data['tanggal_lahir_ibu']) ?></div>
            <div class="item"><span class="label">Pendidikan Ibu:</span> <?= htmlspecialchars($data['pendidikan_ibu']) ?></div>
            <div class="item"><span class="label">Pekerjaan Ibu:</span> <?= htmlspecialchars($data['pekerjaan_ibu']) ?></div>
            <div class="item"><span class="label">Penghasilan Ibu:</span> <?= htmlspecialchars($data['penghasilan_ibu']) ?></div>
        </div>

        <!-- Foto Pas -->
        <div class="section">
            <h3>Foto</h3>
            <?php if (!empty($data['foto_pas'])): ?>
                <img src="uploads_/<?= htmlspecialchars($data['foto_pas']) ?>" alt="Foto Pas" style="max-height: 200px;">
            <?php else: ?>
                <p>Tidak ada foto yang diunggah.</p>
            <?php endif; ?>
        </div>
    </div>

    <button onclick="window.print()" class="btn-print">🖨️ Cetak</button>
</body>
</html>
