<?php
include 'connection/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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

    // Upload foto
    $foto = 'default.png';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $foto = basename($_FILES['foto']['name']);
        $target_dir = ($role === 'siswa') ? "siswa/uploads/" : "guru/uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto);
    }

    if ($role === 'siswa') {
        $nama = $_POST['nama_siswa'];
        $nis = $_POST['nis'];
        $kelas = $_POST['kelas'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $nama_ayah = $_POST['nama_ayah'];
        $nama_ibu = $_POST['nama_ibu'];

        $cekNIS = $connection->prepare("SELECT id FROM siswa WHERE nis = ?");
        $cekNIS->bind_param("s", $nis);
        $cekNIS->execute();
        $cekNIS->store_result();
        if ($cekNIS->num_rows > 0) {
            $_SESSION['notif'] = 'NIS sudah digunakan.';
            header("Location: register.php");
            exit();
        }

        $stmt = $connection->prepare("INSERT INTO siswa (username, email, nama, nis, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu, foto, password)
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $username, $email, $nama, $nis, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $foto, $password);
    } else {
        $nama = $_POST['nama_guru'];
        $nip = $_POST['nip'];
        $gelar = $_POST['gelar'];
        $mapel = $_POST['mapel'];
        $posisi = $_POST['posisi_staff'];

        $stmt = $connection->prepare("INSERT INTO guru (username, email, password, nama, nip, gelar, mapel, foto, posisi_staff)
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
            document.getElementById("formSiswa").classList.toggle("hidden", role !== "siswa");
            document.getElementById("formGuru").classList.toggle("hidden", role !== "guru");
        }

        window.onload = () => {
            const card = document.getElementById('registerCard');
            card.classList.remove('opacity-0', '-translate-y-10');
            card.classList.add('opacity-100', 'translate-y-0');
        }
    </script>
</head>
<body class="bg-orange-50 min-h-screen flex items-center justify-center p-6 sm:p-10 lg:p-16">

    <div id="registerCard" class="transition-all duration-700 transform opacity-0 -translate-y-10 bg-white w-full max-w-3xl p-8 sm:p-10 md:p-12 rounded-2xl shadow-2xl">
        <div class="flex justify-center mb-6">
            <a href="#" class="flex items-center text-2xl font-semibold text-gray-900">
                <img class="w-80 h-22" src="/Tugas-Akhir/assects/images/defaults/logoadmin.png" alt="logo">
            </a>
        </div>
        <h1 class="text-2xl font-bold text-orange-600 mb-6 text-center">Form Registrasi Pengguna</h1>

        <?php if (isset($_SESSION['notif'])): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $_SESSION['notif']; unset($_SESSION['notif']); ?></div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">Pendaftaran berhasil!</div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="register.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Username</label>
                    <input type="text" name="username" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Password</label>
                    <input type="password" name="password" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Role</label>
                    <select name="role" id="role" onchange="toggleRole()" required class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Role --</option>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-1">Upload Foto</label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- Form Siswa -->
            <div id="formSiswa" class="hidden border-t pt-4">
                <h2 class="font-semibold text-orange-600 mb-4">Data Siswa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold mb-1">Nama Siswa</label><input type="text" name="nama_siswa" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">NIS</label><input type="text" name="nis" class="w-full border rounded px-3 py-2"></div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kelas</label>
                        <select name="kelas" required class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="VII">VII</option>
                            <option value="VIII">VIII</option>
                            <option value="IX">IX</option>
                        </select>
                    </div>
                    <div><label class="block text-sm font-semibold mb-1">Tempat Lahir</label><input type="text" name="tempat_lahir" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Nama Ayah</label><input type="text" name="nama_ayah" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Nama Ibu</label><input type="text" name="nama_ibu" class="w-full border rounded px-3 py-2"></div>
                </div>
            </div>

            <!-- Form Guru -->
            <div id="formGuru" class="hidden border-t pt-4">
                <h2 class="font-semibold text-orange-600 mb-4">Data Guru</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-sm font-semibold mb-1">Nama Lengkap</label><input type="text" name="nama_guru" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">NIP</label><input type="text" name="nip" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Gelar</label><input type="text" name="gelar" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Mapel</label><input type="text" name="mapel" class="w-full border rounded px-3 py-2"></div>
                    <div><label class="block text-sm font-semibold mb-1">Posisi Staff</label><input type="text" name="posisi_staff" class="w-full border rounded px-3 py-2"></div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded font-semibold w-full">
                    Daftar
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 font-semibold hover:underline">Login di sini</a></p>
            </div>
        </form>
    </div>
</body>
</html>
