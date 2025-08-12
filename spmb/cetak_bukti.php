<?php
include '../connection/database.php';

$id = $_GET['id'];
$defaultavatar = 'uploads/default.png';

$query = "SELECT * FROM spmb WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "Data tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pendaftaran SPMB</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @media print {
      .no-print { display: none !important; }
      body {
        width: 210mm;
        height: 297mm;
        margin: 0 auto;
        padding: 20mm;
      }
      .page-break {
        page-break-before: always;
      }
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 6px;
      text-align: left;
      vertical-align: top;
    }
    td.label {
      width: 30%;
      font-weight: bold;
    }
    td.photo {
      text-align: center;
      border: 1px solid black;
      padding: 6px;
    }
  </style>
</head>
<body class="text-sm leading-tight text-black bg-white">

<!-- HEADER (tidak dicetak) -->
<div class="no-print">
  <?php include('../includes/header_form.php'); ?>
</div>

<!-- Tombol Cetak di Atas -->
<div class="no-print text-center my-6">
  <button onclick="window.print()" class="bg-[#5c3d15] hover:bg-[#4b320f] text-white font-semibold px-5 py-2 rounded shadow">
    🖨️ Cetak Bukti Pendaftaran
  </button>
</div>

<div class="max-w-4xl mx-auto p-6">

  <!-- Logo dan Judul -->
  <div class="text-center mb-6">
    <img src="../assects/images/defaults/logo_warna_500.png" alt="Logo" class="mx-auto w-24 h-24 mb-2">
    <h1 class="text-xl font-bold uppercase">SMP PGRI 371 Pondok Aren</h1>
    <p class="text-sm font-medium">Sistem Penerimaan Murid Baru (SPMB) 2025</p>
  </div>

  <!-- DATA SISWA -->
  <table class="text-sm mb-8">
    <tbody>
      <tr>
        <td class="label">Nama Siswa</td>
        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
        <td rowspan="6" class="photo">
          <img src="uploads/<?= $row['foto_pas'] ?>" onerror="this.src='<?= $defaultavatar ?>'" class="w-[120px] h-[150px] object-cover mx-auto mb-2 border border-black">
        </td>
      </tr>
      <tr>
        <td class="label">NISN Siswa</td>
        <td><?= htmlspecialchars($row['nis']) ?></td>
      </tr>
      <tr>
        <td class="label">Tempat / Tgl Lahir</td>
        <td><?= htmlspecialchars($row['tempat_lahir']) ?> / <?= htmlspecialchars($row['tanggal_lahir']) ?></td>
      </tr>
      <tr>
        <td class="label">Alamat</td>
        <td><?= htmlspecialchars($row['alamat_tinggal']) ?></td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
      </tr>
      <tr>
        <td class="label">No. Telepon</td>
        <td><?= htmlspecialchars($row['no_telp']) ?></td>
      </tr>
      <tr>
        <td class="label">Penerima KIP</td>
        <td colspan="2"><?= htmlspecialchars($row['penerima_kip']) ?> - <?= htmlspecialchars($row['no_kip']) ?></td>
      </tr>
      <tr>
        <td class="label">Tinggi / Berat (cm/kg)</td>
        <td colspan="2"><?= htmlspecialchars($row['tinggi_cm']) ?> / <?= htmlspecialchars($row['berat_kg']) ?></td>
      </tr>
      <tr>
        <td class="label">Jarak Tempat Tinggal (km)</td>
        <td colspan="2"><?= htmlspecialchars($row['jarak_tempat_tinggal']) ?></td>
      </tr>
      <tr>
        <td class="label">Anak Ke</td>
        <td colspan="2"><?= htmlspecialchars($row['anak_keberapa']) ?></td>
      </tr>
      <tr>
        <td class="label">Jumlah Saudara Kandung</td>
        <td colspan="2"><?= htmlspecialchars($row['jumlah_saudara_kandung']) ?></td>
      </tr>
    </tbody>
  </table>

  <!-- DATA AYAH -->
  <h2 class="text-lg font-bold mt-6 mb-2">Data Ayah</h2>
  <table class="text-sm mb-8">
    <tbody>
      <?php
      $ayah = [
        'Nama' => 'nama_ayah',
        'NIK' => 'nik_ayah',
        'Tempat Lahir' => 'tempat_lahir_ayah',
        'Tanggal Lahir' => 'tanggal_lahir_ayah',
        'Pendidikan' => 'pendidikan_ayah',
        'Pekerjaan' => 'pekerjaan_ayah',
        'Penghasilan' => 'penghasilan_ayah',
        'No. Telepon' => 'no_telp_ayah'
      ];
      foreach ($ayah as $label => $field) {
        echo "<tr><td class='label'>$label</td><td colspan='2'>" . htmlspecialchars($row[$field]) . "</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- DATA IBU - DI PAGE BREAK -->
  <div class="page-break"></div>
  <h2 class="text-lg font-bold mt-6 mb-2">Data Ibu</h2>
  <table class="text-sm mb-8">
    <tbody>
      <?php
      $ibu = [
        'Nama' => 'nama_ibu',
        'NIK' => 'nik_ibu',
        'Tempat Lahir' => 'tempat_lahir_ibu',
        'Tanggal Lahir' => 'tanggal_lahir_ibu',
        'Pendidikan' => 'pendidikan_ibu',
        'Pekerjaan' => 'pekerjaan_ibu',
        'Penghasilan' => 'penghasilan_ibu',
        'No. Telepon' => 'no_telp_ibu'
      ];
      foreach ($ibu as $label => $field) {
        echo "<tr><td class='label'>$label</td><td colspan='2'>" . htmlspecialchars($row[$field]) . "</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- TANDA TANGAN -->
  <div class="mt-10 text-sm mb-8">
    <p class="text-right mb-6">Tangerang Selatan, <?= date('d-m-Y') ?></p>
    <div class="grid grid-cols-3 text-center">
      <div>
        <p>Orang Tua / Wali</p>
        <div class="h-20"></div>
        <p class="font-semibold underline"><?= htmlspecialchars($row['nama_ayah']) ?></p>
      </div>
      <div>
        <p>Penerima Berkas</p>
        <div class="h-20"></div>
        <p class="font-semibold underline">..................................</p>
      </div>
      <div>
        <p>Calon Siswa</p>
        <div class="h-20"></div>
        <p class="font-semibold underline"><?= htmlspecialchars($row['nama_lengkap']) ?></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
