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
    </div>

    <!-- Jenis Kelamin -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="jenis_kelamin" class="sm:w-40 font-medium">Jenis Kelamin</label>
      <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
        <option>Laki-laki</option>
        <option>Perempuan</option>
      </select>
    </div>

    <!-- NIS -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nis" class="sm:w-40 font-medium">NIS</label>
      <input id="nis" name="nis" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- NIK -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nik" class="sm:w-40 font-medium">NIK</label>
      <input id="nik" name="nik" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Tempat Lahir -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tempat_lahir" class="sm:w-40 font-medium">Tempat Lahir</label>
      <input id="tempat_lahir" name="tempat_lahir" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Tanggal Lahir -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tanggal_lahir" class="sm:w-40 font-medium">Tanggal Lahir</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Agama -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="agama" class="sm:w-40 font-medium">Agama</label>
      <input id="agama" name="agama" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Alamat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-4 md:col-span-2">
      <label for="alamat_tinggal" class="sm:w-40 font-medium pt-2">Alamat Tinggal</label>
      <textarea id="alamat_tinggal" name="alamat_tinggal" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" rows="3"></textarea>
    </div>

    <!-- Tempat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tempat_tinggal" class="sm:w-40 font-medium">Tempat Tinggal</label>
      <select id="tempat_tinggal" name="tempat_tinggal" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
        <option>Bersama Orang Tua</option>
        <option>Wali</option>
        <option>Kos</option>
        <option>Lainnya</option>
      </select>
    </div>

    <!-- Moda Transportasi -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="moda_transportasi" class="sm:w-40 font-medium">Moda Transportasi</label>
      <input id="moda_transportasi" name="moda_transportasi" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Anak ke- -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="anak_keberapa" class="sm:w-40 font-medium">Anak ke-</label>
      <input id="anak_keberapa" type="number" name="anak_keberapa" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Jumlah Saudara Kandung -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="jumlah_saudara_kandung" class="sm:w-40 font-medium">Jumlah Saudara Kandung</label>
      <input id="jumlah_saudara_kandung" type="number" name="jumlah_saudara_kandung" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- No Telp -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_telp" class="sm:w-40 font-medium">No Telp</label>
      <input id="no_telp" name="no_telp" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Penerima KIP -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="penerima_kip" class="sm:w-40 font-medium">Penerima KIP</label>
      <select id="penerima_kip" name="penerima_kip" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
        <option>Ya</option>
        <option>Tidak</option>
      </select>
    </div>

    <!-- No KIP -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="no_kip" class="sm:w-40 font-medium">No KIP</label>
      <input id="no_kip" name="no_kip" class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Tinggi (cm) -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="tinggi_cm" class="sm:w-40 font-medium">Tinggi (cm)</label>
      <input id="tinggi_cm" type="number" name="tinggi_cm" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Berat (kg) -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="berat_kg" class="sm:w-40 font-medium">Berat (kg)</label>
      <input id="berat_kg" type="number" name="berat_kg" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <!-- Jarak Tempat Tinggal -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
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
      <input id="nik_ayah" name="nik_ayah" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
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
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
      <label for="nik_ibu" class="sm:w-40 font-medium">NIK Ibu</label>
      <input id="nik_ibu" name="nik_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
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
      <input id="no_telp_ibu" name="no_telp_ibu" required class="w-full sm:flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]" />
    </div>
<label for="foto_pas">Tambah Foto (jpg/jpeg/png, maks 2MB)</label><br>
    <input type="file" name="foto_pas" accept=".jpg,.jpeg,.png" required><br><br>

    <!-- Submit button full width -->
    <div class="md:col-span-2">
      <button type="submit" class="bg-[#ef6c00] hover:bg-[#cc5a00] text-white font-bold py-2 px-6 rounded w-full">Daftar</button>
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

                    
                    
<br>
<?php include('../includes/spmb_footer.php') ?>
</body>
</html>
</body>
</html>
  