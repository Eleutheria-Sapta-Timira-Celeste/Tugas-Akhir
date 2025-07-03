<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kurikulum - SMP PGRI 371 Pondok Aren</title>
  <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
  <link rel="icon" type="image/x-icon" href="assets/images/logo2.png" />
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1.5rem;
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #ef6c00;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    td.center,
    th.center {
      text-align: center;
    }
  </style>
</head>

<body>
  <?php include("includes/header.php"); ?>

  <?php
    include("connection/database.php");
    $result = $connectionobj->query("SELECT * FROM konten_kurikulum LIMIT 1");
    $data = $result->fetch_assoc();
  ?>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-10 mx-auto text-center">
      <div class="flex flex-col w-full mb-10">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]">
          <?= htmlspecialchars($data['judul']) ?>
        </h1>

        <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
          <?= nl2br(htmlspecialchars($data['deskripsi_singkat'])) ?>
        </p>

        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 mt-10 text-[#ef6c00]">
          <?= htmlspecialchars($data['subjudul']) ?>
        </h1>

        <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
          <?= nl2br(htmlspecialchars($data['deskripsi_panjang'])) ?>
        </p>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php"); ?>
</body>

<script>
  console.clear();
</script>

</html>
