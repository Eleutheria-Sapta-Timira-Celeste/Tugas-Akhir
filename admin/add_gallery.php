<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['newImagesToAlbum'])) {
        $albumName = $_POST['albumName'];
        $albumId = $_POST['albumId'];
        $countfiles = count($_FILES['file-upload-modified']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            $fileName = $_FILES['file-upload-modified']['name'][$i];
            $fileTmp = $_FILES['file-upload-modified']['tmp_name'][$i];
            $targetPath = '../assects/images/gallery/' . basename($fileName);
            $dbPath = 'assects/images/gallery/' . basename($fileName);

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $stmt = $connectionobj->prepare("INSERT INTO gallery_images (album, image_url) VALUES (?, ?)");
                $stmt->bind_param("ss", $albumName, $dbPath);
                $stmt->execute();
                $stmt->close();
            }
        }

        echo "<script>alert('Gambar berhasil ditambahkan'); window.location='index.php?page=add_gallery';</script>";
        exit;
    }

    if (isset($_POST['submit_new_album'])) {
        $album_name = $_POST["album_name"];
        $stmt = $connectionobj->prepare("INSERT INTO gallery_album (album_name) VALUES (?)");
        $stmt->bind_param("s", $album_name);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Album berhasil dibuat'); window.location='index.php?page=add_gallery';</script>";
        exit;
    }

    if (isset($_POST['deleteAlbum'])) {
        $album_Id = $_POST['album_Id'];
        mysqli_query($connectionobj, "DELETE FROM gallery_album WHERE id = $album_Id");
        echo "<script>window.location='index.php?page=add_gallery';</script>";
        exit;
    }

    if (isset($_POST['deleteImage'])) {
        $imageId = $_POST['imageId'];
        mysqli_query($connectionobj, "DELETE FROM gallery_images WHERE id = $imageId");
        echo "<script>window.location='index.php?page=add_gallery';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Galeri Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-coffee { background-color: #a9745a; }
        .text-coffee { color: #a9745a; }
        .hover\:bg-coffee-dark:hover { background-color: #8b5e3c; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <section class="p-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-coffee">Manajemen Galeri Sekolah</h1>
                <p class="text-gray-600 mt-2">Tambahkan album dan gambar kegiatan sekolah.</p>
                <button onclick="toggleModal('modalTambahAlbum')" class="mt-4 px-4 py-2 bg-coffee text-white rounded hover:bg-coffee-dark">Tambah Album Baru</button>
            </div>

            <!-- Modal Tambah Album -->
            <div id="modalTambahAlbum" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                    <h2 class="text-lg font-semibold text-coffee mb-4">Buat Album Baru</h2>
                    <form method="POST">
                        <input type="text" name="album_name" required placeholder="Nama Album" class="w-full border p-2 rounded mb-4">
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="toggleModal('modalTambahAlbum')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                            <button type="submit" name="submit_new_album" class="px-4 py-2 bg-coffee text-white rounded hover:bg-coffee-dark">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Album List -->
            <div class="space-y-8 mt-10">
                <?php
                $albums = mysqli_query($connectionobj, "SELECT * FROM gallery_album");
                while ($album = mysqli_fetch_assoc($albums)):
                    $albumId = $album['id'];
                    $albumName = $album['album_name'];
                ?>
                <div class="bg-white p-4 shadow rounded border">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-coffee"><?php echo htmlspecialchars($albumName); ?></h2>
                        <div class="flex gap-2">
                            <button onclick="toggleModal('modalUpload<?php echo $albumId; ?>')" class="px-3 py-1 border border-[#4b320f] text-coffee rounded hover:bg-[#5c3d15] hover:text-white">Tambah Gambar</button>
                            <form method="POST" onsubmit="return confirm('Yakin hapus album ini?')">
                                <input type="hidden" name="album_Id" value="<?= $albumId ?>">
                                <button name="deleteAlbum" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>

                    <!-- Gambar per Album -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php
                        $stmt = $connectionobj->prepare("SELECT * FROM gallery_images WHERE album = ? ORDER BY id DESC");
                        $stmt->bind_param("s", $albumName);
                        $stmt->execute();
                        $images = $stmt->get_result();
                        while ($img = $images->fetch_assoc()):
                        ?>
                        <div class="relative">
                            <img src="../<?= $img['image_url']; ?>" class="w-full h-40 object-cover rounded">
                            <form method="POST" onsubmit="return confirm('Yakin hapus gambar ini?')" class="absolute top-1 right-1">
                                <input type="hidden" name="imageId" value="<?= $img['id'] ?>">
                                <button name="deleteImage" class="text-white bg-black bg-opacity-60 rounded-full px-2">×</button>
                            </form>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Modal Upload Gambar -->
                <div id="modalUpload<?php echo $albumId; ?>" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                        <h2 class="text-lg font-semibold text-coffee mb-4">Tambah Gambar ke "<?= htmlspecialchars($albumName); ?>"</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="albumName" value="<?= htmlspecialchars($albumName); ?>">
                            <input type="hidden" name="albumId" value="<?= $albumId; ?>">
                            <input type="file" name="file-upload-modified[]" accept="image/*" multiple required class="w-full border p-2 rounded mb-4">
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="toggleModal('modalUpload<?php echo $albumId; ?>')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                                <button type="submit" name="newImagesToAlbum" class="px-4 py-2 bg-[#5c3d15] text-white rounded hover:bg-[#4b320f]">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
</body>
</html>
