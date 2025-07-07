<?php include '../connection/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SPMB Online | Provinsi Banten</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      margin: 0;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">

  <!-- HEADER -->
  <?php include('../includes/header_spmb.php'); ?>

  <!-- MAIN -->
  <main class="flex-1 pt-[10px] pb-[60px]"> <!-- Padding agar tidak ketutupan header/footer -->
    <section class="bg-white p-6 shadow rounded mx-4">
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-xl font-semibold text-orange-700">SMP PGRI 371 Pondok Aren</h2>
          <p class="text-gray-700">Seleksi Penerimaan Murid Baru (SPMB) Tahun Ajaran 2025 / 2026</p>
        </div>
        <img src="../assects/images/defaults/foto_siswaspmb.png" class="h-28 animate-bounce" alt="Icon siswa" />
      </div>
    </section>

    <!-- Panduan Pendaftaran -->
    <section class="p-6 mx-4">
  <h3 class="text-lg font-semibold text-gray-800 mb-4">Panduan Tahapan Pendaftaran SPMB 2025</h3>
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
    
    <!-- 01 -->
    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
      <h4 class="font-bold mb-2">01. Calon Peserta Didik</h4>
      <p>Menyiapkan berkas persyaratan seperti fotokopi ijazah, KK, akta, dan pas foto.</p>
      <a href="persyaratan.php" class="text-orange-600 text-sm mt-2 inline-block hover:underline">Lihat Persyaratan</a>
    </div>

    <!-- 02 -->
    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
      <h4 class="font-bold mb-2">02. Calon Peserta Didik</h4>
      <p>Mengakses situs SPMB dan melakukan pendaftaran secara daring melalui link di bawah.</p>
      <a href="daftar.php" class="text-orange-600 text-sm mt-2 inline-block hover:underline">Daftar Online</a>
    </div>

    <!-- 03 -->
    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
      <h4 class="font-bold mb-2">03. Calon Peserta Didik</h4>
      <p>Melakukan cetak bukti pendaftaran/formulir setelah selesai mendaftar online.</p>
      <span class="text-orange-600 text-sm mt-2 inline-block italic">Cetak Formulir akan tersedia setelah pendaftaran selesai</span>

    </div>

    <!-- 04 -->
    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
      <h4 class="font-bold mb-2">04. Calon Peserta Didik</h4>
      <p>Membawa seluruh berkas persyaratan beserta bukti pendaftaran saat datang ke sekolah untuk verifikasi.</p>
      <a href="verifikasi.php" class="text-orange-600 text-sm mt-2 inline-block hover:underline">Panduan Verifikasi</a>
    </div>

    <!-- 05 -->
    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
      <h4 class="font-bold mb-2">05. Calon Peserta Didik</h4>
      <p>Selalu pantau informasi terbaru mengenai jadwal, hasil seleksi, dan pengumuman resmi.</p>
      <a href="informasi.php" class="text-orange-600 text-sm mt-2 inline-block hover:underline">Cek Informasi Terbaru</a>
    </div>

  </div>
</section>

  </main>

  <!-- FOOTER -->
  <?php include('../includes/spmb_footer.php'); ?>

</body>
</html>
