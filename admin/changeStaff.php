<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   if (isset($_POST['add_pimpinan'])) {

    $pimpinanFileInput = 'file-upload-pimpinan';
    $pimpinanFileName = $_FILES[$pimpinanFileInput]['name'] ?? '';
    $pimpinanFileTmp = $_FILES[$pimpinanFileInput]['tmp_name'] ?? '';

    $pimpinanTargetDir = '../assects/images/staff/';
    $pimpinanImageSrc = '';

    // Buat folder jika belum ada
    if (!is_dir($pimpinanTargetDir)) {
        mkdir($pimpinanTargetDir, 0755, true);
    }

    // Pindahkan file upload jika ada file
    if (!empty($pimpinanFileName)) {
        $targetPath = $pimpinanTargetDir . basename($pimpinanFileName);

        if (move_uploaded_file($pimpinanFileTmp, $targetPath)) {
            $pimpinanImageSrc = 'assects/images/staff/' . basename($pimpinanFileName);
        } else {
            echo '<script>alert("Gagal upload foto. Cek izin folder atau nama file.");</script>';
        }
    }

    // Ambil data input dari form
    $pimpinanName = $_POST['pimpinanName'] ?? '';
    $pimpinanPosition = $_POST['pimpinanPosition'] ?? '';
    $pimpinanPhone = $_POST['pimpinanPhone'] ?? '';

    // Simpan ke database
    $sql = "INSERT INTO pimpinan_sekolah (name, position, contact_no, image_src) VALUES (?, ?, ?, ?)";
    $stmt = $connectionobj->prepare($sql);
    $stmt->bind_param("ssss", $pimpinanName, $pimpinanPosition, $pimpinanPhone, $pimpinanImageSrc);

    if ($stmt->execute()) {
        echo '<script>alert("Data pimpinan berhasil ditambahkan.")</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connectionobj->close();
}



    // Tambah Staff
    if (isset($_POST['add_staff'])) {
        $IDImage = 'file-upload-modified';
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/staff/';
        $targetFilePath = $targetDirectory . basename($fileUploadName);
        $sqlfileurl = "";

        if (!empty($fileUploadName) && move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "assects/images/staff/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $staffName = $_POST['staffName'];
        $staffPost = $_POST['staffPost'];
        $staffQualification = $_POST['staffQualification'];
        $staffPhone = $_POST["staffContact"];

        $sql = "INSERT INTO staffs (name, post, contact, qualification, image_src) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sssss", $staffName, $staffPost, $staffPhone, $staffQualification, $sqlfileurl);

        if ($stmt->execute()) {
            echo '<script>alert("Staff berhasil ditambahkan.");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }

    // Hapus Pimpinan Sekolah
   if (isset($_POST['pimpinanDelete'])) {
    $pimpinanId = (int)$_POST['pimpinanDelete_id'];
    mysqli_query($connectionobj, "DELETE FROM pimpinan_sekolah WHERE id = $pimpinanId");
    echo '<script>window.location.replace("index.php?page=changeStaff");</script>';
    exit;
}



    // Hapus Staff
    if (isset($_POST['staffDelete'])) {
        $staffId = $_POST['staffDelete_id'];
        mysqli_query($connectionobj, "DELETE FROM staffs WHERE id = $staffId;");
        echo '<script>window.location.replace("index.php?page=changeStaff");</script>';
        exit;
    }

   // === Update Pimpinan Sekolah ===
if (isset($_POST['update_pimpinan'])) {

    /* ---------- 1. Ambil ID ---------- */
    $pimpinanId = (int)$_POST['pimpinanId'];

    /* ---------- 2. Ambil informasi file (jika user pilih foto baru) ---------- */
    $pimpinanFileInput = 'file-upload-pimpinan' . $pimpinanId;      // <input name="file-upload-pimpinan{ID}">
    $pimpinanFileName  = $_FILES[$pimpinanFileInput]['name'] ?? '';
    $pimpinanFileTmp   = $_FILES[$pimpinanFileInput]['tmp_name'] ?? '';

    $pimpinanTargetDir = '../assects/images/staff/';                 // path fisik
    if (!is_dir($pimpinanTargetDir)) {
        mkdir($pimpinanTargetDir, 0755, true);                       // buat folder jika belum ada
    }

    /* Ambil path lama dari hidden input */
    $pimpinanImageSrc  = $_POST['pimpinanImageLocation'] ?? '';

    /* ---------- 3. Jika ada file baru, pindahkan ---------- */
    if (!empty($pimpinanFileName)) {
        $targetPath = $pimpinanTargetDir . basename($pimpinanFileName);

        if (move_uploaded_file($pimpinanFileTmp, $targetPath)) {
            $pimpinanImageSrc = 'assects/images/staff/' . basename($pimpinanFileName);

         
        } else {
            echo '<script>alert("Gagal mengunggah foto baru. Periksa izin folder.");</script>';
        }
    }

    /* ---------- 4. Ambil input teks ---------- */
    $pimpinanName     = $_POST['pimpinanName']     ?? '';
    $pimpinanPosition = $_POST['pimpinanPosition'] ?? '';
    $pimpinanPhone    = $_POST['pimpinanPhone']    ?? '';

    /* ---------- 5. Update database ---------- */
    $sql  = "UPDATE pimpinan_sekolah
             SET name = ?, position = ?, contact_no = ?, image_src = ?
             WHERE id = ?";
    $stmt = $connectionobj->prepare($sql);
    $stmt->bind_param("ssssi",
        $pimpinanName,
        $pimpinanPosition,
        $pimpinanPhone,
        $pimpinanImageSrc,
        $pimpinanId
    );

    if ($stmt->execute()) {
        echo '<script>
                alert("Data pimpinan berhasil di‑update.");
                window.location.replace("index.php?page=changeStaff");
              </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connectionobj->close();
}



    // Update Staff
    if (isset($_POST['update_staffs'])) {
        $staffId = $_POST['staffId'];
        $IDImage = 'file-upload-modified' . $staffId;
        $fileUploadName = $_FILES[$IDImage]['name'];
        $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

        $targetDirectory = '../assects/images/staff/';
        $targetFilePath = $targetDirectory . basename($fileUploadName);
        $sqlfileurl = $_POST['imageLocation'];

        if (!empty($fileUploadName) && move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "assects/images/staff/" . basename($fileUploadName);
        }

        if ($connectionobj->connect_error) {
            die("Connection failed: " . $connectionobj->connect_error);
        }

        $staffName = $_POST['staffName'];
        $staffPost = $_POST['staffPost'];
        $staffPhone = $_POST["staffPhone"];
        $staffqualification = $_POST["staffqualification"];

        $sql = "UPDATE staffs SET name=?, post=?, qualification=?, contact=?, image_src=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("ssssss", $staffName, $staffPost, $staffqualification, $staffPhone, $sqlfileurl, $staffId);

        if ($stmt->execute()) {
            echo '<script>alert("Staff berhasil diperbarui.");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }
}

$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Pimpinan & Staff Sekolah</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


</head>

<body>
  

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #ef6c00;">Perbarui Staff Sekolah
                </h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    🎉 Selamat datang di halaman pengelolaan dan pembaruan data staf dan kepanitiaan SMP PGRI 371 Pondok Aren! 📝
                        Halaman ini dirancang dengan antarmuka yang mudah digunakan untuk membantu Anda melakukan perubahan data staf maupun struktur kepanitiaan secara efisien.
                        Partisipasi Anda sangat penting dalam menjaga keakuratan dan keterkinian data.
                        Silakan gunakan fitur yang tersedia untuk memastikan semua informasi tetap terupdate. 🚀
                </p>
            </div>

            <button data-modal-target="authentication-modal2" data-modal-toggle="authentication-modal2"
                class="mt-10 mb-0 block text-white bg-[#ef6c00] hover:bg-[#ef6c00] focus:ring-4 p-4 focus:outline-none focus:ring-[#ef6c00] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#fc941e] dark:hover:bg-[#ef6c00] dark:focus:ring-"
                type="button">
                Tambah Data Kepala Sekolah
            </button>
        </div>
    </section>


    <!-- Modal toggle -->


    <!-- Adding Staff -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-[#ef6c00] ">
                        Tambah Data Guru
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-[#ef6c00] hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-[#ef6c00] dark:hover:text-white"
                        data-modal-hide="authentication-modal">
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
                    <form class="space-y-4" action="" method="POST" enctype="multipart/form-data">
                        <div><label for="new_file"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Pilih gambar ukuran pas foto agar tampilan pratinjau lebih jelas</label></div>
                        <div class="flex items-center justify-center w-full">


                            <input name="file-upload-modified"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none "
                                id="file_input" type="file" accept="image/*">

                        </div>
                        <div>
                            <label for="staffName"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                            <input type="text" name="staffName"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Annisa Putri" required>
                            <label for="staffPost"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Posisi</label>
                            <input type="text" name="staffPost"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Guru" required>
                            <label for="staffContact"
                                class="block mb-2 text-sm font-medium text-gray-900 ">NIP</label>
                            <input type="text" name="staffContact"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="9804545454" required>
                            <label for="staffqualification"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Kualifikasi</label>
                            <input type="text" name="staffQualification"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="S,Pd" required>
                        </div>


                        <button type="submit" name="add_staff"
                            class="w-full text-white bg-[#fc941e] hover:bg-[#ef6c00] focus:ring-4 focus:outline-none focus:ring-[#ef6c00] font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Data Guru
                            </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Adding Committe Menber -->

   <div id="authentication-modal2" tabindex="-1" aria-hidden="true"
    class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Tambah Pimpinan Sekolah
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="authentication-modal2">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="file-upload-pimpinan"
                            class="block mb-2 text-sm font-medium text-gray-900">Pilih Foto (ukuran pas foto)</label>
                        <input name="file-upload-pimpinan" id="file-upload-pimpinan" type="file" accept="image/*"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>

                    <div>
                        <label for="pimpinanName"
                            class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="pimpinanName" id="pimpinanName"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Misalnya: Annisa Aulia" required>

                        <label for="pimpinanPosition"
                            class="block mt-4 mb-2 text-sm font-medium text-gray-900">Posisi / Jabatan</label>
                        <input type="text" name="pimpinanPosition" id="pimpinanPosition"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Misalnya: Kepala Sekolah" required>

                        <label for="pimpinanPhone"
                            class="block mt-4 mb-2 text-sm font-medium text-gray-900">Kontak / NIP</label>
                        <input type="text" name="pimpinanPhone" id="pimpinanPhone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Misalnya: 198209022005021002" required>
                    </div>

                    <button type="submit" name="add_pimpinan"
                        class="w-full text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">
                        Tambah Pimpinan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>




<?php
include '../connection/database.php';
$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";
?>

<main>
    <section class="bg-white dark:bg-white p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
           <div class="bg-white dark:bg-white relative shadow-md sm:rounded-lg overflow-hidden border-2 border-[#fcddb8]">

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-0 pointer-events-none">
                                    <h2 class="text-xl font-bold text-[#fc941e]">Pimpinan Sekolah</h2>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 text-black dark:text-black">
                        <thead class="text-xs text-white uppercase bg-[#fc941e] dark:bg-[#fc941e] dark:text-white">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Jabatan</th>
                                <th class="px-4 py-3">NIP</th>
                                <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                       <tbody>
                        <?php
                        $query = "SELECT * FROM pimpinan_sekolah;";
                        $result = mysqli_query($connectionobj, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $pimpinanId = $row['id'];
                                echo '
                                <tr class="border-[#fcddb8] dark:border-[#fcddb8]">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                        <div class="flex items-center mr-3">
                                            <img src="../' . $row['image_src'] . '" alt="" class="h-8 w-auto mr-3 rounded" onerror="this.src=' . $defaultavatar . '">
                                            ' . $row['name'] . '
                                        </div>
                                    </th>
                                    <td class="px-4 py-3">' . $row['position'] . '</td>
                                    <td class="px-4 py-3">' . $row['contact_no'] . '</td>
                                   <td class="px-4 py-3 flex items-center justify-end relative z-50">

                                        <button data-dropdown-toggle="dropdown-pimpinan' . $pimpinanId . '" class="text-[#fc941e] hover:text-[#e77e08]">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="dropdown-pimpinan' . $pimpinanId .'" class="hidden z-10 w-44 bg-white rounded shadow">
                                            <ul class="py-1 text-sm text-gray-700">
                                                <li>
                                                    <button type="button"
                                                            data-modal-target="updatePimpinanModal' . $pimpinanId .'"
                                                            data-modal-toggle="updatePimpinanModal' . $pimpinanId . '"
                                                            class="flex w-full px-4 py-2 hover:bg-[#fc941e]/20 dark:hover:bg-[#fc941e]">
                                                        Ubah
                                                    </button>
                                                </li>
                                                <li>
                                                    <form method="POST">
                                                        <input type="hidden" name="pimpinanDelete_id" value="' . $pimpinanId . '">
                                                        <button name="pimpinanDelete" type="submit"
                                                                class="flex w-full px-4 py-2 text-red-600 hover:bg-[#fc941e]/20 dark:hover:bg-[#fc941e]">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

        <!-- Modal Update -->
        <div id="updatePimpinanModal' . $pimpinanId . '" class="hidden fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ubah Data Pimpinan</h3>
                    <hr class="border-[#fc941e] mb-4">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Foto</label>
                            <input type="file" name="file-upload-pimpinan' . $pimpinanId . '" accept="image/*"
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                            <input type="text" name="pimpinanName" value="' . $row['name'] . '"
                                   class="w-full p-2.5 rounded border border-gray-300 bg-gray-50">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Posisi</label>
                            <input type="text" name="pimpinanPosition" value="' . $row['position'] . '"
                                   class="w-full p-2.5 rounded border border-gray-300 bg-gray-50">
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">NIP / Kontak</label>
                            <input type="text" name="pimpinanPhone" value="' . $row['contact_no'] . '"
                                   class="w-full p-2.5 rounded border border-gray-300 bg-gray-50">
                        </div>
                        <input type="hidden" name="pimpinanId" value="' . $pimpinanId . '">
                        <input type="hidden" name="pimpinanImageLocation" value="' . $row['image_src'] . '">
                        <div class="flex justify-end">
                            <button type="submit" name="update_pimpinan"
                                    class="px-4 py-2 bg-[#fc941e] text-white rounded hover:bg-[#e77e08] ">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
</main>




    <section class="text-gray-600 body-font">
        <div class="container px-5 py-4 mx-auto">

            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="mt-10 block text-white bg-[#fc941e] hover:bg-[#ef6c00] focus:ring-4 focus:outline-none focus:ring-[#fc941e] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#fc941e] dark:hover:bg-[#ef6c00] dark:focus:ring-[#fc941e]"
                type="button">
                Tambah Data Guru
            </button>


        </div>
    </section>

   <main>
    <section class="bg-white dark:bg-white p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-0 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-white relative shadow-md sm:rounded-lg overflow-hidden border-2 border-[#fcddb8]">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-0 pointer-events-none">
                                    <h2 class="text-xl font-bold text-[#fc941e]">Data Guru Sekolah</h2>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-white uppercase bg-[#fc941e] dark:bg-[#fc941e] dark:text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nama</th>
                                <th scope="col" class="px-4 py-3">Posisi</th>
                                <th scope="col" class="px-4 py-3">NIP</th>
                                <th scope="col" class="px-4 py-3">Kualifikasi</th>
                                <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM staffs;";
                            $result = mysqli_query($connectionobj, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $staffsId = $row['id'];
                                    echo '
                                    <tr class="border-[#fcddb8] dark:border-[#fcddb8]">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                                            <div class="flex items-center mr-3">
                                                <img src="../' . $row['image_src'] . '" alt="" class="h-8 w-auto mr-3 rounded" onerror="this.src=' . $defaultavatar . '">
                                                ' . $row['name'] . '
                                            </div>
                                        </th>
                                        <td class="px-4 py-3">' . $row['post'] . '</td>
                                        <td class="px-4 py-3">' . $row['contact'] . '</td>
                                        <td class="px-4 py-3">' . $row['qualification'] . '</td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button data-dropdown-toggle="dropdown-staff-' . $staffsId . '" class="text-[#fc941e] hover:text-[#e77e08]">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="dropdown-staff-' . $staffsId . '" class="hidden z-10 w-44 bg-white rounded shadow ">
                                                <ul class="py-1 text-sm text-gray-700 ">
                                                    <li>
                                                        <button type="button" data-modal-target="updatestaffsModel' . $staffsId . '" 
                                                        data-modal-toggle="updatestaffsModel' . $staffsId . '" class="flex w-full px-4 py-2 hover:bg-[#fc941e]/20 dark:hover:bg-[#fc941e]">Ubah</button>
                                                    </li>
                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="staffDelete_id" value="' . $staffsId . '">
                                                            <button name="staffDelete" type="submit" class="flex w-full px-4 py-2 text-red-600 hover:bg-[#fc941e]/20 dark:hover:bg-[#fc941e]">Hapus</button>
                                                        </form>
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
</main>


        <!-- Update modal -->
        <?php
        $fetchmanagementCommitte = "SELECT * FROM staffs;";
        $managementCommitte = mysqli_query($connection, $fetchmanagementCommitte);
        $totalmanagementCommitte = mysqli_num_rows($managementCommitte);

        if ($totalmanagementCommitte > 0) {
            while ($row = mysqli_fetch_assoc($managementCommitte)) {
                $staffsId = $row['id'];
                echo '

                        <div id="updatestaffsModel' . $staffsId . '" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                
                                <div class="relative p-4 bg-white rounded-lg shadow  sm:p-5">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 ">
                                        <h3 class="text-lg font-semibold text-[#ef6c00]">Perbarui Petugas</h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="updatestaffsModel' . $staffsId . '">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form method="post" id="UpdateNotice' . $staffsId . '" enctype="multipart/form-data">
                                        <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                        <div><label for="new_file" class="block mb-2 text-sm font-medium text-gray-900 ">Berkas (Jika kosong, akan menggunakan yang sebelumnya)</label></div><br>
                                            <div class="flex items-center justify-center w-full">
                                               
                                            
                                                <input name="file-upload-modified' . $staffsId . '" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none " id="file_input" type="file" accept="image/*">

                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                                                <input type="text" name="staffName" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="' . $row['name'] . '" placeholder="Bisswass Niroula">
                                                <label for="post" class="block mb-2 text-sm font-medium text-gray-900 ">Posisi</label>
                                                <input type="text" name="staffPost" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="' . $row['post'] . '" placeholder="Teacher">
                                                <label for="post" class="block mb-2 text-sm font-medium text-gray-900 ">Kualifikasi</label>
                                                <input type="text" name="staffqualification" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="' . $row['qualification'] . '" placeholder="PHD  ">
                                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">NIP</label>
                                                <input type="text" name="staffPhone" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="' . $row['contact'] . '" placeholder="9812000000">

                                                <input type="text" name="imageLocation" id="name" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " value="' . $row['image_src'] . '" placeholder="9812000000">
                                                
                                                </div>
                                            <input type="hidden" name="staffId" value="' . $staffsId . '" />
                                            
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <button name="update_staffs" type="submit" class="text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">Perbarui Petugas</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Read modal -->

                        <!-- Delete modal -->
                        <div id="deleteStaffModel' . $staffsId . '" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <form method="post" id="deleteStaffModel' . $staffsId . '">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteStaffModel' . $staffsId . '">
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
                                        <button data-modal-toggle="deleteStaffModel' . $staffsId . '" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak, Batal</button>
                                        <input type="hidden" name="staffDelete_id" value="' . $staffsId . '" />
                                        <button  name="staffDelete" type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">Ya, Saya Yakin</button>
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