<?php
include 'koneksi.php';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nip      = $_POST['nip'];
    $nama     = $_POST['nama'];
    $mapel    = $_POST['mapel'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // pakai BCRYPT supaya aman

     // Upload foto jika ada
    $foto_name = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $foto_name = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }

    // Cek apakah username sudah ada
    $cek = $conn->prepare("SELECT * FROM guru WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah terdaftar.";
    } else {
        $stmt = $conn->prepare("INSERT INTO guru (username, nip, nama, mapel, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $nip, $nama, $mapel, $password);

        if ($stmt->execute()) {
            $success = "Register berhasil. Silakan login.";
        } else {
            $error = "Register gagal: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center py-10">
<div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-bold text-center mb-6">Register Guru</h2>

    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block">Username</label>
            <input type="text" name="username" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block">NIP</label>
            <input type="text" name="nip" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block">Nama</label>
            <input type="text" name="nama" required class="w-full px-3 py-2 border rounded">
        </div>

         <div>
            <label class="block">Gelar</label>
            <input type="text" name="gelar" required class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block">Mata Pelajaran</label>
            <input type="text" name="mapel" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded">
        </div>

        <div><label class="block">Foto</label><input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 border rounded"></div>

        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
            Register
        </button>
    </form>
    <p class="text-center mt-4 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-500 underline">Login</a></p>
</div>
</body>
</html>    