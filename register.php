<?php
include 'connection/database.php';

$message = "";

if (isset($_POST['submit'])) {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek username sudah ada?
    if ($role == 'siswa') {
        $cek = $connection->prepare("SELECT id FROM siswa WHERE username = ?");
    } else if ($role == 'guru') {
        $cek = $connection->prepare("SELECT id FROM guru WHERE username = ?");
    }
    $cek->bind_param("s", $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
                        <strong class="font-bold">Gagal!</strong> Username sudah terdaftar, silakan pilih username lain.
                    </div>';
    } else {
        // Upload foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $foto = basename($_FILES['foto']['name']);

            if ($role == 'siswa') {
                $target_dir = "siswa/uploads/";
            } elseif ($role == 'guru') {
                $target_dir = "guru/uploads/";
            }

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $foto_tmp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($foto_tmp, $target_dir . $foto);
        } else {
            $foto = 'default.png';
        }

        if ($role == 'siswa') {
            $nama = $_POST['nama_siswa'];
            $nis = $_POST['nis'];
            $kelas = $_POST['kelas'];
            $tempat_lahir = $_POST['tempat_lahir'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $nama_ayah = $_POST['nama_ayah'];
            $nama_ibu = $_POST['nama_ibu'];

            $stmt = $connection->prepare("INSERT INTO siswa (username, email, nama, nis, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu, foto, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $username, $email, $nama, $nis, $kelas, $tempat_lahir, $tanggal_lahir, $nama_ayah, $nama_ibu, $foto, $password);

        } elseif ($role == 'guru') {
            $nama = $_POST['nama_guru'];
            $nip = $_POST['nip'];
            $gelar = $_POST['gelar'];
            $mapel = $_POST['mapel'];

            $stmt = $connection->prepare("INSERT INTO guru (username, email, password, nama, NIP, gelar, mapel, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $username, $email, $password, $nama, $nip, $gelar, $mapel, $foto);
        }

        if ($stmt->execute()) {
            header("Location: register.php?success=1");
            exit();
        } else {
            $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
                            <strong class="font-bold">Error!</strong> Gagal mendaftarkan akun: ' . $stmt->error . '
                        </div>';
        }
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $message = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center">
                    <strong class="font-bold">Berhasil!</strong> Akun berhasil terdaftar.
                </div>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
</head>
<body>
<section class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-12">
    <div class="flex flex-col items-center w-full max-w-2xl px-6 py-8 mx-auto">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
            <img class="w-80 h-22" src="/Tugas-Akhir/assects/images/defaults/logoadmin.png" alt="logo">
        </a>

        <div class="w-full bg-white rounded-lg shadow p-8 overflow-y-auto">
            <h2 class="text-3xl font-bold text-center mb-6">Form Registrasi Pengguna</h2>

            <?= $message ?>

            <form class="space-y-4" method="POST" enctype="multipart/form-data">
                <div>
                    <label class="block mb-1 font-semibold">Pilih Role</label>
                    <select name="role" id="role" onchange="toggleForm()" required class="w-full p-2 border rounded">
                        <option value="">-- Pilih --</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Username">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Email">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Password">
                </div>

                <!-- Form Guru -->
                <div id="guruForm" class="hidden space-y-4 border-t pt-4">
                    <h3 class="font-bold text-lg text-orange-500">Data Guru</h3>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama_guru" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Nama Guru">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="nip" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="NIP">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Gelar</label>
                        <input type="text" name="gelar" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Gelar (cth: S.Pd)">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Mapel</label>
                        <input type="text" name="mapel" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Mapel">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" name="foto" accept="image/*" class="w-full p-2 border rounded" required>
                    </div>
                </div>

                <!-- Form Siswa -->
                <div id="siswaForm" class="hidden space-y-4 border-t pt-4">
                    <h3 class="font-bold text-lg text-orange-500">Data Siswa</h3>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama_siswa" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Nama Siswa">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="NIS">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" name="kelas" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Kelas">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Tempat Lahir">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="nama_ayah" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Nama Ayah">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="nama_ibu" required class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" placeholder="Nama Ibu">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" name="foto" accept="image/*" class="w-full p-2 border rounded" required>
                    </div>
                </div>

                <button type="submit" name="submit" class="w-full bg-[#ef6c00] text-white py-2 rounded hover:bg-[#ef6c00]">
                    Daftar
                </button>
            </form>

            <hr class="my-6">

            <p class="text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="login.php" class="text-blue-600 hover:text-blue-800 font-semibold">Login di sini</a>
            </p>
        </div>
    </div>
</section>

<script>
function toggleForm() {
    var role = document.getElementById('role').value;
    document.getElementById('guruForm').style.display = (role == 'guru') ? 'block' : 'none';
    document.getElementById('siswaForm').style.display = (role == 'siswa') ? 'block' : 'none';
}
</script>

</body>
</html>
