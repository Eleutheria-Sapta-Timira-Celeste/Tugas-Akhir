<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Reset notifikasi
mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = 0 WHERE id = 2");

if (isset($_POST['feedbackDelete'])) {
    $feedback__Id = $_POST["feedback_id"];
    mysqli_query($connection, "DELETE FROM `contactfeedback` WHERE id = $feedback__Id;");
    echo '<script>window.location.replace("index.php?page=feedback");</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        body {
            background-color: #ffffff !important;
        }
        .bg-white-force {
            background-color: #ffffff !important;
        }
    </style>
</head>

<body class="bg-white">
   

    <!-- Header Section -->
    <section class="text-gray-600 body-font bg-white">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #ef6c00;">Umpan Balik Sekolah</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                    Jelajahi Panel Admin untuk Sistem Umpan Balik Sekolah SMP PGRI 371 Pondok Aren. Kelola dan analisis umpan balik pengguna dari situs web secara efisien, memudahkan pengambilan keputusan yang tepat untuk perbaikan berkelanjutan.
                </p>
            </div>
        </div>
    </section>

    <!-- Tabel Feedback -->
    <section class="bg-white p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-white uppercase" style="background-color: #fc941e;">
                            <tr>
                                <th scope="col" class="px-4 py-4">Tanggal</th>
                                <th scope="col" class="px-4 py-3">Dikirim Oleh</th>
                                <th scope="col" class="px-4 py-3">Pesan</th>
                                <th scope="col" class="px-4 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $feedbacks = mysqli_query($connection, "SELECT * FROM `contactfeedback` ORDER BY id DESC;");
                            while ($row = mysqli_fetch_assoc($feedbacks)) {
                                $feedbackId = $row['id'];
                                echo '
                                <tr class="border-b">
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">'.$row['date'].' '.$row['time'].'</td>
                                    <td class="px-4 py-3">'.$row['name'].'</td>
                                    <td class="px-4 py-3 max-w-[5rem] truncate">'.$row['message'].'</td>
                                    <td class="px-4 py-3 text-right">
                                        <button id="showOption'.$feedbackId.'" data-dropdown-toggle="option'.$feedbackId.'" class="p-1.5 text-gray-500 hover:text-gray-800">
                                            <svg class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                        </button>
                                        <div id="option'.$feedbackId.'" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                                            <ul class="py-1 text-sm text-gray-700" aria-labelledby="showOption'.$feedbackId.'">
                                                <li>
                                                    <button type="button" data-modal-target="readProductModal'.$feedbackId.'" data-modal-toggle="readProductModal'.$feedbackId.'" class="flex w-full items-center py-2 px-4 hover:bg-gray-100">
                                                        👁️ Pratinjau
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" data-modal-target="deleteModal'.$feedbackId.'" data-modal-toggle="deleteModal'.$feedbackId.'" class="flex w-full items-center py-2 px-4 text-red-600 hover:bg-gray-100">
                                                        🗑️ Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Preview -->
                                <div id="readProductModal'.$feedbackId.'" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
                                    <div class="bg-white rounded-lg p-6 max-w-xl w-full">
                                        <h2 class="text-lg font-semibold text-gray-900 mb-1">Dikirim Oleh: '.$row['name'].'</h2>
                                        <p class="text-sm text-gray-500 mb-4">'.$row['date'].' '.$row['time'].'</p>
                                        <p class="mb-2"><strong>Email:</strong> '.$row['email'].'</p>
                                        <p><strong>Pesan:</strong><br>'.$row['message'].'</p>
                                        <div class="flex justify-end mt-4 gap-2">
                                            <button onclick="window.location.href=`mailto:'.$row['email'].'`" class="bg-[#ef6c00] hover:bg-[#cc5200] text-white px-4 py-2 rounded">Balas</button>
                                            <button data-modal-hide="readProductModal'.$feedbackId.'" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded">Tutup</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div id="deleteModal'.$feedbackId.'" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 text-center">Yakin ingin menghapus?</h3>
        <form method="post">
            <input type="hidden" name="feedback_id" value="'.$feedbackId.'" />
            <div class="flex justify-center gap-4 mt-4">
                <button data-modal-hide="deleteModal'.$feedbackId.'" type="button" class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button name="feedbackDelete" type="submit" class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

   
</body>
</html>
