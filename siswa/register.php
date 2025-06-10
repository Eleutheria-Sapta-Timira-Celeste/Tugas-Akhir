<?php
include 'koneksi.php';
$success = '';
$error = '';

// Proses form register
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $kelas = $_POST['kelas'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];

    // Upload foto jika ada
    $foto_name = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // buat folder jika belum ada
        }
        $foto_name = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }

    // Cek apakah NIS sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "NIS sudah terdaftar.";
    } else {
        $query = "INSERT INTO siswa 
            (nis, nama, password, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu, foto) 
            VALUES 
            ('$nis', '$nama', '$password', '$kelas', '$tempat_lahir', '$tanggal_lahir', '$nama_ayah', '$nama_ibu', '$foto_name')";
        
        if (mysqli_query($conn, $query)) {
            $success = "Registrasi berhasil. Silakan login.";
        } else {
            $error = "Registrasi gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center py-10">
<div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-center mb-6">Register Siswa</h2>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div><label class="block">NIS</label><input type="text" name="nis" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Nama</label><input type="text" name="nama" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Password</label><input type="password" name="password" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Kelas</label><input type="text" name="kelas" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Tempat Lahir</label><input type="text" name="tempat_lahir" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Tanggal Lahir</label><input type="date" name="tanggal_lahir" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Nama Ayah</label><input type="text" name="nama_ayah" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Nama Ibu</label><input type="text" name="nama_ibu" required class="w-full px-3 py-2 border rounded"></div>
        <div><label class="block">Foto</label><input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border rounded"></div>

        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
            Register
        </button>
    </form>
    <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-500 underline">Login</a></p>
</div>
</body>
</html>
