<?php
include 'connection/database.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek username apakah sudah ada
    $cek = $connection->prepare(
        $role === 'siswa' ? "SELECT id FROM siswa WHERE username = ?" : "SELECT id FROM guru WHERE username = ?"
    );
    $cek->bind_param("s", $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $_SESSION['notif'] = 'Username sudah terdaftar.';
        header("Location: register.php");
        exit();
    }

    // Upload foto jika ada
    $foto = 'default.png';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = basename($_FILES['foto']['name']);
        $target_dir = ($role === 'siswa') ? "siswa/uploads/" : "guru/uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto);
    }

    // Jika role adalah siswa
    if ($role === 'siswa') {
        $nama            = $_POST['nama_siswa'];
        $nis             = $_POST['nis'];
        $kelas           = $_POST['kelas'];
        $tempat_lahir    = $_POST['tempat_lahir'];
        $tanggal_lahir   = $_POST['tanggal_lahir'];
        $nama_ayah       = $_POST['nama_ayah'];
        $nama_ibu        = $_POST['nama_ibu'];
        $jenis_kelamin   = $_POST['jenis_kelamin'];
        $alamat          = $_POST['alamat'];
        $no_telepon      = $_POST['no_telepon'];

        if (!preg_match('/^\d{10}$/', $nis)) {
            $_SESSION['notif'] = 'NIS harus 10 digit angka.';
            header("Location: register.php");
            exit();
        }

        // Cek NIS apakah sudah digunakan
        $cekNIS = $connection->prepare("SELECT id FROM siswa WHERE nis = ?");
        $cekNIS->bind_param("s", $nis);
        $cekNIS->execute();
        $cekNIS->store_result();
        if ($cekNIS->num_rows > 0) {
            $_SESSION['notif'] = 'NIS sudah digunakan.';
            header("Location: register.php");
            exit();
        }

        // INSERT siswa
        $stmt = $connection->prepare("INSERT INTO siswa 
            (username, email, nama, nis, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu, jenis_kelamin, alamat, no_telepon, foto, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $username, $email, $nama, $nis, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $jenis_kelamin, $alamat, $no_telepon, $foto, $password);
    } else {
        // Untuk guru
        $nama   = $_POST['nama_guru'];
        $nip    = $_POST['nip'];
        $gelar  = $_POST['gelar'];
        $mapel  = $_POST['mapel'];
        $posisi = $_POST['posisi_staff'];

        if (!preg_match('/^\d{18}$/', $nip)) {
            $_SESSION['notif'] = 'NIP harus 18 digit angka.';
            header("Location: register.php");
            exit();
        }

        $stmt = $connection->prepare("INSERT INTO guru 
            (username, email, password, nama, nip, gelar, mapel, foto, posisi_staff) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $username, $email, $password, $nama, $nip, $gelar, $mapel, $foto, $posisi);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = true;
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['notif'] = "Pendaftaran gagal: " . $stmt->error;
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleRole() {
            const role = document.getElementById("role").value;
            const formSiswa = document.getElementById("formSiswa");
            const formGuru = document.getElementById("formGuru");

            formSiswa.classList.toggle("hidden", role !== "siswa");
            formGuru.classList.toggle("hidden", role !== "guru");

            // Disable fields saat hidden agar tidak mengganggu submit
            Array.from(formSiswa.querySelectorAll("input, select")).forEach(el => el.disabled = (role !== "siswa"));
            Array.from(formGuru.querySelectorAll("input, select")).forEach(el => el.disabled = (role !== "guru"));
        }
        window.onload = toggleRole;
    </script>
</head>
<body class="bg-orange-50 min-h-screen flex items-center justify-center px-4">
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
    <div class="flex justify-center mb-6">
        <img class="w-80 h-22" src="/Tugas-Akhir/assects/images/defaults/logoadmin.png" alt="logo">
    </div>
    <h1 class="text-2xl font-bold text-[#a9745a] mb-6 text-center">Form Registrasi Pengguna</h1>

    <?php if (isset($_SESSION['notif'])): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $_SESSION['notif']; unset($_SESSION['notif']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">Pendaftaran berhasil!</div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="register.php" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="username" placeholder="Username" required class="w-full border rounded px-3 py-2">
            <input type="email" name="email" placeholder="Email" required class="w-full border rounded px-3 py-2">
            <input type="password" name="password" placeholder="Password" required class="w-full border rounded px-3 py-2">
            <select name="role" id="role" onchange="toggleRole()" required class="w-full border rounded px-3 py-2">
                <option value="">-- Pilih Role --</option>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
            </select>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-1">Upload Foto</label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
            </div>
        </div>

            <div id="formSiswa" class="border-t pt-4">
                <h2 class="font-semibold text-orange-600 mb-2">Data Siswa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama dan NIS -->
                    <input type="text" name="nama_siswa" placeholder="Nama Siswa" class="w-full border rounded px-3 py-2" required>
                    <input type="text" name="nis" placeholder="NIS (10 digit)" maxlength="10" pattern="\d{10}" title="NIS harus 10 digit angka" class="w-full border rounded px-3 py-2" required>

                    <!-- Jenis Kelamin -->
                    <select name="jenis_kelamin" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki - Laki">Laki - Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>

                    <!-- Kelas dan Tempat Lahir -->
                    <select name="kelas" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                        <option value="IX">IX</option>
                    </select>

                    <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="w-full border rounded px-3 py-2">
                    <input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2">

                    <!-- Orang Tua -->
                    <input type="text" name="nama_ayah" placeholder="Nama Ayah" class="w-full border rounded px-3 py-2">
                    <input type="text" name="nama_ibu" placeholder="Nama Ibu" class="w-full border rounded px-3 py-2">

                    <!-- Alamat dan No Telepon -->
                    <textarea name="alamat" placeholder="Alamat Lengkap" class="w-full border rounded px-3 py-2 md:col-span-2" rows="3"></textarea>
                    <input type="text" name="no_telepon" placeholder="No Telepon (08xxxxxx)" class="w-full border rounded px-3 py-2 md:col-span-2">
                </div>
            </div>


        <div id="formGuru" class="hidden border-t pt-4">
            <h2 class="font-semibold text-orange-600 mb-2">Data Guru</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="nama_guru" placeholder="Nama Lengkap" class="w-full border rounded px-3 py-2">
                <input type="text" name="nip" placeholder="NIP (18 digit)" maxlength="18" pattern="\d{18}" title="NIP harus terdiri dari 18 digit angka" class="w-full border rounded px-3 py-2">
                <input type="text" name="gelar" placeholder="Gelar" class="w-full border rounded px-3 py-2">
                <input type="text" name="mapel" placeholder="Mapel" class="w-full border rounded px-3 py-2">
                <input type="text" name="posisi_staff" placeholder="Posisi Staff" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <button type="submit" class="bg-[#5c3d15] hover:bg-[#4b320f] text-white px-6 py-2 rounded font-semibold w-full">
            Daftar
        </button>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 font-semibold hover:underline">Login di sini</a></p>
        </div>
    </form>
</div>
</body>
</html>
