<?php
// Koneksi PDO
$host = 'localhost';
$db   = 'db_pgri371';
$user = 'root'; // sesuaikan
$pass = '';     // sesuaikan
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Koneksi Gagal: ' . $e->getMessage());
}

// Proses Simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Upload Foto
    $foto_name = '';
    if (isset($_FILES['foto_pas']) && $_FILES['foto_pas']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $foto_name = time() . '_' . basename($_FILES["foto_pas"]["name"]);
        $target_file = $target_dir . $foto_name;
        move_uploaded_file($_FILES["foto_pas"]["tmp_name"], $target_file);
    }

    // Insert Data
    $sql = "INSERT INTO spmb 
    (nama_lengkap, jenis_kelamin, nis, nik, tempat_lahir, tanggal_lahir, agama, alamat_tinggal, tempat_tinggal, moda_transportasi, anak_keberapa, jumlah_saudara_kandung, no_telp, penerima_kip, no_kip, tinggi_cm, berat_kg, jarak_tempat_tinggal, nama_ayah, nik_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah, no_telp_ayah, nama_ibu, nik_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu, no_telp_ibu, foto_pas)
    VALUES 
    (:nama_lengkap, :jenis_kelamin, :nis, :nik, :tempat_lahir, :tanggal_lahir, :agama, :alamat_tinggal, :tempat_tinggal, :moda_transportasi, :anak_keberapa, :jumlah_saudara_kandung, :no_telp, :penerima_kip, :no_kip, :tinggi_cm, :berat_kg, :jarak_tempat_tinggal, :nama_ayah, :nik_ayah, :tempat_lahir_ayah, :tanggal_lahir_ayah, :pendidikan_ayah, :pekerjaan_ayah, :penghasilan_ayah, :no_telp_ayah, :nama_ibu, :nik_ibu, :tempat_lahir_ibu, :tanggal_lahir_ibu, :pendidikan_ibu, :pekerjaan_ibu, :penghasilan_ibu, :no_telp_ibu, :foto_pas)";

    $stmt = $pdo->prepare($sql);

    $params = [
        ':nama_lengkap' => $_POST['nama_lengkap'],
        ':jenis_kelamin' => $_POST['jenis_kelamin'],
        ':nis' => $_POST['nis'],
        ':nik' => $_POST['nik'],
        ':tempat_lahir' => $_POST['tempat_lahir'],
        ':tanggal_lahir' => $_POST['tanggal_lahir'],
        ':agama' => $_POST['agama'],
        ':alamat_tinggal' => $_POST['alamat_tinggal'],
        ':tempat_tinggal' => $_POST['tempat_tinggal'],
        ':moda_transportasi' => $_POST['moda_transportasi'],
        ':anak_keberapa' => $_POST['anak_keberapa'],
        ':jumlah_saudara_kandung' => $_POST['jumlah_saudara_kandung'],
        ':no_telp' => $_POST['no_telp'],
        ':penerima_kip' => $_POST['penerima_kip'],
        ':no_kip' => $_POST['no_kip'],
        ':tinggi_cm' => $_POST['tinggi_cm'],
        ':berat_kg' => $_POST['berat_kg'],
        ':jarak_tempat_tinggal' => $_POST['jarak_tempat_tinggal'],
        ':nama_ayah' => $_POST['nama_ayah'],
        ':nik_ayah' => $_POST['nik_ayah'],
        ':tempat_lahir_ayah' => $_POST['tempat_lahir_ayah'],
        ':tanggal_lahir_ayah' => $_POST['tanggal_lahir_ayah'],
        ':pendidikan_ayah' => $_POST['pendidikan_ayah'],
        ':pekerjaan_ayah' => $_POST['pekerjaan_ayah'],
        ':penghasilan_ayah' => $_POST['penghasilan_ayah'],
        ':no_telp_ayah' => $_POST['no_telp_ayah'],
        ':nama_ibu' => $_POST['nama_ibu'],
        ':nik_ibu' => $_POST['nik_ibu'],
        ':tempat_lahir_ibu' => $_POST['tempat_lahir_ibu'],
        ':tanggal_lahir_ibu' => $_POST['tanggal_lahir_ibu'],
        ':pendidikan_ibu' => $_POST['pendidikan_ibu'],
        ':pekerjaan_ibu' => $_POST['pekerjaan_ibu'],
        ':penghasilan_ibu' => $_POST['penghasilan_ibu'],
         ':no_telp_ibu' => $_POST['no_telp_ibu'],
        ':foto_pas' => $foto_name
    ];

    if ($stmt->execute($params)) {
    // Ambil ID terakhir yang di-insert
    $last_id = $pdo->lastInsertId();

    // Redirect ke halaman data spmb
    header("Location: cetak_bukti.php?id=$last_id");
    exit;
}

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran SPMB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
<<<<<<< HEAD
        @keyframes fadeSlideDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .logo-animate { animation: fadeSlideDown 1s ease forwards; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
<?php include('../includes/header_form.php'); ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-10 border">
    <!-- Logo -->
    <div class="flex justify-center mb-8 logo-animate">
        <img class="w-80 h-22 mr-2" src="../assects/images/defaults/logoadmin.png" alt="logo"> 
    </div>   

    <!-- Judul -->
    <h1 class="text-2xl font-bold text-center mb-4 text-[#a9745a]">Formulir Pendaftaran Siswa Baru</h1>

    <!-- Info semua data wajib diisi -->
    <div class="mb-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 text-sm rounded">
        <strong>Perhatian:</strong> Semua data yang ditandai wajib diisi dengan benar sebelum mengirim formulir.
    </div>

    <!-- Tanggal pendaftaran -->
    <p class="text-right text-sm text-gray-600 mb-4">
        Tanggal Pendaftaran : <span id="tanggalDaftar"></span>
    </p>

    <!-- Notifikasi jika form belum lengkap -->
    <div id="alertForm" class="hidden mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded">
        Silakan lengkapi semua data yang wajib diisi sebelum mengirim formulir.
    </div>

    <!-- FORM -->
    <form id="spmbForm" method="post" enctype="multipart/form-data" class="space-y-6 text-sm">
  <!-- DATA SISWA -->
  <h2 class="text-lg font-bold text-[#a9745a]">DATA SISWA</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Nama Lengkap -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label class="sm:w-40 font-medium" for="nama_lengkap">Nama Lengkap<span class="text-red-500">*</span></label>
      <input id="nama_lengkap" name="nama_lengkap" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nama lengkap" />
=======
        /* Animasi fade-in dan slide down untuk logo */
        @keyframes fadeSlideDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .logo-animate {
            animation: fadeSlideDown 1s ease forwards;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include('../includes/header_form.php'); ?>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-10 border-2 border-[#ef6c00]"> <br>
                <div class="flex justify-center mb-8 logo-animate">
                    <img class="w-80 h-22 mr-2" src="../assects/images/defaults/logoadmin.png" alt="logo"> 
                </div>   
    <!-- Logo Sekolah dengan animasi -->
        <!-- <div class="flex justify-center mb-8 logo-animate">
            <img src="assects/images/defaults/logo_warna_500.png" class="w-24 h-24 object-contain">
        </div> -->

       <h1 class="text-2xl font-bold text-center mb-6 text-[#ef6c00]">Formulir Pendaftaran Siswa Baru</h1>
        <p class="text-right text-sm text-gray-600 mb-4">
            Tanggal Pendaftaran : <span id="tanggalDaftar"></span>
</p>
<form method="post" enctype="multipart/form-data" class="space-y-6 text-sm max-w-4xl mx-auto p-4">
  <!-- DATA SISWA -->
  <h2 class="text-lg font-bold text-[#ef6c00]">DATA SISWA</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Nama Lengkap -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label class="sm:w-40 font-medium" for="nama_lengkap">Nama Lengkap</label>
      <input id="nama_lengkap" name="nama_lengkap" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Jenis Kelamin -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="jenis_kelamin" class="sm:w-40 font-medium">Jenis Kelamin<span class="text-red-500">*</span></label>
      <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" >
=======
      <label for="jenis_kelamin" class="sm:w-40 font-medium">Jenis Kelamin</label>
      <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
        <option>Laki-laki</option>
        <option>Perempuan</option>
      </select>
    </div>

   <!-- NIS -->
<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
  <label for="nis" class="sm:w-40 font-medium">NIS<span class="text-red-500">*</span></label>
=======
  <label for="nis" class="sm:w-40 font-medium">NIS</label>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
  <div class="w-full sm:flex-1">
    <input 
      id="nis" 
      name="nis" 
      required 
      pattern="[0-9]{8,10}" 
      oninput="validateInput(this, 8, 'nisError', 10)" 
<<<<<<< HEAD
      class="w-full border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" 
      placeholder="Masukkan NIS" />
=======
      class="w-full border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94

    <small id="nisError" class="text-red-600 hidden">NIS harus 8–10 digit angka.</small>
  </div>
</div>

<!-- NIK Siswa -->
<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
  <label for="nik" class="sm:w-40 font-medium">NIK Siswa<span class="text-red-500">*</span></label>
=======
  <label for="nik" class="sm:w-40 font-medium">NIK Siswa</label>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
  <div class="w-full sm:flex-1">
    <input 
    id="nik" 
    name="nik" 
    required 
    pattern="[0-9]{16}" 
    oninput="validateInput(this, 16, 'nikSiswaError')" 
<<<<<<< HEAD
    class="w-full border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" 
    placeholder="Masukkan NIK" />
=======
    class="w-full border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94

    <small id="nikSiswaError" class="text-red-600 hidden">NIK Siswa harus 16 digit angka.</small>
  </div>
</div>


    <!-- Tempat Lahir -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tempat_lahir" class="sm:w-40 font-medium">Tempat Lahir<span class="text-red-500">*</span></label>
      <input id="tempat_lahir" name="tempat_lahir" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan Kota lahir kamu"  />
=======
      <label for="tempat_lahir" class="sm:w-40 font-medium">Tempat Lahir</label>
      <input id="tempat_lahir" name="tempat_lahir" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Tanggal Lahir -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tanggal_lahir" class="sm:w-40 font-medium">Tanggal Lahir<span class="text-red-500">*</span></label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" />
=======
      <label for="tanggal_lahir" class="sm:w-40 font-medium">Tanggal Lahir</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Agama -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="agama" class="sm:w-40 font-medium">Agama<span class="text-red-500">*</span></label>
      <input id="agama" name="agama" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan Agama"  />
=======
      <label for="agama" class="sm:w-40 font-medium">Agama</label>
      <input id="agama" name="agama" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Alamat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-4 md:col-span-2">
<<<<<<< HEAD
      <label for="alamat_tinggal" class="sm:w-40 font-medium pt-2">Alamat Tinggal<span class="text-red-500">*</span></label>
      <textarea id="alamat_tinggal" name="alamat_tinggal" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" rows="3"  placeholder="Masukkan alamat lengkap" ></textarea>
=======
      <label for="alamat_tinggal" class="sm:w-40 font-medium pt-2">Alamat Tinggal</label>
      <textarea id="alamat_tinggal" name="alamat_tinggal" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" rows="3"></textarea>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Tempat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tempat_tinggal" class="sm:w-40 font-medium">Tempat Tinggal<span class="text-red-500">*</span></label>
      <select id="tempat_tinggal" name="tempat_tinggal" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" >
=======
      <label for="tempat_tinggal" class="sm:w-40 font-medium">Tempat Tinggal</label>
      <select id="tempat_tinggal" name="tempat_tinggal" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
        <option>Bersama Orang Tua</option>
        <option>Wali</option>
        <option>Kos</option>
        <option>Lainnya</option>
      </select>
    </div>

    <!-- Moda Transportasi -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="moda_transportasi" class="sm:w-40 font-medium">Moda Transportasi<span class="text-red-500">*</span></label>
      <input id="moda_transportasi" name="moda_transportasi" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan moda transportasi"  />
=======
      <label for="moda_transportasi" class="sm:w-40 font-medium">Moda Transportasi</label>
      <input id="moda_transportasi" name="moda_transportasi" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Anak ke- -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="anak_keberapa" class="sm:w-40 font-medium">Anak ke-<span class="text-red-500">*</span></label>
      <input id="anak_keberapa" type="number" name="anak_keberapa" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Contoh: 1" />
=======
      <label for="anak_keberapa" class="sm:w-40 font-medium">Anak ke-</label>
      <input id="anak_keberapa" type="number" name="anak_keberapa" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Jumlah Saudara Kandung -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="jumlah_saudara_kandung" class="sm:w-40 font-medium">Jumlah Saudara Kandung<span class="text-red-500">*</span></label>
      <input id="jumlah_saudara_kandung" type="number" name="jumlah_saudara_kandung" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder=" Masukkan jumlah saudara"  />
=======
      <label for="jumlah_saudara_kandung" class="sm:w-40 font-medium">Jumlah Saudara Kandung</label>
      <input id="jumlah_saudara_kandung" type="number" name="jumlah_saudara_kandung" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- No Telp -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="no_telp" class="sm:w-40 font-medium">No Telp<span class="text-red-500">*</span></label>
      <input id="no_telp" name="no_telp" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nomor telepon" />
=======
      <label for="no_telp" class="sm:w-40 font-medium">No Telp</label>
      <input id="no_telp" name="no_telp" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Penerima KIP -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="penerima_kip" class="sm:w-40 font-medium">Penerima KIP<span class="text-red-500">*</span></label>
      <select id="penerima_kip" name="penerima_kip" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]">
=======
      <label for="penerima_kip" class="sm:w-40 font-medium">Penerima KIP</label>
      <select id="penerima_kip" name="penerima_kip" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
        <option>Ya</option>
        <option>Tidak</option>
      </select>
    </div>

    <!-- No KIP -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_kip" class="sm:w-40 font-medium">No KIP</label>
<<<<<<< HEAD
      <input id="no_kip" name="no_kip" class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan No. KIP" />
=======
      <input id="no_kip" name="no_kip" class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Tinggi (cm) -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tinggi_cm" class="sm:w-40 font-medium">Tinggi (cm)<span class="text-red-500">*</span></label>
      <input id="tinggi_cm" type="number" name="tinggi_cm" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan tinggi badan" />
=======
      <label for="tinggi_cm" class="sm:w-40 font-medium">Tinggi (cm)</label>
      <input id="tinggi_cm" type="number" name="tinggi_cm" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Berat (kg) -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="berat_kg" class="sm:w-40 font-medium">Berat (kg)<span class="text-red-500">*</span></label>
      <input id="berat_kg" type="number" name="berat_kg" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan berat badan" />
=======
      <label for="berat_kg" class="sm:w-40 font-medium">Berat (kg)</label>
      <input id="berat_kg" type="number" name="berat_kg" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    <!-- Jarak Tempat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="jarak_tempat_tinggal" class="sm:w-40 font-medium">Jarak Tempat Tinggal<span class="text-red-500">*</span></label>
      <input id="jarak_tempat_tinggal" name="jarak_tempat_tinggal" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan jarak rumah" />
    </div>

    <!-- DATA AYAH -->
    <h2 class="text-lg font-bold text-[#a9745a] col-span-2 mt-6">DATA AYAH</h2>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nama_ayah" class="sm:w-40 font-medium">Nama Ayah<span class="text-red-500">*</span></label>
      <input id="nama_ayah" name="nama_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nama ayah" />
    </div>

   <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nik_ayah" class="sm:w-40 font-medium">NIK Ayah<span class="text-red-500">*</span></label>
=======
      <label for="jarak_tempat_tinggal" class="sm:w-40 font-medium">Jarak Tempat Tinggal</label>
      <input id="jarak_tempat_tinggal" name="jarak_tempat_tinggal" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- DATA AYAH -->
    <h2 class="text-lg font-bold text-[#ef6c00] col-span-2 mt-6">DATA AYAH</h2>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nama_ayah" class="sm:w-40 font-medium">Nama Ayah</label>
      <input id="nama_ayah" name="nama_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

   <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nik_ayah" class="sm:w-40 font-medium">NIK Ayah</label>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
      <div class="w-full sm:flex-1">
       <input 
        id="nik_ayah" 
        name="nik_ayah" 
        required 
        pattern="[0-9]{16}" 
        oninput="validateInput(this, 16, 'nikAyahError')" 
<<<<<<< HEAD
        class="w-full border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" 
        placeholder="Masukkan NIK ayah" />
=======
        class="w-full border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94

        <small id="nikAyahError" class="text-red-600 hidden">NIK Ayah harus 16 digit angka.</small>
      </div>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tempat_lahir_ayah" class="sm:w-40 font-medium">Tempat Lahir Ayah<span class="text-red-500">*</span></label>
      <input id="tempat_lahir_ayah" name="tempat_lahir_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan tempat lahir ayah" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tanggal_lahir_ayah" class="sm:w-40 font-medium">Tanggal Lahir Ayah<span class="text-red-500">*</span></label>
      <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pendidikan_ayah" class="sm:w-40 font-medium">Pendidikan Ayah<span class="text-red-500">*</span></label>
      <input id="pendidikan_ayah" name="pendidikan_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan pendidikan ayah" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pekerjaan_ayah" class="sm:w-40 font-medium">Pekerjaan Ayah<span class="text-red-500">*</span></label>
      <input id="pekerjaan_ayah" name="pekerjaan_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan pekerjaan ayah"  />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="penghasilan_ayah" class="sm:w-40 font-medium">Penghasilan Ayah<span class="text-red-500">*</span></label>
      <input id="penghasilan_ayah" name="penghasilan_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan penghasilan ayah"  />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_telp_ayah" class="sm:w-40 font-medium">No Telp Ayah<span class="text-red-500">*</span></label>
      <input id="no_telp_ayah" name="no_telp_ayah" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nomor telepon ayah"  />
    </div>

    <!-- DATA IBU -->
    <h2 class="text-lg font-bold text-[#a9745a] col-span-2 mt-6">DATA IBU</h2>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nama_ibu" class="sm:w-40 font-medium">Nama Ibu<span class="text-red-500">*</span></label>
      <input id="nama_ibu" name="nama_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nama ibu" />
=======
      <label for="tempat_lahir_ayah" class="sm:w-40 font-medium">Tempat Lahir Ayah</label>
      <input id="tempat_lahir_ayah" name="tempat_lahir_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tanggal_lahir_ayah" class="sm:w-40 font-medium">Tanggal Lahir Ayah</label>
      <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pendidikan_ayah" class="sm:w-40 font-medium">Pendidikan Ayah</label>
      <input id="pendidikan_ayah" name="pendidikan_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pekerjaan_ayah" class="sm:w-40 font-medium">Pekerjaan Ayah</label>
      <input id="pekerjaan_ayah" name="pekerjaan_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="penghasilan_ayah" class="sm:w-40 font-medium">Penghasilan Ayah</label>
      <input id="penghasilan_ayah" name="penghasilan_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_telp_ayah" class="sm:w-40 font-medium">No Telp Ayah</label>
      <input id="no_telp_ayah" name="no_telp_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- DATA IBU -->
    <h2 class="text-lg font-bold text-[#ef6c00] col-span-2 mt-6">DATA IBU</h2>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nama_ibu" class="sm:w-40 font-medium">Nama Ibu</label>
      <input id="nama_ibu" name="nama_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>

    
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="nik_ibu" class="sm:w-40 font-medium">NIK Ibu<span class="text-red-500">*</span></label>
=======
      <label for="nik_ibu" class="sm:w-40 font-medium">NIK Ibu</label>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
      <div class="w-full sm:flex-1">
        <input 
          id="nik_ibu" 
          name="nik_ibu" 
          required 
          pattern="[0-9]{16}" 
          oninput="validateInput(this, 16, 'nikIbuError')" 
<<<<<<< HEAD
          class="w-full border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]"
          placeholder="Masukkan NIK ibu"  />
=======
          class="w-full border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94

        <small id="nikIbuError" class="text-red-600 hidden">NIK Ibu harus 16 digit angka.</small>
      </div>
    </div>


    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
<<<<<<< HEAD
      <label for="tempat_lahir_ibu" class="sm:w-40 font-medium">Tempat Lahir Ibu<span class="text-red-500">*</span></label>
      <input id="tempat_lahir_ibu" name="tempat_lahir_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan tempat lahir ibu" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tanggal_lahir_ibu" class="sm:w-40 font-medium">Tanggal Lahir Ibu<span class="text-red-500">*</span></label>
      <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pendidikan_ibu" class="sm:w-40 font-medium">Pendidikan Ibu<span class="text-red-500">*</span></label>
      <input id="pendidikan_ibu" name="pendidikan_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan pendidikan ibu" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pekerjaan_ibu" class="sm:w-40 font-medium">Pekerjaan Ibu<span class="text-red-500">*</span></label>
      <input id="pekerjaan_ibu" name="pekerjaan_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan pekerjaan ibu" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="penghasilan_ibu" class="sm:w-40 font-medium">Penghasilan Ibu<span class="text-red-500">*</span></label>
      <input id="penghasilan_ibu" name="penghasilan_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-2 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan penghasilan ibu" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_telp_ibu" class="sm:w-40 font-medium">No Telp Ibu<span class="text-red-500">*</span></label>
      <input id="no_telp_ibu" name="no_telp_ibu" required class="w-full sm:flex-1 border border-[#a9745a] rounded px-3 py-3 focus:ring-2 focus:ring-[#a9745a]" placeholder="Masukkan nomor telepon ibu"  />
=======
      <label for="tempat_lahir_ibu" class="sm:w-40 font-medium">Tempat Lahir Ibu</label>
      <input id="tempat_lahir_ibu" name="tempat_lahir_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tanggal_lahir_ibu" class="sm:w-40 font-medium">Tanggal Lahir Ibu</label>
      <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pendidikan_ibu" class="sm:w-40 font-medium">Pendidikan Ibu</label>
      <input id="pendidikan_ibu" name="pendidikan_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="pekerjaan_ibu" class="sm:w-40 font-medium">Pekerjaan Ibu</label>
      <input id="pekerjaan_ibu" name="pekerjaan_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="penghasilan_ibu" class="sm:w-40 font-medium">Penghasilan Ibu</label>
      <input id="penghasilan_ibu" name="penghasilan_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_telp_ibu" class="sm:w-40 font-medium">No Telp Ibu</label>
      <input id="no_telp_ibu" name="no_telp_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-3 focus:ring-2 focus:ring-[#ef6c00]" />
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>
   <div class="mb-4">
    <label for="foto_pas" class="block mb-2 text-sm font-medium text-black-700">
        Tambah Foto Siswa <span class="text-gray-500 text-xs">(jpg/jpeg/png, maks 2MB)</span>
    </label>
    <input 
        type="file" 
        name="foto_pas" 
        accept=".jpg,.jpeg,.png" 
        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
               file:rounded-lg file:border-0
               file:text-sm file:font-semibold
<<<<<<< HEAD
               file:bg-[#5c3d15] file:text-white
               hover:file:bg-[#4b320f]
=======
               file:bg-orange-500 file:text-white
               hover:file:bg-orange-600
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
               border rounded p-1"
        required>
    </div>


    <!-- Submit button full width -->
    <div class="md:col-span-2">
<<<<<<< HEAD
      <button type="submit" class=" bg-[#5c3d15] hover:bg-[#4b320f] text-white font-bold py-2 px-6 rounded w-full">Daftar</button>
=======
      <button type="submit" class="bg-[#ef6c00] hover:bg-[#cc5a00] text-white font-bold py-2 px-6 rounded w-full">Daftar</button>
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
    </div>
  </div>


</form>
    </div>
                    <script>
                        function getNamaHariIndonesia(dayIndex) {
                            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            return hari[dayIndex];
                        }

                        const tanggalSekarang = new Date();
                        const namaHari = getNamaHariIndonesia(tanggalSekarang.getDay());
                        const tanggal = tanggalSekarang.toLocaleDateString('id-ID', {
                            day: 'numeric', month: 'long', year: 'numeric'
                        });
                        document.getElementById('tanggalDaftar').textContent = `${namaHari}, ${tanggal}`;

                        const isoFormat = tanggalSekarang.toISOString().split('T')[0];
                        document.getElementById('inputTanggalDaftar').value = isoFormat;
                    </script>
<script>
function validateInput(input, minLength, errorId, maxLength = minLength) {
    const error = document.getElementById(errorId);
    const value = input.value;

    if (/^\d+$/.test(value) && value.length >= minLength && value.length <= maxLength) {
        error.classList.add('hidden');
        input.classList.remove('border-red-500');
    } else {
        error.classList.remove('hidden');
        input.classList.add('border-red-500');
    }
}
</script>


<<<<<<< HEAD
<script>
document.getElementById('spmbForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            valid = false;
            field.classList.add('border-red-500');
        } else {
            field.classList.remove('border-red-500');
        }
    });

    if (!valid) {
        e.preventDefault();
        document.getElementById('alertForm').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>          
=======
                    
>>>>>>> 0fccc80a4f3d4dd70d111b9ece55b892ddd57b94
                    
<br>
<?php include('../includes/spmb_footer.php') ?>
</body>
</html>
</body>
</html>
  