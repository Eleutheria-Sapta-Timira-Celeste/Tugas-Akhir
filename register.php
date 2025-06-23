<?php
include 'connection/database.php';
session_start();

$success = '';
$error = '';

if (isset($_POST['submit'])) {
    $role = $_POST['role'];

    // Cek role dan ambil field
    if ($role == 'siswa') {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $kelas = $_POST['kelas'];
        $tempat_lahir = $_POST['tempat_lahir'];
        $tanggal_lhir = $_POST['tanggal_lhir'];
        $nama_ayah = $_POST['nama_ayah'];
        $nama_ibu = $_POST['nama_ibu'];
        $foto = 'default.png'; // default foto dulu

        $query = "INSERT INTO siswa (email, username, nama, nis, kelas, tempat_lahir, tanggal_lhir, nama_ayah, nama_ibu, foto) 
                  VALUES ('$email', '$username', '$nama', '$nis', '$kelas', '$tempat_lahir', '$tanggal_lhir', '$nama_ayah', '$nama_ibu', '$foto')";

    } elseif ($role == 'guru') {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $gelar = $_POST['gelar'];
        $mapel = $_POST['mapel'];
        $foto = 'default.png';

        $query = "INSERT INTO guru (email, username, password, nama, nip, gelar, mapel, foto) 
                  VALUES ('$email', '$username', '$password', '$nama', '$nip', '$gelar', '$mapel', '$foto')";

    } elseif ($role == 'admin') {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nama_admin = $_POST['nama_admin'];
        $logo = 'default.png';
        $created_at = date('Y-m-d H:i:s');

        $query = "INSERT INTO admin (email, username, password, nama_admin, logo, created_at) 
                  VALUES ('$email', '$username', '$password', '$nama_admin', '$logo', '$created_at')";
    }

    if (mysqli_query($mysqli, $query)) {
        $success = "Pendaftaran berhasil untuk $role!";
    } else {
        $error = "Error: " . mysqli_error($mysqli);
    }
}
?>

<!-- HTML FORM -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Multi-Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    function showForm() {
        var role = document.getElementById('role').value;
        document.getElementById('form-siswa').style.display = 'none';
        document.getElementById('form-guru').style.display = 'none';
        document.getElementById('form-admin').style.display = 'none';

        if (role === 'siswa') document.getElementById('form-siswa').style.display = 'block';
        if (role === 'guru') document.getElementById('form-guru').style.display = 'block';
        if (role === 'admin') document.getElementById('form-admin').style.display = 'block';
    }
    </script>
</head>
<body class="p-10 bg-gray-100">
    <h2 class="text-xl mb-4">Register Akun</h2>

    <?php if ($success) echo "<p class='text-green-500'>$success</p>"; ?>
    <?php if ($error) echo "<p class='text-red-500'>$error</p>"; ?>

    <form method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        <label>Pilih Role:
            <select name="role" id="role" onchange="showForm()" class="border p-2 w-full">
                <option value="">-- Pilih Role --</option>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
                <option value="admin">Admin</option>
            </select>
        </label>

        <!-- Form Siswa -->
        <div id="form-siswa" style="display:none;">
            <input type="text" name="email" placeholder="Email" class="border p-2 w-full" required>
            <input type="text" name="username" placeholder="Username" class="border p-2 w-full" required>
            <input type="text" name="nama" placeholder="Nama" class="border p-2 w-full" required>
            <input type="text" name="nis" placeholder="NIS" class="border p-2 w-full" required>
            <input type="text" name="kelas" placeholder="Kelas" class="border p-2 w-full" required>
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="border p-2 w-full" required>
            <input type="date" name="tanggal_lhir" class="border p-2 w-full" required>
            <input type="text" name="nama_ayah" placeholder="Nama Ayah" class="border p-2 w-full" required>
            <input type="text" name="nama_ibu" placeholder="Nama Ibu" class="border p-2 w-full" required>
        </div>

        <!-- Form Guru -->
        <div id="form-guru" style="display:none;">
            <input type="text" name="email" placeholder="Email" class="border p-2 w-full" required>
            <input type="text" name="username" placeholder="Username" class="border p-2 w-full" required>
            <input type="password" name="password" placeholder="Password" class="border p-2 w-full" required>
            <input type="text" name="nama" placeholder="Nama" class="border p-2 w-full" required>
            <input type="text" name="nip" placeholder="NIP" class="border p-2 w-full" required>
            <input type="text" name="gelar" placeholder="Gelar" class="border p-2 w-full" required>
            <input type="text" name="mapel" placeholder="Mapel" class="border p-2 w-full" required>
        </div>

        <!-- Form Admin -->
        <div id="form-admin" style="display:none;">
            <input type="text" name="email" placeholder="Email" class="border p-2 w-full" required>
            <input type="text" name="username" placeholder="Username" class="border p-2 w-full" required>
            <input type="password" name="password" placeholder="Password" class="border p-2 w-full" required>
            <input type="text" name="nama_admin" placeholder="Nama Admin" class="border p-2 w-full" required>
        </div>

        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Daftar</button>
    </form>
</body>
</html>
