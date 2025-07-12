<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = 0 WHERE id = 1");
}

if (isset($_POST['student_delete'])) {
    $studentId = intval($_POST["student_id"]);
    mysqli_query($connection, "DELETE FROM `spmb` WHERE id = $studentId;");
    echo '<script>window.location.replace("registered_students.php");</script>';
    exit;
}

$defaultavatar = "../assects/images/defaults/defaultaltimage.jpg";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran Siswa</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
    <link rel="stylesheet" href="../css/animation.css">

</head>


<body class="flex flex-col min-h-screen">

<?php include('../includes/admin_header.php') ?>

<main class="flex-1">

    <!-- Header Section -->
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-4 mx-auto">
            <div class="flex flex-col text-center w-full mb-2">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-[#ef6c00]">
                    Halaman Data Pendaftaran Siswa
                </h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base text-gray-700">
                    Selamat datang di halaman data pendaftaran siswa baru SMP PGRI 371 Pondok Aren khusus untuk admin.
                    Halaman ini digunakan untuk memantau, mengelola, dan memverifikasi seluruh data pendaftaran dengan akurat dan efisien.
                    Kami berharap sistem ini memudahkan proses administrasi demi kelancaran penerimaan siswa baru di sekolah.
                </p>
            </div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="bg-[#fff9f2] p-4 sm:p-6">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <div class="bg-white border border-[#fc941e]/30 shadow-md sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-800">
                        <thead class="text-xs uppercase bg-[#fc941e] text-white">
                            <tr>
                                <th scope="col" class="p-4 font-semibold">Nama Siswa</th>
                                <th scope="col" class="p-4 font-semibold">Jenis Kelamin</th>
                                <th scope="col" class="p-4 font-semibold">Tanggal Pendaftaran</th>
                                <th scope="col" class="p-4 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetch_all_students = "SELECT * FROM `spmb` ORDER BY id DESC;";
                            $students = mysqli_query($connection, $fetch_all_students);
                            $totalStudents = mysqli_num_rows($students);

                            if ($totalStudents > 0) {
                                while ($row = mysqli_fetch_assoc($students)) {
                                    $student_Id = $row['id'];
                                    echo '
                                    <tr class="border-b hover:bg-[#fff3dc] transition">
                                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">'
                                            . $row['nama_lengkap'] .
                                        '</td>
                                        <td class="px-4 py-3">
                                            <span class="bg-[#fdebcf] text-[#a35300] text-xs font-medium px-2 py-0.5 rounded">'
                                                . $row['jenis_kelamin'] .
                                            '</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-700 whitespace-nowrap">'
                                            . $row['created_at'] .
                                        '</td>
<<<<<<< HEAD
                                        <td class="p-4">
                                            <button type="button" data-modal-target="previewModal'.$student_Id.'" data-modal-toggle="previewModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-blue-600 rounded">Pratinjau</button>
                                            <button type="button" data-modal-target="deleteModal'.$student_Id.'" data-modal-toggle="deleteModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-red-600 rounded">Hapus</button>
=======
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <button type="button"
                                                    data-drawer-target="drawer-read-product-advanced' . $student_Id . '"
                                                    data-drawer-show="drawer-read-product-advanced' . $student_Id . '"
                                                    aria-controls="drawer-read-product-advanced' . $student_Id . '"
                                                    class="py-1.5 px-3 text-sm font-medium text-white bg-[#fc941e] rounded hover:bg-[#e28114] transition">
                                                    👁️ Preview
                                                </button>
                                                <button type="button"
                                                    data-modal-target="delete-modal' . $student_Id . '"
                                                    data-modal-toggle="delete-modal' . $student_Id . '"
                                                    class="py-1.5 px-3 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 transition">
                                                    🗑 Hapus
                                                </button>
                                            </div>

                                        </td>
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
<<<<<<< HEAD
<!-- <td class="p-4">
                                <button type="button" data-modal-target="previewModal'.$student_Id.'" data-modal-toggle="previewModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-blue-600 rounded">Preview</button>
                                <button type="button" data-modal-target="deleteModal'.$student_Id.'" data-modal-toggle="deleteModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-red-600 rounded">Delete</button>
                            </td> -->
    <?php
    mysqli_data_seek($students, 0);
    while ($row = mysqli_fetch_assoc($students)) {
        $student_Id = $row['id'];
    ?>
    <!-- Modal Preview -->
    <div id="previewModal<?= $student_Id ?>" tabindex="-1"
         class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-60">
        <div class="relative w-full max-w-5xl mx-auto my-10">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="max-h-[75vh] overflow-y-auto text-sm text-black">
                    <div class="flex items-center justify-center mb-6 space-x-4">
                        <img src="../assects/images/defaults/logo_warna_500.png" alt="Logo Sekolah" class="w-20 h-20 object-cover">
                        <div class="text-center">
                            <h1 class="text-lg font-bold">SMP PGRI 371 PONDOK AREN</h1>
                            <h2 class="text-base">Sistem Penerimaan Murid Baru (SPMB) 2025</h2>
                        </div>


    <!-- Preview Drawer Section -->
   <?php
        $fetch_all_students = "SELECT * FROM `spmb` ORDER BY id DESC;";
        $students = mysqli_query($connection, $fetch_all_students);
        $totalStudents = mysqli_num_rows($students);

        if ($totalStudents > 0) {
            while ($row = mysqli_fetch_assoc($students)) {
                $student_Id = $row['id'];
                echo '
        <!-- Preview Drawer -->
        <div id="drawer-read-product-advanced'.$student_Id.'" class="overflow-y-auto fixed top-0 left-0 z-50 p-4 w-full max-w-lg h-screen bg-white transition-transform -translate-x-full " tabindex="-1" aria-labelledby="drawer-label" aria-hidden="true">
            <div>
                <h4 id="read-drawer-label" class="mb-1.5 leading-none text-xl font-semibold text-gray-900">Tanggal Pendaftaran</h4>
                <h5 class="mb-5 text-xl font-bold text-gray-900">'.$row['created_at'].'</h5>
            </div>
            <button type="button" data-drawer-dismiss="drawer-read-product-advanced'.$student_Id.'" aria-controls="drawer-read-product-advanced'.$student_Id.'" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center ">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            
            <div class="grid grid-cols-3 gap-4 mb-4 sm:mb-5">
                <div class="p-2 w-auto bg-gray-100 rounded-lg">
                <img src="spmb/uploads/'.$row['foto_pas'].'" onerror="this.src=`' . $defaultavatar . '`">
                </div>

            </div>

            <dl class="sm:mb-5"><dt class="mb-2 font-semibold leading-none text-gray-900">NISN SISWA</dt><dd class="mb-4 font-light text-gray-500 sm:mb-5 ">'.$row['nis'].'</dd></dl>
            <dl class="grid grid-cols-2 gap-4 mb-4">
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900">Nama Lengkap</dt><dd class="text-gray-500 ">'.$row['nama_lengkap'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900">Jenis Kelamin</dt><dd class="text-gray-500">'.$row['jenis_kelamin'].'</dd></div>
                        <div class="p-3 bg-gray-100 rounded-lg border border-gray-200"><dt class="mb-2 font-semibold leading-none text-gray-900">NIK Siswa</dt><dd class="text-gray-500">'.$row['nik'].'</dd></div>
                        <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tempat Lahir</dt><dd class="text-gray-500">'.$row['tempat_lahir'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tanggal Lahir</dt><dd class="text-gray-500 ">'.$row['tanggal_lahir'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Agama/Kepercayan</dt><dd class="text-gray-500">'.$row['agama'].'</dd></div>
                   <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tempat Tinggal</dt><dd class="text-gray-500">'.$row['tempat_tinggal'].'</dd></div>
                <div class="col-span-2 p-3 bg-gray-100 rounded-lg border border-gray-200  sm:col-span-1 ">
                    <dt class="mb-2 font-semibold leading-none text-gray-900">Alamat Tinggal</dt>
                    <dd class="flex items-center text-gray-500">
                        <svg class="w-4 h-4 mr-1.5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        '.$row['alamat_tinggal'].'
                    </dd>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Moda Transportasi</dt><dd class="text-gray-500 ">'.$row['moda_transportasi'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Anak Ke- </dt><dd class="text-gray-500 ">'.$row['anak_keberapa'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Jumlah Saudara Kandung</dt><dd class="text-gray-500">'.$row['jumlah_saudara_kandung'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nomor Telepon</dt><dd class="text-gray-500 ">'.$row['no_telp'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Siswa Penerima KIP</dt><dd class="text-gray-500 ">'.$row['penerima_kip'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nomor KIP Siswa</dt><dd class="text-gray-500">'.$row['no_kip'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tinggi Siswa</dt><dd class="text-gray-500">'.$row['tinggi_cm'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Berat Badan Siswa</dt><dd class="text-gray-500">'.$row['berat_kg'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Jarak Tempat Tinggal</dt><dd class="text-gray-500">'.$row['jarak_tempat_tinggal'].'</dd></div>
            </dl>
            
            <br>
             <!-- Data Ayah -->
             <dl class="sm:mb-5"><dt class="mb-2 font-bold leading-none text-gray-900">DATA AYAH</dt></dl>
            <dl class="grid grid-cols-2 gap-4 mb-4">
            <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nama Ayah</dt><dd class="text-gray-500 ">'.$row['nama_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">NIK Ayah</dt><dd class="text-gray-500">'.$row['nik_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tempat Lahir Ayah</dt><dd class="text-gray-500 ">'.$row['tempat_lahir_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tanggal Lahir Ayah</dt><dd class="text-gray-500">'.$row['tanggal_lahir_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Pendidikan Ayah</dt><dd class="text-gray-500 ">'.$row['pendidikan_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Pekerjaan Ayah</dt><dd class="text-gray-500">'.$row['pekerjaan_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Penghasilan Ayah</dt><dd class="text-gray-500 ">'.$row['penghasilan_ayah'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nomor Telepon Ayah</dt><dd class="text-gray-500">'.$row['no_telp_ayah'].'</dd></div>
            </dl>

             <br>
             <!-- Data Ibu -->
             <dl class="sm:mb-5"><dt class="mb-2 font-bold leading-none text-gray-900 ">DATA IBU</dt></dl>
            <dl class="grid grid-cols-2 gap-4 mb-4">
            <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nama Ibu</dt><dd class="text-gray-500 ">'.$row['nama_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">NIK Ibu</dt><dd class="text-gray-500 ">'.$row['nik_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tempat Lahir Ibu</dt><dd class="text-gray-500 ">'.$row['tempat_lahir_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Tanggal Lahir Ibu</dt><dd class="text-gray-500 ">'.$row['tanggal_lahir_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Pendidikan Ibu</dt><dd class="text-gray-500">'.$row['pendidikan_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Pekerjaan Ibu</dt><dd class="text-gray-500 ">'.$row['pekerjaan_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Penghasilan Ibu</dt><dd class="text-gray-500 ">'.$row['penghasilan_ibu'].'</dd></div>
                <div class="p-3 bg-gray-100 rounded-lg border border-gray-200 "><dt class="mb-2 font-semibold leading-none text-gray-900 ">Nomor Telepon ibu</dt><dd class="text-gray-500 ">'.$row['no_telp_ibu'].'</dd></div>
            </dl>
             
            <div class="flex bottom-0 left-0 justify-center pb-4 space-x-4 w-full">
            <button data-drawer-dismiss="drawer-read-product-advanced'.$student_Id.'" aria-controls="drawer-read-product-advanced'.$student_Id.'" type="button" class="text-white w-full inline-flex items-center justify-center bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#ef6c00] dark:focus:ring-[#ef6c00]">
                    
                    Back
                </button>
                <button onclick="mailto'.$student_Id.'()" type="button" class="inline-flex w-full items-center text-white justify-center bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#ef6c00] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#ef6c00] dark:focus:ring-[#ef6c00]">
                    <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.098 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L8.8 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L4.114 8.254a.502.502 0 0 0-.042-.028.147.147 0 0 1 0-.252.497.497 0 0 0 .042-.028l3.984-2.933zM9.3 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z" fill="white"></path> <path d="M5.232 4.293a.5.5 0 0 0-.7-.106L.54 7.127a1.147 1.147 0 0 0 0 1.946l3.994 2.94a.5.5 0 1 0 .593-.805L1.114 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.5.5 0 0 0 .042-.028l4.012-2.954a.5.5 0 0 0 .106-.699z" fill="white"></path>

                    </svg>
                    Reply
                </button>
            </div>
        </div>


        <!-- Delete Modal -->
        <div id="delete-modal'.$student_Id.'" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full h-auto max-w-md max-h-full">
            <form method="post" id="delete_student'.$student_Id.'">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="delete-modal'.$student_Id.'">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    
                    <div class="p-6 text-center">
                    
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <input type="hidden" name="student_id" value="' . $student_Id . '" />
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah kamu yakin untuk menghapus data siswa '.$row['nama_lengkap'].'?</h3>
                        <button name="student_delete" data-modal-toggle="delete-modal'.$student_Id.'" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Yes, I am sure</button>
                        <button data-modal-toggle="delete-modal'.$student_Id.'" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>

                    </div>

                    <h3 class="text-center text-base font-bold border-y border-black py-2 mb-4">DATA PENDAFTARAN SPMB</h3>

                    <!-- DATA SISWA -->
                    <div class="border border-gray-400 p-4 rounded-lg mb-6">
                        <h4 class="text-lg font-bold mb-2">DATA SISWA</h4>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                           <div class="col-span-1 flex justify-center items-center">
                                <img src="../spmb/uploads/<?= htmlspecialchars($row['foto_pas']) ?>" 
     onerror="this.src='<?= $defaultavatar ?>'" 
     class="w-[113px] h-[151px] object-cover">

                </div>
                            <div class="col-span-2 grid grid-cols-2 gap-2 text-sm">
 <!-- Nama -->
<div class="bg-gray-100 p-2 rounded flex items-start gap-1">
  <span class="w-28 font-semibold">Nama</span>
  <span>:</span>
  <span class="flex-1 break-words"><?= htmlspecialchars($row['nama_lengkap']) ?></span>
</div>


<!-- NIS -->
<div class="bg-gray-100 p-2 rounded flex items-start">
  <span class="w-28 font-semibold">NIS</span>
  <span class="mr-1">:</span>
  <span class="break-words"><?= htmlspecialchars($row['nis']) ?></span>
</div>


<!-- Jenis Kelamin -->
<div class="bg-gray-100 p-2 rounded flex items-start">
  <span class="w-28 font-semibold">Jenis Kelamin</span>
  <span class="mr-1">:</span>
  <span class="break-words"><?= htmlspecialchars($row['jenis_kelamin']) ?></span>
</div>

<!-- NIK -->
<div class="bg-gray-100 p-2 rounded flex items-start">
  <span class="w-28 font-semibold">NIK</span>
  <span class="mr-1">:</span>
  <span class="break-words"><?= htmlspecialchars($row['nik']) ?></span>
</div>

<!-- TTL -->
<div class="bg-gray-100 p-2 rounded flex items-start">
  <span class="w-28 font-semibold">TTL</span>
  <span class="mr-1">:</span>
  <span class="break-words">
    <?= htmlspecialchars($row['tempat_lahir']) ?>, <?= htmlspecialchars($row['tanggal_lahir']) ?>
  </span>
</div>


                                <?php
                                $fields = [
                                    'Agama' => 'agama', 'Alamat' => 'alamat_tinggal', 'Transportasi' => 'moda_transportasi',
                                    'Anak Ke' => 'anak_keberapa', 'Jumlah Saudara' => 'jumlah_saudara_kandung',
                                    'No. Telp' => 'no_telp', 'Penerima KIP' => 'penerima_kip', 'No. KIP' => 'no_kip',
                                    'Tinggi (cm)' => 'tinggi_cm', 'Berat (kg)' => 'berat_kg', 'Jarak (km)' => 'jarak_tempat_tinggal'
                                ];
                                foreach ($fields as $label => $field) {
    echo '
    <div class="bg-gray-100 p-2 rounded flex items-start">
        <span class="w-28 font-semibold">'.htmlspecialchars($label).'</span>
        <span class="mr-1">:</span>
        <span class="break-words">'.htmlspecialchars($row[$field]).'</span>
    </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- DATA AYAH -->
                    <div class="border border-gray-400 p-4 rounded-lg mb-6">
                        <h4 class="text-lg font-bold mb-2">DATA AYAH</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <?php
                            $ayahFields = [
                                'Nama' => 'nama_ayah', 'NIK' => 'nik_ayah', 'Tempat Lahir' => 'tempat_lahir_ayah',
                                'Tanggal Lahir' => 'tanggal_lahir_ayah', 'Pendidikan' => 'pendidikan_ayah',
                                'Pekerjaan' => 'pekerjaan_ayah', 'Penghasilan' => 'penghasilan_ayah',
                                'No. Telp' => 'no_telp_ayah'
                            ];
                            foreach ($ayahFields as $label => $field) {
                               echo '
    <div class="bg-gray-100 p-2 rounded flex items-start">
        <span class="w-28 font-semibold">'.htmlspecialchars($label).'</span>
        <span class="mr-1">:</span>
        <span class="break-words">'.htmlspecialchars($row[$field]).'</span>
    </div>'; }
                            ?>
                        </div>
                    </div>

                    <!-- DATA IBU -->
                    <div class="border border-gray-400 p-4 rounded-lg mb-6 page-break">
                        <h4 class="text-lg font-bold mb-2">DATA IBU</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <?php
                            $ibuFields = [
                                'Nama' => 'nama_ibu', 'NIK' => 'nik_ibu', 'Tempat Lahir' => 'tempat_lahir_ibu',
                                'Tanggal Lahir' => 'tanggal_lahir_ibu', 'Pendidikan' => 'pendidikan_ibu',
                                'Pekerjaan' => 'pekerjaan_ibu', 'Penghasilan' => 'penghasilan_ibu',
                                'No. Telp' => 'no_telp_ibu'
                            ];
                            foreach ($ibuFields as $label => $field) {
                                echo '
    <div class="bg-gray-100 p-2 rounded flex items-start">
        <span class="w-28 font-semibold">'.htmlspecialchars($label).'</span>
        <span class="mr-1">:</span>
        <span class="break-words">'.htmlspecialchars($row[$field]).'</span>
    </div>'; }
                            ?>
                        </div>
                    </div>
                </div>

               
               <!-- Tombol Cetak & Tutup Sampingan -->
<div class="flex justify-end gap-3 border-t pt-4 mt-4">
    <button onclick="printModal('previewModal<?= $student_Id ?>')" 
        class="no-print bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
        Cetak
    </button>
    <button data-modal-hide="previewModal<?= $student_Id ?>" 
        class="no-print bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded shadow">
        Tutup
    </button>
</div>

            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal<?= $student_Id ?>" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="relative w-full max-w-md mx-auto mt-20">
            <form method="POST" class="bg-white rounded-lg shadow">
                <div class="p-6 text-center">
                    <input type="hidden" name="student_id" value="<?= $student_Id ?>">
                    <h3 class="text-lg text-gray-800 mb-4">Yakin ingin menghapus data siswa <strong><?= htmlspecialchars($row['nama_lengkap']) ?></strong>?</h3>
                    <button name="student_delete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya, Hapus</button>
                    <button type="button" data-modal-hide="deleteModal<?= $student_Id ?>" class="ml-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
</main>



    <!-- Konten utama -->
    <main class="flex-1 container mx-auto px-4 py-10">
        <!-- ...konten halaman... -->
    </main>

    <?php include('../includes/admin_footer.php') ?>
</body>


<!-- CETAK SCRIPT -->
<script>
function printModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const printContent = modal.querySelector('.bg-white').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Cetak Data SPMB</title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet">
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
            img { max-width: 100%; height: auto; }
            @media print {
                .no-print { display: none; }
            } .page-break { page-break-before: always; }
               

            </style>
        </head>
        <body onload="window.print(); window.close();">
            ${printContent}
        </body>
        </html>
    `);
    printWindow.document.close();
}
</script>
</body>
</html>
