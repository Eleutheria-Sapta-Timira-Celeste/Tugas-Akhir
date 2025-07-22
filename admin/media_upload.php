<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$uploadError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $position = $_POST['position'];
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
            $stmt = $connection->prepare("INSERT INTO media (type, path, position, uploaded_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $type, $relativePath, $position);
            $stmt->execute();
        } else {
            $uploadError = "Upload gagal. Periksa jenis file.";
        }
    } elseif ($type === 'youtube') {
        $youtubeUrl = $_POST['youtube_url'];
        if (!empty($youtubeUrl)) {
            $stmt = $connection->prepare("INSERT INTO media (type, path, position, uploaded_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $type, $youtubeUrl, $position);
            $stmt->execute();
        }
    }
}

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

$mediaQuery = mysqli_query($connection, "SELECT * FROM media ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Media</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
</head>
<body class="bg-gray-100 min-h-screen">

  
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-10 mx-auto">
      <div class="flex flex-col text-center w-full mb-6">
        <h1 class="sm:text-3xl text-2xl font-bold title-font mb-4 text-[#fc941e]">Kelola Media Website</h1>
        <p class="lg:w-2/3 mx-auto text-base leading-relaxed text-gray-600">
          Halaman ini digunakan untuk mengunggah gambar, video, atau link YouTube yang akan ditampilkan di halaman tertentu.
        </p>
      </div>

      <?php if ($uploadError): ?>
        <div class="bg-red-200 text-red-800 px-4 py-2 rounded mb-4 text-center"><?= $uploadError ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md mb-10 max-w-3xl mx-auto space-y-4">
        <div>
          <label class="block font-medium mb-1 text-gray-700">Jenis Media</label>
          <select name="type" id="type" class="w-full border border-gray-300 p-2 rounded" onchange="handleTypeChange()">
            <option value="image">Gambar</option>
            <option value="video">Video</option>
            <option value="youtube">YouTube</option>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1 text-gray-700">Untuk Halaman</label>
          <select name="position" class="w-full border border-gray-300 p-2 rounded" required>
            <option value="index">Index</option>
            <option value="tentang">Tentang</option>
            <option value="pengumuman">Pengumuman</option>
            <option value="informasi_sekolah">Informasi Sekolah</option>
            <option value="hubungi">Hubungi</option>
          </select>
        </div>

        <div id="uploadField">
          <label class="block font-medium mb-1 text-gray-700">Pilih File</label>
          <input type="file" name="media" class="w-full border border-gray-300 p-2 rounded" accept="image/*,video/*">
        </div>

        <div id="youtubeField" class="hidden">
          <label class="block font-medium mb-1 text-gray-700">URL YouTube</label>
          <input type="text" name="youtube_url" class="w-full border border-gray-300 p-2 rounded" placeholder="https://www.youtube.com/embed/...">
        </div>

        <button type="submit" class="bg-[#fc941e] text-white px-6 py-2 rounded hover:bg-[#e57e05]">Upload</button>
      </form>

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
              <div>
                <span class="text-sm text-gray-700 font-semibold"><?= ucfirst($m['type']) ?></span><br>
                <span class="text-xs text-gray-500 italic">Halaman: <?= $m['position'] ?></span>
              </div>
              <a href="?delete=<?= $m['id'] ?>" onclick="return confirm('Yakin hapus media ini?')" class="text-red-600 hover:underline text-sm">Hapus</a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>

 

  <script>
    function handleTypeChange() {
      const type = document.getElementById('type').value;
      document.getElementById('uploadField').classList.toggle('hidden', type === 'youtube');
      document.getElementById('youtubeField').classList.toggle('hidden', type !== 'youtube');
    }
  </script>
</body>
</html>
