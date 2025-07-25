<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle form POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['newImagesToAlbum'])) {
        $albumName = $_POST['albumName'];
        $albumId = $_POST['albumId'];
        $isSucess = false;
        // Count total files
        $countfiles = count($_FILES['file-upload-modified']['name']);
    
        // Looping all files
        for ($i = 0; $i < $countfiles; $i++) {
            $fileUploadName = $_FILES['file-upload-modified']['name'][$i];
            $fileUploadTmp = $_FILES['file-upload-modified']['tmp_name'][$i];
    
            $targetDirectory = '../assects/images/gallery/';
            $targetFilePath = "../assects/images/gallery/" . basename($fileUploadName);
            $sqlfileurl = "";
    
            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $isSucess = true;
                $sqlfileurl = "assects/images/gallery/" . basename($fileUploadName);
    
                if ($connectionobj->connect_error) {
                    die("Connection failed: " . $connectionobj->connect_error);
                }
    
                // Insert data into the gallery_images table
                $sql = "INSERT INTO gallery_images (album, image_url) VALUES (?, ?)";
                $stmt = $connectionobj->prepare($sql);
                $stmt->bind_param("ss", $albumName, $sqlfileurl);
    
                if ($stmt->execute()) {
                    
                } else {
                    echo "Error: " . $stmt->error;
                }
    
                $stmt->close();
            } else {
                echo "Failed to move file.";
            }
        }
        echo '<script>alert("New images added successfully");
        window.location.replace("index.php?page=add_gallery");
        
        </script>';
        $connectionobj->close();
    }
    




    if (isset($_POST['deleteAlbum'])) {
        $album_Id = $_POST['album_Id'];
        mysqli_query($connectionobj, "DELETE FROM `gallery_album` WHERE id = $album_Id;");
        echo '<script>window.location.replace("index.php?page=add_gallery");</script>';
        exit;
    }

    if (isset($_POST['deleteImage'])) {
        $imageId = $_POST['imageId'];
        mysqli_query($connectionobj, "DELETE FROM `gallery_images` WHERE id = $imageId;");
        echo '<script>window.location.replace("index.php?page=add_gallery");</script>';
        exit;
    }

    if (isset($_POST["submit_new_album"])) {
        $album_name = $_POST["album_name"];
        $stmt = $connectionobj->prepare("INSERT INTO gallery_album (album_name) VALUES (?)");
        $stmt->bind_param("s", $album_name);

        if ($stmt->execute()) {
            echo '<script>alert("Album berhasil dibuat"); window.location.replace("index.php?page=add_gallery");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    if (isset($_POST['downloadZip'])) {
        $albumName = $_POST['albumName'];
        $zip = new ZipArchive();
        $zipFile = tempnam("/tmp", "zip");

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $stmt = $connectionobj->prepare("SELECT image_url FROM gallery_images WHERE album = ?");
            $stmt->bind_param("s", $albumName);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $filePath = '../' . $row['image_url'];
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }

            $zip->close();

            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=album_" . preg_replace("/\s+|[^\w]/", "_", $albumName) . ".zip");
            header("Content-Length: " . filesize($zipFile));
            readfile($zipFile);
            unlink($zipFile);
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Sekolah</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="../css/animation.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f3f0;
        }
        .bg-coffee {
            background-color: #a9745a;
        }
        .text-coffee {
            color: #a9745a;
        }
        .border-coffee {
            border-color: #a9745a;
        }
        .hover\:bg-coffee-dark:hover {
            background-color: #8b5e3c;
        }
    </style>
</head>

<body class="text-gray-800">
    <section class="py-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-coffee">Manajemen Galeri Sekolah</h1>
                <p class="text-sm text-gray-600 mt-2 max-w-2xl mx-auto">
                    Silakan buat album dan unggah foto kegiatan terbaru untuk ditampilkan di website sekolah.
                </p>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                    class="mt-6 px-6 py-2 bg-coffee text-white rounded hover:bg-coffee-dark transition">Tambah Album Baru</button>
            </div>

            <!-- Modal Buat Album Baru -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <h3 class="text-lg font-semibold text-coffee">Buat Album Baru</h3>
                        <button data-modal-hide="authentication-modal" class="text-gray-500 hover:text-red-500">&times;</button>
                    </div>
                    <form action="" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Album</label>
                            <input type="text" name="album_name" class="w-full border border-coffee rounded px-3 py-2" placeholder="Contoh: Upacara 17 Agustus" required>
                        </div>
                        <button type="submit" name="submit_new_album"
                            class="w-full bg-coffee text-white py-2 rounded hover:bg-coffee-dark">Simpan Album</button>
                    </form>
                </div>
            </div>

            <!-- Album List -->
            <div class="mt-10 space-y-6">
                <?php
                $fetch_all_album = "SELECT * FROM `gallery_album`;";
                $albums = mysqli_query($connection, $fetch_all_album);
                if (mysqli_num_rows($albums) > 0):
                    while ($row = mysqli_fetch_assoc($albums)):
                        $albumId = $row["id"];
                        $album_name = $row["album_name"];
                ?>
                <div class="border border-coffee rounded-lg bg-white shadow p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-xl font-semibold text-coffee"><?php echo htmlspecialchars($album_name); ?></h2>
                        <div class="flex space-x-2">
                            <button data-modal-toggle="addImageModal<?php echo $albumId; ?>" class="text-sm bg-white text-coffee px-3 py-1 rounded border border-coffee hover:bg-coffee hover:text-white transition">Tambah Gambar</button>
                            <form method="POST" onsubmit="return confirm('Yakin ingin menghapus album ini?')">
                                <input type="hidden" name="album_Id" value="<?php echo $albumId; ?>">
                                <button type="submit" name="deleteAlbum" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus Album</button>
                            </form>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <?php
                        $stmt_images = mysqli_prepare($connection, "SELECT * FROM `gallery_images` WHERE album = ? ORDER BY id DESC");
                        mysqli_stmt_bind_param($stmt_images, "s", $album_name);
                        mysqli_stmt_execute($stmt_images);
                        $result_images = mysqli_stmt_get_result($stmt_images);
                        while ($imagerow = mysqli_fetch_assoc($result_images)):
                        ?>
                        <div class="relative">
                            <img src="../<?php echo $imagerow['image_url']; ?>" class="w-full h-40 object-cover rounded shadow">
                            <form method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?')" class="absolute top-1 right-1">
                                <input type="hidden" name="imageId" value="<?php echo $imagerow['id']; ?>">
                                <button name="deleteImage" class="text-white bg-black bg-opacity-60 rounded-full p-1 hover:bg-opacity-80">
                                    &times;
                                </button>
                            </form>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

           <!-- Add Images to album model -->

        <div id="addImagestoAlbum' .
                    $albumId .
                    '" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Pilih Gambar Untuk ' . $album_name . '
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="addImagestoAlbum' .
                    $albumId .
                    '">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" enctype="multipart/form-data" action="" method="POST">
                        <div>
                            <label for="imagesSchoolMemories"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Gambar</label>
                                <input name="file-upload-modified[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" accept="image/*" required multiple>


                                <input name="albumName" class="hidden block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="' . $album_name . '" type="text">
                                <input name="albumId" class="hidden block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="' . $albumId . '" type="text">
                        </div>


                        <button type="submit" name="newImagesToAlbum"
                            class="w-full text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">Tambah Gambar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
        <?php endwhile; endif; ?>
            </div>
        </div>
    </section>
</body>

</html>
