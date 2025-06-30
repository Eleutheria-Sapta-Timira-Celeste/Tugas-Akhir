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
    <title>Cetak Bukti Pendaftaran SPMB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .no-break {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body class="bg-white text-black p-0 m-0">

    <!-- HEADER (TIDAK IKUT TERPRINT) -->
     <div class="no-print">
     <?php include('../includes/header_form.php'); ?>
     </div>
    <!-- KONTEN UTAMA -->
    <div class="max-w-5xl mx-auto p-6">

        <!-- Judul -->
        <div class="flex items-center justify-center mb-6 space-x-4">
            <img src="../assects/images/defaults/logo_warna_500.png" alt="Logo Sekolah" class="w-28 h-28 object-cover">
            <div class="flex flex-col justify-center text-center">
                <h1 class="text-2xl font-bold">SMP PGRI 371 PONDOK AREN</h1>
                <h2 class="text-lg font-semibold">Sistem Penerimaan Murid Baru (SPMB) 2025</h2>
            </div>
        </div>

        <h2 class="text-center text-lg font-bold border-y border-black py-2 mb-6">
            DATA PENDAFTARAN SPMB
        </h2>

        <!-- DATA SISWA -->
        <div class="border border-gray-400 p-6 rounded-lg mb-10 no-break">
            <h3 class="text-2xl font-bold mb-4">DATA SISWA</h3>
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="col-span-1 flex items-center justify-center">
                    <img src="uploads/<?= $row['foto_pas'] ?>" onerror="this.src='<?= $defaultavatar ?>'" class="w-[90px] h-[120px] object-cover">
                </div>
                <div class="col-span-2 grid grid-cols-2 gap-4 text-sm">
                    <div class="p-2 rounded shadow-inner bg-gray-50"><strong>Nama Lengkap:</strong> <?= htmlspecialchars($row['nama_lengkap']) ?></div>
                    <div class="p-2 rounded shadow-inner bg-gray-50"><strong>NIS:</strong> <?= htmlspecialchars($row['nis']) ?></div>
                    <div class="p-2 rounded shadow-inner bg-gray-50"><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($row['jenis_kelamin']) ?></div>
                    <div class="p-2 rounded shadow-inner bg-gray-50"><strong>NIK:</strong> <?= htmlspecialchars($row['nik']) ?></div>
                    <div class="p-2 rounded shadow-inner bg-gray-50"><strong>Tempat / Tanggal Lahir:</strong> <?= htmlspecialchars($row['tempat_lahir']) ?> / <?= htmlspecialchars($row['tanggal_lahir']) ?></div>
                    <?php
                    $fields = [
                        'Agama' => 'agama',
                        'Alamat' => 'alamat_tinggal',
                        'Moda Transportasi' => 'moda_transportasi',
                        'Anak Ke' => 'anak_keberapa',
                        'Jumlah Saudara' => 'jumlah_saudara_kandung',
                        'No. Telepon' => 'no_telp',
                        'Penerima KIP' => 'penerima_kip',
                        'Nomor KIP' => 'no_kip',
                        'Tinggi (cm)' => 'tinggi_cm',
                        'Berat (kg)' => 'berat_kg',
                        'Jarak Tempat Tinggal (km)' => 'jarak_tempat_tinggal'
                    ];
                    foreach ($fields as $label => $field) {
                        echo '<div class="p-2 rounded shadow-inner bg-gray-50"><strong>'.$label.':</strong> '.htmlspecialchars($row[$field]).'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Page break -->
        <div class="page-break"></div>

        <!-- DATA AYAH -->
        <div class="border border-gray-400 p-6 rounded-lg mb-10 mt-32">
            <h3 class="text-2xl font-bold mb-4">DATA AYAH</h3>
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                <?php
                $fieldsAyah = [
                    'Nama' => 'nama_ayah',
                    'NIK' => 'nik_ayah',
                    'Tempat Lahir' => 'tempat_lahir_ayah',
                    'Tanggal Lahir' => 'tanggal_lahir_ayah',
                    'Pendidikan' => 'pendidikan_ayah',
                    'Pekerjaan' => 'pekerjaan_ayah',
                    'Penghasilan' => 'penghasilan_ayah',
                    'No. Telepon' => 'no_telp_ayah'
                ];
                foreach ($fieldsAyah as $label => $field) {
                    echo '<div class="p-2 rounded shadow-inner bg-gray-50"><strong>'.$label.':</strong> '.htmlspecialchars($row[$field]).'</div>';
                }
                ?>
            </div>
        </div>

        <!-- DATA IBU -->
        <div class="border border-gray-400 p-6 rounded-lg mb-10 no-break">
            <h3 class="text-2xl font-bold mb-4">DATA IBU</h3>
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                <?php
                $fieldsIbu = [
                    'Nama' => 'nama_ibu',
                    'NIK' => 'nik_ibu',
                    'Tempat Lahir' => 'tempat_lahir_ibu',
                    'Tanggal Lahir' => 'tanggal_lahir_ibu',
                    'Pendidikan' => 'pendidikan_ibu',
                    'Pekerjaan' => 'pekerjaan_ibu',
                    'Penghasilan' => 'penghasilan_ibu',
                    'No. Telepon' => 'no_telp_ibu'
                ];
                foreach ($fieldsIbu as $label => $field) {
                    echo '<div class="p-2 rounded shadow-inner bg-gray-50"><strong>'.$label.':</strong> '.htmlspecialchars($row[$field]).'</div>';
                }
                ?>
            </div>
        </div>
                <div class="no-print text-center mt-10">
            <button onclick="window.print()" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-5 py-2 rounded shadow">
                Cetak Halaman Ini
            </button>
        </div>
    </div>
    <!-- Tombol Cetak Halaman Ini -->


    <!-- FOOTER (TIDAK IKUT TERPRINT) -->
   <div class="no-print">
    <?php include('../includes/spmb_footer.php'); ?>
</div>


</body>
</html>
