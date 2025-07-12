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
                                        <td class="p-4">
                                            <button type="button" data-modal-target="previewModal'.$student_Id.'" data-modal-toggle="previewModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-blue-600 rounded">Pratinjau</button>
                                            <button type="button" data-modal-target="deleteModal'.$student_Id.'" data-modal-toggle="deleteModal'.$student_Id.'" class="px-3 py-1 text-sm text-white bg-red-600 rounded">Hapus</button>
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
