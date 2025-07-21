<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$flash_query = "SELECT * FROM flash_notice WHERE id = 1";
$flash_result = mysqli_query($connection, $flash_query);
$flash_notice = mysqli_fetch_assoc($flash_result);

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
        echo '<script>alert("Flash Notice berhasil diperbarui!"); window.location.replace("flash_notice.php");</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Sambutan</title>
    <link rel="icon" href="../assects/images/admin_logo.png">
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include ('../includes/admin_header.php'); ?>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-[#ef6c00]">Perbarui Kartu Sambutan</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    Halaman ini berfungsi untuk mengubah atau mengatur kartu sambutan yang muncul ketika pengunjung membuka halaman website.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-5 mb-10">
        <!-- Breadcrumb -->
        <div class="text-sm text-gray-700 mb-6">
            <a href="dashboard.php" class="text-[#e65c00] hover:underline">Dashboard</a> / 
            <span class="text-gray-800 font-semibold">Kartu Sambutan</span>
        </div>

        <div class="grid md:grid-cols-2 gap-10">
            <!-- Preview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4"><?php echo $flash_notice['title']; ?></h2>
                <img class="w-full rounded-md mb-4" src="../<?php echo $flash_notice['image_url']; ?>" alt="Flash Image">
                <p class="text-gray-700 mb-4"><?php echo $flash_notice['message']; ?></p>
                <a href="#" class="inline-block bg-[#e65c00] hover:bg-[#cc5200] text-white text-sm font-medium py-2 px-4 rounded-md">Close</a>
            </div>

            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Kartu Sambutan</h2>

                <label class="block mb-2 text-sm font-medium text-gray-700">Nyalakan Animasi</label>
                <select name="trun_flash_notice" required class="mb-4 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-[#e65c00] focus:border-[#e65c00]">
                    <option value="1" <?php if ($flash_notice['trun_flash'] == "1") echo 'selected'; ?>>ON</option>
                    <option value="0" <?php if ($flash_notice['trun_flash'] == "0") echo 'selected'; ?>>OFF</option>
                </select>

                <label class="block mb-2 text-sm font-medium text-gray-700">Subjek <span class="text-red-500">*</span></label>
                <input type="text" name="flash_title" required placeholder="Masukkan judul sambutan"
                    value="<?php echo $flash_notice['title']; ?>"
                    class="mb-4 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-[#e65c00] focus:border-[#e65c00]">

                <label class="block mb-2 text-sm font-medium text-gray-700">Poster/Gambar</label>
                <input type="file" name="file-upload" accept="image/*"
                    class="mb-4 block w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer bg-white">
                <input type="hidden" name="image_name" value="<?php echo $flash_notice['image_url']; ?>">

                <label class="block mb-2 text-sm font-medium text-gray-700">Isi Pesan <span class="text-red-500">*</span></label>
                <textarea name="flash_message" rows="4" required placeholder="Tulis pesan sambutan..." 
                    class="mb-6 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-[#e65c00] focus:border-[#e65c00]"><?php echo $flash_notice['message']; ?></textarea>

                <div class="text-right">
                    <button type="submit" name="update_flash_notice"
                        class="bg-[#e65c00] hover:bg-[#cc5200] text-white text-sm font-medium py-2 px-5 rounded-md focus:ring-4 focus:ring-[#ff944d]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>

    <?php include ('../includes/admin_footer.php'); ?>

    <script>
        // Validasi fallback
        document.querySelector('form').addEventListener('submit', function(e) {
            const title = document.querySelector('input[name="flash_title"]').value.trim();
            const message = document.querySelector('textarea[name="flash_message"]').value.trim();

            if (!title || !message) {
                alert('Judul dan Pesan tidak boleh kosong!');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
