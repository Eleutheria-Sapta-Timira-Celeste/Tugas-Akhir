<?php
include 'connection/database.php';

// Ambil media video utama (optional)
$videoResult = mysqli_query($connection, "SELECT * FROM media WHERE type = 'video' ORDER BY uploaded_at DESC LIMIT 1");
$topVideo = mysqli_fetch_assoc($videoResult);


try {
    $query = "SELECT * FROM web_content WHERE id = 1";
    $flash_query = "SELECT * FROM flash_notice WHERE id = 1";

    $result = mysqli_query($connection, $query);
    $flash_result = mysqli_query($connection, $flash_query);

    if ($result && $flash_result) {
        $row = mysqli_fetch_assoc($result) ?? [];
        $flash_notice = mysqli_fetch_assoc($flash_result) ?? [];
    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    mysqli_close($connection);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda</title>
  <link rel="stylesheet" href="css/utilities.css">
  <link rel="stylesheet" href="css/animation.css">
  <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">
  <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
  <style>
    @keyframes gradientFlow {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .animate-gradient {
      background-size: 300% 300%;
      animation: gradientFlow 8s ease infinite;
    }
  </style>
</head>
<body>

<?php include('includes/header.php') ?>

<?php if ($topVideo): ?>
  <div class="relative w-full h-[500px] overflow-hidden mb-6">
    <video class="w-full h-full object-cover" autoplay muted loop>
      <source src="<?= $topVideo['path'] ?>" type="video/mp4">
      Browser tidak mendukung video.
    </video>
    
  </div>
<?php endif; ?>


<!-- Judul -->
<div class="text-center mt-10">
  <h2 class="text-3xl font-bold text-[#8A6640] border-b-4 inline-block border-[#8A6640] mb-0">
    SMP PGRI 371 Pondok Aren
  </h2>
</div>

<!-- Fitur Sekolah -->
<section class="container mx-auto p-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
  <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
    <h3 class="text-2xl font-bold text-gray-800">📚 Pendidikan Berkualitas</h3>
    <p class="text-gray-600">Menyediakan kurikulum terbaik dengan tenaga pendidik berpengalaman.</p>
  </div>
  <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
    <h3 class="text-2xl font-bold text-gray-800">🏆 Prestasi Luar Biasa</h3>
    <p class="text-gray-600">Murid-murid kami telah meraih keberhasilan akademik dan non-akademik.</p>
  </div>
  <div class="bg-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-105 hover:rotate-2 hover:shadow-2xl hover:bg-gray-100">
    <h3 class="text-2xl font-bold text-gray-800">🌎 Fasilitas Modern</h3>
    <p class="text-gray-600">Laboratorium, perpustakaan, dan ruang kelas yang nyaman untuk pembelajaran maksimal.</p>
  </div>
  <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg shadow-xl p-6 transform transition duration-300 hover:scale-110 hover:shadow-2xl flex flex-col items-center justify-center hover:bg-gradient-to-l">
    <h3 class="text-2xl font-extrabold">🚀 Bergabung Bersama Kami!</h3>
    <p class="text-lg text-gray-100 text-center mt-2">Jadilah bagian dari perjalanan pendidikan yang luar biasa.</p>
    <a href="spmb/index.php" class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg shadow-md transition hover:scale-105 hover:rotate-2">
      🔰 Daftar Sekarang
    </a>
  </div>
</section>

<!-- Konten Dinamis -->
<section class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
  <div class="bg-white p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-lg hover:bg-gray-100 transition duration-300">
    <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-[#8A6640] pb-2">
      Kenapa Memilih SMP PGRI 371 Pondok Aren?
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed"><?= isset($row['two']) ? $row['two'] : '' ?></p>
  </div>
  <div class="bg-white p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-lg hover:bg-gray-100 transition duration-300">
    <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-[#8A6640] pb-2">
      Apa yang Murid Katakan Tentang Sekolah?
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed"><?= isset($row['seven']) ? $row['seven'] : '' ?></p>
  </div>
</section>

<section class="container mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
  <div class="bg-white p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-lg hover:bg-gray-100 transition duration-300">
    <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-[#8A6640] pb-2">
      Ujian Berbasis Online
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed"><?= isset($row['eight']) ? $row['eight'] : '' ?></p>
  </div>
  <div class="bg-white p-6 rounded-lg shadow-md hover:scale-105 hover:shadow-lg hover:bg-gray-100 transition duration-300">
    <h1 class="text-3xl font-bold text-gray-800 border-b-2 border-[#8A6640] pb-2">
      Fasilitas & Teknologi di SMP PGRI 371
    </h1>
    <p class="text-lg text-gray-700 leading-relaxed">
      Sekolah kami menyediakan fasilitas modern yang mendukung pembelajaran berbasis teknologi. Mulai dari laboratorium komputer terkini hingga sistem ujian online, kami memastikan setiap murid memperoleh pengalaman pendidikan terbaik.
    </p>
  </div>
</section>

<?php include('includes/footer.php') ?>

<?php if (isset($flash_notice['trun_flash']) && $flash_notice['trun_flash'] === "1") : ?>
<div id="info-popup" tabindex="-1" class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
  <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
    <div class="relative p-4 bg-white rounded-lg shadow md:p-8">
      <div class="mb-4 text-sm font-light text-black-500">
        <h3 class="mb-3 text-2xl font-bold text-gray-900"><?= $flash_notice['title'] ?></h3>
        <img class="object-cover w-full rounded-lg" src="<?= $flash_notice['image_url'] ?>" alt="">
        <p class="mt-3 font-bold"><?= $flash_notice['message'] ?></p>
      </div>
      <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">
        <a href="aboutus.php" style="color: #ef6c00;" class="font-medium hover:underline">Lihat Tentang Sekolah</a>
        <div class="items-center space-y-4 sm:space-x-4 sm:flex sm:space-y-0">
          <button id="close-modal" type="button"
                  style="background-color: #ef6c00;"
                  class="py-2 px-4 w-full text-sm font-medium text-white rounded-lg sm:w-auto hover:brightness-110 focus:ring-4 focus:outline-none focus:ring-orange-300">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
const modalEl = document.getElementById('info-popup');
if (modalEl) {
  const privacyModal = new Modal(modalEl, { placement: 'center' });
  privacyModal.show();
  document.getElementById('close-modal').addEventListener('click', () => privacyModal.hide());
}

setInterval(() => {
  const btn = document.getElementsByClassName('nextimage')[0];
  if (btn) btn.click();
}, 5000);
</script>

</body>
</html>
