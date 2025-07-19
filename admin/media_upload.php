<?php
include '../connection/database.php';
session_start();

// Cek login dan role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// === Proses Upload Media ===
$uploadError = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $allowedImage = ['jpg', 'jpeg', 'png'];
    $allowedVideo = ['mp4'];

    if ($type === 'image' || $type === 'video') {
        $file = $_FILES['media'];
        $fileName = basename($file['name']);
        $targetDir = '../admin/uploads/';
        $targetPath = $targetDir . time() . '_' . $fileName;

        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $isValid = false;

        if ($type === 'image' && in_array($fileType, $allowedImage)) $isValid = true;
        if ($type === 'video' && in_array($fileType, $allowedVideo)) $isValid = true;

        if ($isValid && move_uploaded_file($file['tmp_name'], $targetPath)) {
            $relativePath = str_replace('../', '', $targetPath);
            $stmt = $connection->prepare("INSERT INTO media (type, path, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $type, $relativePath);
            $stmt->execute();
        } else {
            $uploadError = "Upload gagal. Periksa jenis file.";
        }

    } elseif ($type === 'youtube') {
        $youtubeUrl = $_POST['youtube_url'];
        if (!empty($youtubeUrl)) {
            $stmt = $connection->prepare("INSERT INTO media (type, path, uploaded_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $type, $youtubeUrl);
            $stmt->execute();
        }
    }
}

// === Proses Hapus Media ===
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = mysqli_query($connection, "SELECT * FROM media WHERE id = $id");
    $media = mysqli_fetch_assoc($query);
    if ($media && ($media['type'] === 'image' || $media['type'] === 'video')) {
        @unlink('../' . $media['path']);
    }
    mysqli_query($connection, "DELETE FROM media WHERE id = $id");
    header("Location: media_upload.php");
    exit();
}

// Ambil semua media
$mediaQuery = mysqli_query($connection, "SELECT * FROM media ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Media</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="max-w-5xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold text-center mb-8">Manajemen Media Website</h1>

    <?php if ($uploadError): ?>
      <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4"><?= $uploadError ?></div>
    <?php endif; ?>

    <!-- Form Upload -->
    <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md mb-10">
      <div class="mb-4">
        <label class="block font-medium mb-1">Jenis Media</label>
        <select name="type" id="type" class="w-full border p-2 rounded" onchange="handleTypeChange()">
          <option value="image">Gambar</option>
          <option value="video">Video</option>
          <option value="youtube">Youtube</option>
        </select>
      </div>

      <div id="uploadField" class="mb-4">
        <label class="block font-medium mb-1">Pilih File</label>
        <input type="file" name="media" class="w-full border p-2 rounded" accept="image/*,video/*">
      </div>

      <div id="youtubeField" class="mb-4 hidden">
        <label class="block font-medium mb-1">URL Youtube</label>
        <input type="text" name="youtube_url" class="w-full border p-2 rounded" placeholder="https://www.youtube.com/embed/...">
      </div>

      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Upload</button>
    </form>

    <!-- Daftar Media -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while ($m = mysqli_fetch_assoc($mediaQuery)): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="h-48 bg-black">
            <?php if ($m['type'] === 'image'): ?>
              <img src="../<?= $m['path'] ?>" alt="Gambar" class="w-full h-full object-cover">
            <?php elseif ($m['type'] === 'video'): ?>
              <video class="w-full h-full object-cover" autoplay muted loop>
                <source src="../<?= $m['path'] ?>" type="video/mp4">
              </video>
            <?php elseif ($m['type'] === 'youtube'): ?>
              <iframe class="w-full h-full" src="<?= $m['path'] ?>" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
          </div>
          <div class="p-4 flex justify-between items-center">
            <span class="text-sm text-gray-600"><?= ucfirst($m['type']) ?></span>
            <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Yakin hapus media ini?')" class="text-red-600 hover:underline">Hapus</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

  </div>

  <script>
    function handleTypeChange() {
      const type = document.getElementById('type').value;
      document.getElementById('uploadField').classList.toggle('hidden', type === 'youtube');
      document.getElementById('youtubeField').classList.toggle('hidden', type !== 'youtube');
    }
  </script>
</body>
</html>
