<?php
include 'cek_login.php';
include 'koneksi.php';

// Ambil header terakhir untuk info
$info = $conn->query("SELECT * FROM absensi ORDER BY id DESC LIMIT 1")->fetch_assoc();
$data = $conn->query("SELECT * FROM absensi ORDER BY nama_siswa ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }
        h1, h2 {
            text-align: center;
            margin: 0;
        }
        h1 {
            font-size: 22px;
            font-weight: bold;
        }
        h2 {
            font-size: 18px;
            margin-top: 6px;
        }
        .info-absen {
            margin: 30px 0 20px 0;
            font-size: 14px;
            width: 300px;
        }
        .info-row {
            display: flex;
            margin-bottom: 4px;
        }
        .info-label {
            width: 120px;
            font-weight: bold;
        }
        .info-separator {
            width: 10px;
        }
        .info-value {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-print {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #ef6c00;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<a href="#" onclick="window.print()" class="btn-print">🖨️ Cetak</a>

<h1>SMP PGRI 371 PONDOK AREN</h1>
<h2>Daftar Absensi Siswa</h2>

<div class="info-absen">
    <div class="info-row">
        <div class="info-label">Guru</div>
        <div class="info-separator">:</div>
        <div class="info-value"><?= htmlspecialchars($info['guru'] ?? $_SESSION['nama']) ?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Mata Pelajaran</div>
        <div class="info-separator">:</div>
        <div class="info-value"><?= htmlspecialchars($info['mapel'] ?? '-') ?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Kelas</div>
        <div class="info-separator">:</div>
        <div class="info-value"><?= htmlspecialchars($info['kelas'] ?? '-') ?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Tanggal</div>
        <div class="info-separator">:</div>
        <div class="info-value"><?= isset($info['tanggal']) ? date('d/m/Y', strtotime($info['tanggal'])) : '-' ?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Jam</div>
        <div class="info-separator">:</div>
        <div class="info-value"><?= isset($info['jam']) ? date('H.i', strtotime($info['jam'])) : '-' ?></div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width: 50px;">No</th>
            <th>Nama Siswa</th>
            <th style="width: 180px;">Status Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
