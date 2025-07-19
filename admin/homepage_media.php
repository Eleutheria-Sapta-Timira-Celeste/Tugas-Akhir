<?php
include '../connection/database.php';
session_start();

// Cek login & role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data media
$query = "SELECT * FROM homepage_media WHERE id = 1";
$result = mysqli_query($connection, $query);
$media = mysqli_fetch_assoc($result);

// Proses update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST['type'];
    $path = '';

    if ($type === 'youtube') {
        $path = $_POST['youtube_url'];
    } elseif ($type === 'image' || $type === 'video') {
        if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === 0) {
            $uploadDir = '../assets/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filename = time() . '_' . basename($_FILES['media_file']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['media_file']['tmp_name'], $targetPath)) {
                $path = str_replace('../', '', $targetPath); // Simpan relatif
            }
        }
    }

    if (!empty($path)) {
        $update = "UPDATE homepage_media SET type='$type', path='$path' WHERE id=1";
        mysqli_query($connection, $update);
        header("Location: homepage_media.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Media Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Kelola Media Utama Beranda</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                Berhasil diperbarui.
            </div>
        <?php endif; ?>

        <!-- Preview -->
        <div class="mb-6">
            <p class="font-semibold mb-2">Preview:</p>
            <div class="rounded overflow-hidden border">
                <?php if ($media): ?>
                    <?php if ($media['type'] === 'image'): ?>
                        <img src="../<?= $media['path'] ?>" class="w-full h-64 object-cover">
                    <?php elseif ($media['type'] === 'video'): ?>
                        <video class="w-full h-64 object-cover" controls>
                            <source src="admin/uploads/<?= $media['path'] ?>" type="video/mp4">
                        </video>
                    <?php elseif ($media['type'] === 'youtube'): ?>
                        <iframe class="w-full h-64"
                            src="<?= $media['path'] ?>"
                            frameborder="0"
                            allowfullscreen></iframe>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-red-500">Media belum tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
<!-- Form -->
<form method="POST" enctype="multipart/form-data">
    <label class="block mb-2 font-medium">Jenis Media</label>
    <select name="type" id="type" onchange="toggleInput()" class="w-full p-2 border rounded mb-4">
        <option value="image" <?= (isset($media['type']) && $media['type'] === 'image') ? 'selected' : '' ?>>Gambar</option>
        <option value="video" <?= (isset($media['type']) && $media['type'] === 'video') ? 'selected' : '' ?>>Video (MP4)</option>
        <option value="youtube" <?= (isset($media['type']) && $media['type'] === 'youtube') ? 'selected' : '' ?>>YouTube</option>
    </select>


            <div id="file_input" class="mb-4">
                <label class="block mb-2 font-medium">Pilih File (Gambar/Video)</label>
                <input type="file" name="media_file" class="w-full border p-2 rounded">
            </div>

            <div id="youtube_input" class="mb-4 hidden">
                <label class="block mb-2 font-medium">Link YouTube Embed (contoh: https://www.youtube.com/embed/ID)</label>
                <input type="text" name="youtube_url" class="w-full border p-2 rounded" placeholder="Link YouTube">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        function toggleInput() {
            const type = document.getElementById('type').value;
            const fileInput = document.getElementById('file_input');
            const youtubeInput = document.getElementById('youtube_input');

            if (type === 'youtube') {
                fileInput.classList.add('hidden');
                youtubeInput.classList.remove('hidden');
            } else {
                fileInput.classList.remove('hidden');
                youtubeInput.classList.add('hidden');
            }
        }

        // Panggil di awal untuk sesuaikan tampilan
        toggleInput();
    </script>
</body>
</html>
