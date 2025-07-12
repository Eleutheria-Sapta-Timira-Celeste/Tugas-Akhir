<?php
session_start();
include '../connection/database.php';

// Hanya izinkan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Hanya admin yang bisa mengakses halaman ini.'); window.location.href='../login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambah Notice
    if (isset($_POST['publish_notice'])) {
        $fileUploadName = $_FILES['file-upload']['name'];
        $fileUploadTmp = $_FILES['file-upload']['tmp_name'];
        $sqlfileurl = "";

        if (!empty($fileUploadName)) {
            $targetDirectory = '../assects/images/notices_files/';
            $targetFilePath = $targetDirectory . basename($fileUploadName);

            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $sqlfileurl = "assects/images/notices_files/" . basename($fileUploadName);
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date("d/m/Y");
        $currentTime = date("h:i A");

        $description = $_POST['description'];
        $about_notice = $_POST['about_notice'];
        $posted_by = $_SESSION["username"];
        $logo = $_SESSION["logo"] ?? "default.jpg";
        $last_modified_default = "Not Modified";

        $sql = "INSERT INTO school_notice (logo, notice_description, posted_by, date, time, image_url, about, last_modified) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssssss", $logo, $description, $posted_by, $currentDate, $currentTime, $sqlfileurl, $about_notice, $last_modified_default);

        if ($stmt->execute()) {
            echo '<script>alert("Pengumuman berhasil dipublish!"); window.location.replace("add_notice.php");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Hapus Notice
    if (isset($_POST['notice_delete'])) {
        $noticeId = $_POST["notice_id"];
        mysqli_query($connection, "DELETE FROM school_notice WHERE id = $noticeId");
        echo '<script>window.location.replace("add_notice.php");</script>';
        exit;
    }

    // Update Notice
    if (isset($_POST['update_notice'])) {
        $noticeId = $_POST["notice_id"];
        $IDImage = 'file-upload-modified' . $noticeId;
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];
        $sqlfileurl = $_POST["image_name"];

        if (!empty($fileUploadName)) {
            $targetDirectory = '../assects/images/notices_files/';
            $targetFilePath = $targetDirectory . basename($fileUploadName);
            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $sqlfileurl = "assects/images/notices_files/" . basename($fileUploadName);
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $currentDate = date("d/m/Y");
        $currentTime = date("h:i A");
        $description = $_POST['notice_description'];
        $about_notice = $_POST['about_notice'];
        $last_modified_default = $currentTime . " " . $currentDate;

        $sql = "UPDATE school_notice SET notice_description = ?, about = ?, image_url = ?, last_modified = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $description, $about_notice, $sqlfileurl, $last_modified_default, $noticeId);

        if ($stmt->execute()) {
            echo '<script>alert("Pengumuman berhasil diperbarui!"); window.location.replace("add_notice.php");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    // Tutup koneksi
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/pgri-putih.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body>
    <?php include ('../includes/admin_header.php') ?>

    <main>
        <section class="max-w-4xl p-6 mx-auto bg-[#fc941e] rounded-md shadow-md mt-10">
    <h1 class="text-xl font-bold text-white mb-4">📢 Tambahkan Pengumuman</h1>

    <form action="" method="post" enctype="multipart/form-data" class="space-y-6">

        <!-- Upload File -->
        <div class="flex flex-col gap-2">
            <label class="text-white font-medium">Upload File (opsional)</label>
            <div class="flex items-center justify-center w-full">
                <label for="file-upload" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg cursor-pointer bg-[#fff8e1] border-[#f9c57d] hover:bg-[#fff2d4] transition-all duration-300">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-[#fc941e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16V4m0 0L3 8m4-4l4 4M17 16v-8m0 0l-4 4m4-4l4 4"/>
                        </svg>
                        <p class="mb-1 text-sm text-gray-600"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG, PDF (max 2MB)</p>
                    </div>
                    <input id="file-upload" name="file-upload" type="file" class="hidden" onchange="displayFileName()">
                </label>
            </div>
            <p id="file-info" class="text-sm text-white font-medium mt-1"></p>
        </div>

        <!-- Judul/Subjek -->
        <div>
            <label class="text-white font-medium block mb-1">Subjek <span class="text-red-200">*</span></label>
            <input name="about_notice" required type="text"
                   class="w-full px-4 py-2 border rounded-md bg-white text-gray-800 border-[#fcdca4] focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all">
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="text-white font-medium block mb-1">Tulis Pengumuman <span class="text-red-200">*</span></label>
            <textarea name="description" required minlength="40"
                      class="w-full px-4 py-3 h-36 border rounded-md bg-white text-gray-800 border-[#fcdca4] focus:outline-none focus:ring-2 focus:ring-white focus:border-white resize-none transition-all"></textarea>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end">
            <button type="submit" name="publish_notice"
                    class="px-6 py-2 text-sm font-semibold text-white bg-[#1a1a1a] rounded hover:bg-white hover:text-black border hover:border-black transition-all">
                    Tambahkan
            </button>
        </div>
    </form>
</section>


        <!-- Start block -->
        <section class="bg-[#fff7ee] p-3 mt-5 sm:p-5 antialiased">
    <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
        <div class="bg-white border border-[#fc941e] shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <div class="relative w-full">
                            <input disabled type="text" readonly value="📓 Pengumuman terbaru ditampilkan di bagian atas (urutan menurun)"
                                class="font-semibold text-[#1a1a1a] bg-[#fff7ee] border border-[#fc941e] text-sm rounded-lg block w-full p-2.5"
                                required="">
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-[#1a1a1a]">
                    <thead class="text-xs uppercase bg-[#fc941e] text-white">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Diterbitkan</th>
                            <th class="px-4 py-3">Terakhir Diubah</th>
                            <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fetch_notice_data = "SELECT * FROM `school_notice` ORDER BY id DESC;";
                        $notices = mysqli_query($connection, $fetch_notice_data);
                        $totalNotice = mysqli_num_rows($notices);

                        if ($totalNotice > 0) {
                            while ($row = mysqli_fetch_assoc($notices)) {
                                $noticeId = $row['id'];
                                echo '
                                    <tr class="border-b border-[#fc941e]/30 hover:bg-[#fff3dc]">
                                        <td class="px-4 py-3 font-medium max-w-[12rem] truncate">' . $row['about'] . '</td>
                                        <td class="px-4 py-3">' . $row['time'] . ' ' . $row['date'] . '</td>
                                        <td class="px-4 py-3">' . $row['last_modified'] . '</td>
                                        <td class="px-4 py-3 text-right">
                                            <button id="dropdown-btn' . $noticeId . '" data-dropdown-toggle="dropdown' . $noticeId . '" class="text-[#fc941e] hover:text-[#d67812]">
                                                ⋮
                                            </button>
                                            <div id="dropdown' . $noticeId . '" class="hidden z-10 w-44 bg-white border border-gray-200 rounded shadow">
                                                <ul class="py-1 text-sm text-gray-700">
                                                    <li>
                                                        <button type="button" data-modal-target="updateProductModal' . $noticeId . '" data-modal-toggle="updateProductModal' . $noticeId . '"
                                                            class="w-full text-left px-4 py-2 hover:bg-[#fc941e]/10 text-[#1a1a1a]">
                                                            ✏️ Ubah
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button" data-modal-target="deleteModal' . $noticeId . '" data-modal-toggle="deleteModal' . $noticeId . '"
                                                            class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600">
                                                            🗑 Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


        <!-- Update modal -->
        <?php
        $fetch_notice_data = "SELECT * FROM `school_notice` ORDER BY id DESC;";
        $notices = mysqli_query($connection, $fetch_notice_data);
        $totalNotice = mysqli_num_rows($notices);

        if ($totalNotice > 0) {
            while ($row = mysqli_fetch_assoc($notices)) {
                $noticeId = $row['id'];
                echo '

                        <div id="updateProductModal' . $noticeId . '" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Perbarui Pengumuman</h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal' . $noticeId . '">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post" id="UpdateNotice' . $noticeId . '" enctype="multipart/form-data">
                                        <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                        <div><label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berkas (Jika tidak dipilih, akan menggunakan yang sebelumnya)</label></div><br>
                                            <div class="flex items-center justify-center w-full">
                                               
                                            
                                                <input name="file-upload-modified' . $noticeId . '" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">

                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
                                                <input type="text" name="about_notice" id="name" value="' . $row['about'] . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tomorrow our school will be closed">
                                                <input type="text" name="image_name" id="name" value="' . $row['image_url'] . '" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tomorrow our school will be closed">
                                            </div>
                                            <input type="hidden" name="notice_id" value="' . $noticeId . '" />
                                            <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label><textarea name="notice_description" id="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write a notice here...">' . $row['notice_description'] . '</textarea></div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <button name="update_notice" type="submit" class="text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">Perbarui Pengumuman</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Read modal -->

                        <!-- Delete modal -->
                        <div id="deleteModal' . $noticeId . '" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <form method="post" id="deleteModal' . $noticeId . '">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal' . $noticeId . '">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah Anda yakin ingin menghapus item ini?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <button data-modal-toggle="deleteModal' . $noticeId . '" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak, Batal</button>
                                        <input type="hidden" name="notice_id" value="' . $noticeId . '" />
                                        <button  name="notice_delete" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Ya, Saya Yakin</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        
                       
                        
                        
                        
                        
                        ';
            }
        }
        ?>


    </main>

    <?php include ('../includes/admin_footer.php') ?>

    <script>
        function displayFileName() {
            var fileInput = document.getElementById('file-upload');
            var fileInfoContainer = document.getElementById('file-info');


            if (fileInput.files.length > 0) {
                fileInfoContainer.innerHTML = '         File: ' + fileInput.files[0].name;
                fileInfoContainer.classList.remove('hidden');

            }
        }

        function displayFileNameShow() {
            var fileInput = document.getElementById('dropzone-file');
            var fileInfoContainer = document.getElementById('file-info-modified');

            if (fileInput.files.length > 0) {
                fileInfoContainer.innerHTML = 'File: ' + fileInput.files[0].name;
                fileInfoContainer.classList.remove('hidden');
            }
        }

        

    console.clear();

    </script>



</body>


</html>