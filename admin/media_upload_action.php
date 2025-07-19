<?php
include '../connection/database.php';
session_start();

// Cek apakah user sudah login dan role-nya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $type = $_POST['type'] ?? '';
    $youtube_id = $_POST['youtube_link'] ?? '';
    $upload_path = '';
    $error = '';

    // Validasi tipe
    if (!in_array($type, ['image', 'video', 'youtube'])) {
        die("Tipe media tidak valid.");
    }

    // Untuk media YouTube (hanya ID video)
    if ($type === 'youtube') {
        if (empty($youtube_id)) {
            die("Masukkan ID video YouTube.");
        }
        $upload_path = $youtube_id;
    }

    // Untuk media gambar/video (upload file)
    if ($type === 'image' || $type === 'video') {
        if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] !== 0) {
            die("Upload file gagal atau tidak ada file diunggah.");
        }

        $file = $_FILES['media_file'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '_', basename($file['name']));
        $target_dir = 'uploads/';
        $target_file = $target_dir . $file_name;

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $upload_path = $target_file;
        } else {
            die("Gagal menyimpan file ke server.");
        }
    }

    // Simpan ke database (insert baru atau update)
    if (!empty($id)) {
        // Update
        $stmt = mysqli_prepare($connection, "UPDATE media SET type = ?, path = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $type, $upload_path, $id);
    } else {
        // Insert
        $stmt = mysqli_prepare($connection, "INSERT INTO media (type, path) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $type, $upload_path);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: media_upload.php" . (!empty($id) ? "?id=$id&success=1" : "?success=1"));
        exit();
    } else {
        die("Gagal menyimpan ke database.");
    }
} else {
    die("Akses tidak sah.");
}
