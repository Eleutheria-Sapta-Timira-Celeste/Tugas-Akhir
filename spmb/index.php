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
        <h1 class="hide_after_submission text-x text-justify text-white capitalize dark:text-[#333333]">Pastikan untuk mengisi formulir pendaftaran Anda dengan hati-hati.
                 Periksa semua detail, seperti informasi pribadi dan data akademik Anda, 
                 agar tidak terjadi kesalahan. Ketelitian Anda akan membantu memperlancar proses pendaftaran. 
                 Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi bagian pendaftaran untuk mendapatkan bantuan.</h1> <br>
         <p class="text-right text-sm text-gray-600 mb-4">
         Tanggal Mendaftar : <span id="tanggalDaftar"></span>
        </p>
        <form method="post" enctype="multipart/form-data" class="grid grid-cols-2 gap-4 text-sm">
            <!-- Data Siswa -->
            <h2 class="col-span-2 font-bold text-lg text-[#ef6c00]">Data Siswa</h2>
            <input name="nama_lengkap" placeholder="Nama Lengkap" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <select name="jenis_kelamin" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <input name="nis" placeholder="NIS" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="nik" placeholder="NIK" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="tempat_lahir" placeholder="Tempat Lahir" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="date" name="tanggal_lahir" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="agama" placeholder="Agama" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <textarea name="alamat_tinggal" placeholder="Alamat Tinggal" class="border border-[#ef6c00] rounded px-3 py-2 w-full col-span-2 focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required></textarea>
            <select name="tempat_tinggal" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
                <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                <option value="Wali">Wali</option>
                <option value="Kos">Kos</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <input name="moda_transportasi" placeholder="Moda Transportasi" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="number" name="anak_keberapa" placeholder="Anak ke-" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="number" name="jumlah_saudara_kandung" placeholder="Jumlah Saudara Kandung" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="no_telp" placeholder="No Telp" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <select name="penerima_kip" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
            </select>
            <input name="no_kip" placeholder="No KIP" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]">
            <input type="number" name="tinggi_cm" placeholder="Tinggi (cm)" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="number" name="berat_kg" placeholder="Berat (kg)" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="jarak_tempat_tinggal" placeholder="Jarak Tempat Tinggal" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>

            <!-- Data Ayah -->
            <h2 class="col-span-2 font-bold text-lg mt-6 text-[#ef6c00]">Data Ayah</h2>
            <input name="nama_ayah" placeholder="Nama Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="nik_ayah" placeholder="NIK Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="tempat_lahir_ayah" placeholder="Tempat Lahir Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="date" name="tanggal_lahir_ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="pendidikan_ayah" placeholder="Pendidikan Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="number" step="0.01" name="penghasilan_ayah" placeholder="Penghasilan Ayah" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>

            <!-- Data Ibu -->
            <h2 class="col-span-2 font-bold text-lg mt-6 text-[#ef6c00]">Data Ibu</h2>
            <input name="nama_ibu" placeholder="Nama Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="nik_ibu" placeholder="NIK Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="tempat_lahir_ibu" placeholder="Tempat Lahir Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="date" name="tanggal_lahir_ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="pendidikan_ibu" placeholder="Pendidikan Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <input type="number" step="0.01" name="penghasilan_ibu" placeholder="Penghasilan Ibu" class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]" required>
            <h3 class="col-span-2 font-bold text-lg mt-6 text-[#ef6c00]">Upload Pas Foto</h3>
             <label class="block">
            <input type="file" name="foto_pas" accept="image/*" required class="border border-[#ef6c00] rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#ef6c00]">
            </label>
            <button type="submit" class="col-span-2 mt-4 bg-[#ef6c00] hover:bg-[#cc5a00] text-white py-2 rounded font-semibold transition duration-300">Kirim Pendaftaran</button>
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
  