<?php
include 'connection/database.php';

$message = "";

if (isset($_POST['submit'])) {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Debug POST & FILES
    echo "<h3>DEBUG POST:</h3><pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<h3>DEBUG FILES:</h3><pre>";
    print_r($_FILES);
    echo "</pre>";

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
            $upload_ok = move_uploaded_file($foto_tmp, $target_dir . $foto);

            if (!$upload_ok) {
                echo "<div style='color:red;'>Upload foto gagal ke folder $target_dir !</div>";
            }
        } else {
            echo "<div style='color:red;'>Tidak ada file foto yang dikirim!</div>";
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
            echo "<div style='color:green; font-weight:bold;'>INSERT BERHASIL!</div>";
        } else {
            echo "<div style='color:red; font-weight:bold;'>ERROR INSERT: " . $stmt->error . "</div>";
        }
    }
}
?>

<a href="register-debug.php">↩️ Kembali ke form</a>
