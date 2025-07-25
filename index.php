<?php
include 'connection/database.php';

// Ambil media video utama (optional)
$videoResult = mysqli_query($connection, "SELECT * FROM media WHERE type = 'video' AND position = 'home' ORDER BY uploaded_at DESC LIMIT 1");
$topVideo = mysqli_fetch_assoc($videoResult);


try {

    $query = "SELECT * FROM web_content WHERE id = 1";
    $flash_query = "SELECT * FROM flash_notice WHERE id = 1";

    $result = mysqli_query($connection, $query);
    $flash_result = mysqli_query($connection, $flash_query);



    if ($result) {

        $row = mysqli_fetch_assoc($result);
        $flash_notice = mysqli_fetch_assoc($flash_result);

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

        /* Modal awalnya transparan dan invisible */
    #info-popup {
      opacity: 0;
      pointer-events: none; /* biar ga bisa diklik saat transparan */
      transition: opacity 1.5s ease;
    }

    /* Class aktif untuk fade-in */
    #info-popup.show {
      opacity: 1;
      pointer-events: auto; /* aktifkan klik */
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
<div id="info-popup" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
  <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 p-6 relative">

    <button id="close-modal" aria-label="Tutup"
            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 transition text-xl font-bold">&times;</button>

    <div class="text-center mb-4">
      <h2 class="text-xl font-bold text-gray-800"><?= $flash_notice['title'] ?></h2>
      <p class="text-xs text-gray-500">Info terbaru dari SMP PGRI 371</p>
    </div>

    <?php if (!empty($flash_notice['image_url'])) : ?>
    <div class="mb-4 rounded-md overflow-hidden">
      <img src="<?= $flash_notice['image_url'] ?>" alt="Notice Image" class="w-full h-50 object-cover rounded-md shadow">
    </div>
    <?php endif; ?>

    <p class="text-sm text-gray-700 text-center leading-snug mb-5">
      <?= $flash_notice['message'] ?>
    </p>

   <div class="flex flex-col sm:flex-row justify-center gap-4">
      <a href="aboutus.php"
         class="inline-flex justify-center items-center text-sm font-semibold text-[#a9745a] hover:underline transition">
         Pelajari lebih lanjut
      </a>
      <button onclick="document.getElementById('info-popup').style.display='none'"
              class="bg-[#5c3d15] hover:bg-[#4b320f] text-white px-6 py-2 rounded-lg text-sm font-semibold shadow transition">
        Tutup
      </button>
    </div>
  </div>
</div>
<?php endif; ?>








<script>
  document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("info-popup");
    if (!modal) return;

    // Modal awal hidden dengan opacity 0 dan pointer-events:none
    // Kita tambah class show agar fade in
    setTimeout(() => {
      modal.classList.add("show");
    }, 100); // delay kecil supaya animasi jalan halus

    // Close button
    const closeBtn = document.getElementById("close-modal");
    closeBtn.addEventListener("click", () => {
      // fade out sebelum hide
      modal.classList.remove("show");
      setTimeout(() => {
        modal.style.display = "none";
      }, 1500); // sama dengan durasi transisi
    });
  });
</script>


</body>


</html>
