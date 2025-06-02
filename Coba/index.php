<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_pgri371';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan semua input ke variabel
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nis = $_POST['nis'];
    $nik = $_POST['nik'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $agama = $_POST['agama'];
    $alamat_tinggal = $_POST['alamat_tinggal'];
    $tempat_tinggal = $_POST['tempat_tinggal'];
    $moda_transportasi = $_POST['moda_transportasi'];
    $anak_keberapa = (int)$_POST['anak_keberapa'];
    $jumlah_saudara_kandung = (int)$_POST['jumlah_saudara_kandung'];
    $no_telp = $_POST['no_telp'];
    $penerima_kip = $_POST['penerima_kip'];
    $no_kip = $_POST['no_kip'];
    $tinggi_cm = (int)$_POST['tinggi_cm'];
    $berat_kg = (int)$_POST['berat_kg'];
    $jarak_tempat_tinggal = $_POST['jarak_tempat_tinggal'];
    $nama_ayah = $_POST['nama_ayah'];
    $nik_ayah = $_POST['nik_ayah'];
    $tempat_lahir_ayah = $_POST['tempat_lahir_ayah'];
    $tanggal_lahir_ayah = $_POST['tanggal_lahir_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
    $penghasilan_ayah = (float)$_POST['penghasilan_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $nik_ibu = $_POST['nik_ibu'];
    $tempat_lahir_ibu = $_POST['tempat_lahir_ibu'];
    $tanggal_lahir_ibu = $_POST['tanggal_lahir_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $penghasilan_ibu = (float)$_POST['penghasilan_ibu'];

    // **Upload file pas_foto**
 $foto_pas = null;
    if (isset($_FILES['foto_pas']) && $_FILES['foto_pas']['error'] == UPLOAD_ERR_OK) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $file_tmp = $_FILES['foto_pas']['tmp_name'];
        $file_name = basename($_FILES['foto_pas']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $_FILES['foto_pas']['size'];

        if (in_array($file_ext, $allowed_ext) && $file_size <= 2 * 1024 * 1024) {
            $upload_dir = "uploads_/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $foto_pas = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            $target_file = $upload_dir . $foto_pas;

            $mime_type = mime_content_type($file_tmp);
            if (strpos($mime_type, "image/") === 0) {
                if (!move_uploaded_file($file_tmp, $target_file)) {
                    $foto_pas = null;
                }
            } else {
                $foto_pas = null;
            }
        }
    }

    if (!$foto_pas) $foto_pas = 'default.jpg'; // pastikan tidak null

    // Buat prepared statement dengan query SQL murni
  $stmt = $conn->prepare("INSERT INTO spmb_siswa (
  nama_lengkap, jenis_kelamin, nis, nik, tempat_lahir, tanggal_lahir, agama, alamat_tinggal,
  tempat_tinggal, moda_transportasi, anak_keberapa, jumlah_saudara_kandung, no_telp,
  penerima_kip, no_kip, tinggi_cm, berat_kg, jarak_tempat_tinggal,
  nama_ayah, nik_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah,
  nama_ibu, nik_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu,
  foto_pas
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
  "ssssssssssiisssiissssssssdsssssds",
  $nama_lengkap,
  $jenis_kelamin,
  $nis,
  $nik,
  $tempat_lahir,
  $tanggal_lahir,
  $agama,
  $alamat_tinggal,
  $tempat_tinggal,
  $moda_transportasi,
  $anak_keberapa,
  $jumlah_saudara_kandung,
  $no_telp,
  $penerima_kip,
  $no_kip,
  $tinggi_cm,
  $berat_kg,
  $jarak_tempat_tinggal,
  $nama_ayah,
  $nik_ayah,
  $tempat_lahir_ayah,
  $tanggal_lahir_ayah,
  $pendidikan_ayah,
  $pekerjaan_ayah,
  $penghasilan_ayah,
  $nama_ibu,
  $nik_ibu,
  $tempat_lahir_ibu,
  $tanggal_lahir_ibu,
  $pendidikan_ibu,
  $pekerjaan_ibu,
  $penghasilan_ibu,
  $foto_pas
);




    if ($stmt->execute()) {
        echo "<p class='text-green-600 font-semibold'>Pendaftaran berhasil disimpan.</p>";
    } else {
        echo "<p class='text-red-600 font-semibold'>Error: " . htmlspecialchars($stmt->error) . "</p>";
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
    Tanggal Mendaftar : <span id="tanggalDaftar"></span>
</p>
<form method="post" enctype="multipart/form-data" class="space-y-6 text-sm">
    <!-- DATA SISWA -->
    <h2 class="text-lg font-bold text-[#ef6c00]">Data Siswa</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-center gap-4"><label class="w-40">Nama Lengkap</label><input name="nama_lengkap" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Jenis Kelamin</label><select name="jenis_kelamin" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"><option>Laki-laki</option><option>Perempuan</option></select></div>
        <div class="flex items-center gap-4"><label class="w-40">NIS</label><input name="nis" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">NIK</label><input name="nik" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tempat Lahir</label><input name="tempat_lahir" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tanggal Lahir</label><input type="date" name="tanggal_lahir" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Agama</label><input name="agama" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-start gap-4 col-span-2"><label class="w-40 pt-2">Alamat Tinggal</label><textarea name="alamat_tinggal" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></textarea></div>
        <div class="flex items-center gap-4"><label class="w-40">Tempat Tinggal</label><select name="tempat_tinggal" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"><option>Bersama Orang Tua</option><option>Wali</option><option>Kos</option><option>Lainnya</option></select></div>
        <div class="flex items-center gap-4"><label class="w-40">Moda Transportasi</label><input name="moda_transportasi" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Anak ke-</label><input type="number" name="anak_keberapa" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Jumlah Saudara Kandung</label><input type="number" name="jumlah_saudara_kandung" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">No Telp</label><input name="no_telp" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Penerima KIP</label><select name="penerima_kip" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"><option>Ya</option><option>Tidak</option></select></div>
        <div class="flex items-center gap-4"><label class="w-40">No KIP</label><input name="no_kip" class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tinggi (cm)</label><input type="number" name="tinggi_cm" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Berat (kg)</label><input type="number" name="berat_kg" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Jarak Tempat Tinggal</label><input name="jarak_tempat_tinggal" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>

        <!-- DATA AYAH -->
        <h2 class="text-lg font-bold text-[#ef6c00] col-span-2 mt-6">Data Ayah</h2>
        <div class="flex items-center gap-4"><label class="w-40">Nama Ayah</label><input name="nama_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">NIK Ayah</label><input name="nik_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tempat Lahir Ayah</label><input name="tempat_lahir_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tanggal Lahir Ayah</label><input type="date" name="tanggal_lahir_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Pendidikan Ayah</label><input name="pendidikan_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Pekerjaan Ayah</label><input name="pekerjaan_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Penghasilan Ayah</label><input type="number" step="0.01" name="penghasilan_ayah" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>

        <!-- DATA IBU -->
        <h2 class="text-lg font-bold text-[#ef6c00] col-span-2 mt-6">Data Ibu</h2>
        <div class="flex items-center gap-4"><label class="w-40">Nama Ibu</label><input name="nama_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">NIK Ibu</label><input name="nik_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tempat Lahir Ibu</label><input name="tempat_lahir_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Tanggal Lahir Ibu</label><input type="date" name="tanggal_lahir_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Pendidikan Ibu</label><input name="pendidikan_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Pekerjaan Ibu</label><input name="pekerjaan_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>
        <div class="flex items-center gap-4"><label class="w-40">Penghasilan Ibu</label><input type="number" step="0.01" name="penghasilan_ibu" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]"></div>

        <!-- Upload Foto -->
        <div class="flex items-center gap-4 col-span-2">
            <label class="w-40">Upload Pas Foto</label>
            <input type="file" name="foto_pas" accept="image/*" required class="flex-1 border border-[#ef6c00] rounded px-3 py-2 focus:ring-2 focus:ring-[#ef6c00]">
        </div>

        <!-- Tombol Submit -->
        <div class="col-span-2 text-center">
            <button type="submit" class="bg-[#ef6c00] hover:bg-[#cc5a00] text-white px-6 py-2 rounded font-semibold transition duration-300">Kirim Pendaftaran</button>
        </div>
    </div>
</form>
</div>

<!-- Tanggal otomatis -->
<script>
  const tanggal = new Date().toLocaleDateString('id-ID', {
    day: 'numeric', month: 'long', year: 'numeric'
  });
  document.getElementById('tanggalDaftar').innerText = tanggal;
</script>

<!-- Style tambahan Tailwind -->
<style>
  .form-input {
    @apply border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00];
  }
</style>
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
  