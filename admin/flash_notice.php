<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data
$flash_query = "SELECT * FROM flash_notice WHERE id = 1";
$flash_result = mysqli_query($connection, $flash_query);
$flash_notice = mysqli_fetch_assoc($flash_result);

// Update
if (isset($_POST['update_flash_notice'])) {
    $fileUploadName = $_FILES['file-upload']['name'];
    $fileUploadTmp = $_FILES['file-upload']['tmp_name'];
    $sqlfileurl = $_POST["image_name"];

    $targetDirectory = '../assects/images/flashNotice/';
    $targetFilePath = $targetDirectory . basename($fileUploadName);

    if (!empty($fileUploadName) && move_uploaded_file($fileUploadTmp, $targetFilePath)) {
        $sqlfileurl = "assects/images/flashNotice/" . basename($fileUploadName);
    }

    $flash_title = $_POST['flash_title'];
    $flash_message = $_POST['flash_message'];
    $trun_flash_notice = $_POST['trun_flash_notice'];

    $update_sql = "UPDATE flash_notice SET title=?, message=?, trun_flash=?, image_url=? WHERE id=1";
    $stmt = $connection->prepare($update_sql);
    $stmt->bind_param("ssss", $flash_title, $flash_message, $trun_flash_notice, $sqlfileurl);

    if ($stmt->execute()) {
        echo '
        <script>
        alert("Flash Notice berhasil diperbarui!");
        window.location.replace("index.php?page=flash_notice");
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<section class="text-gray-600 body-font">
    <div class="container px-5 py-10 mx-auto">
        <div class="flex flex-col text-center w-full mb-5">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]">Perbarui Kartu Sambutan</h1>
            <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                Halaman ini berfungsi untuk mengubah atau mengatur kartu sambutan yang muncul ketika pengunjung membuka halaman website.
            </p>
        </div>
    </div>
</section>

<!-- Mulai dari sini adalah HTML isi kontennya saja -->
<section class="text-gray-600 body-font" id="joinUsSection">
    <div class="container mx-auto px-4 py-5">
        <div class="flex flex-col lg:flex-row items-start justify-center gap-10">
            <!-- Preview -->
            <div class="w-full lg:w-1/2">
                <div class="p-6 bg-white rounded-md shadow-md h-full">
                    <h5 class="mb-3 text-2xl font-bold tracking-tight text-gray-900 text-left">
                        <?= $flash_notice['title']; ?>
                    </h5>
                    <img class="rounded-t-lg mx-auto" src="../<?= $flash_notice['image_url']; ?>" alt="Preview Image" />
                    <p class="my-3 text-gray-700 text-justifiy"><?= $flash_notice['message']; ?></p>
                    <div class="flex justify-left">
                        <a href="#" class="inline-flex items-left py-2 px-4 text-white bg-[#e65c00] hover:bg-[#cc5200] rounded">Close</a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="w-full lg:w-1/2">
                <section class="p-6 bg-white rounded-md shadow-md h-full">
                    <h1 class="text-xl font-bold text-black mb-4">Kartu Sambutan</h1>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="text-black">Nyalakan Animasi</label>
                                <select name="trun_flash_notice" class="w-full mt-2 p-2 border border-gray-300 rounded">
                                    <option value="1" <?= ($flash_notice['trun_flash'] == "1" ? 'selected' : ''); ?>>ON</option>
                                    <option value="0" <?= ($flash_notice['trun_flash'] == "0" ? 'selected' : ''); ?>>OFF</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-black">Subjek <span class="text-red-500">*</span></label>
                                <input name="flash_title" value="<?= $flash_notice['title']; ?>" type="text" class="w-full mt-2 p-2 border border-gray-300 rounded">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-black mb-1">Poster/Gambar</label>
                                <div class="border-2 border-dashed border-gray-300 p-4 text-center rounded">
                                    <input name="image_name" type="hidden" value="<?= $flash_notice['image_url']; ?>">
                                    <input type="file" accept="image/*" name="file-upload" id="file-upload" class="block w-full text-sm text-gray-600">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-black">Isi Pesan <span class="text-red-500">*</span></label>
                                <textarea name="flash_message" rows="4" class="w-full mt-2 p-2 border border-gray-300 rounded"><?= $flash_notice['message']; ?></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button name="update_flash_notice" type="submit" class="px-4 py-2 bg-[#fc6941] hover:bg-[#e65c00] text-white rounded">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>

