<?php
session_start();
include '../connection/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

$username = $_SESSION['username'];
$nama     = $_SESSION['nama']  ?? 'Guru';
$mapel    = $_SESSION['mapel'] ?? 'Mapel';

$pesan = "";

// Simpan header absensi
if (isset($_POST['simpan_header'])) {
    $_SESSION['absensi_header'] = [
        'kelas'   => $_POST['kelas'],
        'tanggal' => $_POST['tanggal'],
        'jam'     => $_POST['jam'],
        'mapel'   => $mapel
    ];
    $pesan = "Header absensi berhasil disimpan!";
}

// Simpan absensi siswa
if (isset($_POST['simpan_siswa']) && isset($_SESSION['absensi_header'])) {
    $h = $_SESSION['absensi_header'];
    $username_siswa = $_POST['username_siswa'];
    $status         = $_POST['status'];

    // Ambil data siswa
    $stmt_siswa = $connection->prepare("SELECT nama, kelas FROM siswa WHERE username = ?");
    $stmt_siswa->bind_param("s", $username_siswa);
    $stmt_siswa->execute();
    $result_siswa = $stmt_siswa->get_result();

    if ($result_siswa->num_rows > 0) {
        $siswa = $result_siswa->fetch_assoc();
        $nama_siswa = $siswa['nama'];
        $kelas      = $siswa['kelas'];

        // Cek apakah sudah pernah input absensi di tanggal dan jam yg sama (hindari double)
        $stmt_check = $connection->prepare("SELECT * FROM absensi WHERE username = ? AND tanggal = ? AND jam = ?");
        $stmt_check->bind_param("sss", $username_siswa, $h['tanggal'], $h['jam']);
        $stmt_check->execute();
        $check_result = $stmt_check->get_result();

        if ($check_result->num_rows == 0) {
            // Insert absensi
            $stmt_insert = $connection->prepare("INSERT INTO absensi (username, nama_siswa, kelas, mapel, jam, status, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("sssssss", $username_siswa, $nama_siswa, $kelas, $h['mapel'], $h['jam'], $status, $h['tanggal']);
            
            if ($stmt_insert->execute()) {
                $pesan = "Absensi untuk $nama_siswa berhasil disimpan!";
            } else {
                $pesan = "Gagal menyimpan absensi!";
            }
        } else {
            $pesan = "Absensi untuk $nama_siswa sudah ada!";
        }
    } else {
        $pesan = "Data siswa tidak ditemukan!";
    }
}

$data_absensi = $connection->query("SELECT * FROM absensi ORDER BY tanggal DESC LIMIT 50");
$info = $_SESSION['absensi_header'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFF9F0] flex flex-col min-h-screen">

<?php include('../includes/header_guru.php'); ?>

<div class="flex flex-1">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#F5E8C7] p-6 shadow-md">
        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 hover:bg-[#D9C38C]">🏠 Dashboard</a>
            <a href="inputabsensi.php" class="block px-4 py-2 bg-[#E4C988] rounded">📝 Input Absensi</a>
            <a href="Pengaturan.php" class="block px-4 py-2 hover:bg-[#D9C38C]">⚙️ Pengaturan</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Form Input Absensi</h2>

        <?php if ($pesan): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <!-- Form Header -->
        <?php if (!$info): ?>
        <form method="post" class="bg-white p-6 rounded shadow border border-[#E4C988] max-w-xl mb-8">
            <div class="mb-4">
                <label class="block">Hari & Tanggal</label>
                <input type="date" name="tanggal" required class="w-full px-3 py-2 rounded border bg-gray-100">
            </div>
            <div class="mb-4">
                <label class="block">Jam</label>
                <input type="time" name="jam" required class="w-full px-3 py-2 rounded border bg-gray-100">
            </div>
            <div class="mb-4">
                <label class="block">Kelas</label>
                <select name="kelas" required class="w-full px-3 py-2 rounded border bg-gray-100">
                    <option value="">-- Pilih Kelas --</option>
                    <option value="VII">VII</option>
                    <option value="VIII">VIII</option>
                    <option value="IX">IX</option>
                </select>
            </div>
            <button type="submit" name="simpan_header" class="bg-[#C08261] text-white px-4 py-2 rounded">Simpan Header</button>
        </form>
        <?php endif; ?>

        <!-- Info Header -->
        <?php if ($info): ?>
        <div class="bg-white p-4 rounded border border-[#E4C988] text-sm text-gray-800 mb-4">
            <div class="space-y-1 text-sm">
                <div class="flex"><div class="w-36 font-semibold">Guru</div><div>: <?= htmlspecialchars($nama) ?></div></div>
                <div class="flex"><div class="w-36 font-semibold">Mata Pelajaran</div><div>: <?= htmlspecialchars($info['mapel']) ?></div></div>
                <div class="flex"><div class="w-36 font-semibold">Kelas</div><div>: <?= htmlspecialchars($info['kelas']) ?></div></div>
                <div class="flex"><div class="w-36 font-semibold">Tanggal</div><div>: <?= date('d/m/Y', strtotime($info['tanggal'])) ?></div></div>
                <div class="flex"><div class="w-36 font-semibold">Jam</div><div>: <?= date('H.i', strtotime($info['jam'])) ?></div></div>
            </div>
        </div>

        <!-- Form Input Nama & Status -->
        <form method="post" class="bg-white p-6 rounded shadow border border-[#E4C988] max-w-xl mb-10">
            <div class="mb-4">
                <label class="block">Nama Siswa</label>
                <select name="username_siswa" required class="w-full px-3 py-2 rounded border bg-gray-100">
                    <option value="">-- Pilih Siswa --</option>
                    <?php
                    $kelas_q = $connection->real_escape_string($info['kelas']);
                    $siswa_q = $connection->query("SELECT username, nama FROM siswa WHERE kelas = '$kelas_q' ORDER BY nama ASC");
                    while ($s = $siswa_q->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($s['username']) . '">' . htmlspecialchars($s['nama']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block">Status Kehadiran</label>
                <select name="status" required class="w-full px-3 py-2 rounded border bg-gray-100">
                    <option value="">-- Pilih --</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpha">Alpha</option>
                </select>
            </div>
            <button type="submit" style="background-color: #ef6c00;" class="hover:opacity-90 text-white px-4 py-2 rounded">Simpan Kehadiran</button>
        </form>
        <?php endif; ?>

        <!-- Tabel Absensi -->
<<<<<<< HEAD
        <div class="bg-white p-6 rounded shadow border border-[#E4C988] overflow-auto">
            <h3 class="text-xl font-semibold text-[#C08261] mb-4">Data Absensi Terbaru</h3>
            <table class="min-w-full table-auto border text-sm text-left">
                <thead class="bg-[#F5E8C7] text-gray-800">
                    <tr>
                        <th class="border px-4 py-2">Tanggal</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Kelas</th>
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $data_absensi->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['kelas']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($info): ?>
    <!-- Tombol Cetak -->

    <div class="bg-white p-6 rounded shadow border border-[#] overflow-auto mt-6">
        <form action="cetak_absensi.php" method="get" target="_blank">
            <input type="hidden" name="kelas" value="<?= htmlspecialchars($info['kelas']) ?>">
            <input type="hidden" name="tanggal" value="<?= htmlspecialchars($info['tanggal']) ?>">
            <input type="hidden" name="jam" value="<?= htmlspecialchars($info['jam']) ?>">
            <button type="submit" style="background-color: #ef6c00;" class="hover:opacity-90 text-white px-4 py-2 rounded">
    🖨️ Cetak Absensi
</button>
        </form>
    </div>
<?php endif; ?>
        </div>
=======
       <!-- Tabel Absensi -->
<div class="bg-white p-6 rounded shadow border border-[#E4C988] overflow-auto">
    <h3 class="text-xl font-semibold text-[#C08261] mb-4">Data Absensi Terbaru</h3>
    <table class="min-w-full table-auto border text-sm text-left">
        <thead class="bg-[#F5E8C7] text-gray-800">
            <tr>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Jam</th> <!-- Kolom baru -->
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Kelas</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $data_absensi->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100">
                <td class="border px-4 py-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars(date('H:i', strtotime($row['jam']))) ?></td> <!-- Jam -->
                <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['kelas']) ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

>>>>>>> 463c37e5efe5526b91dfece515aab9714be0101f
    </main>
</div>

<?php include('../includes/admin_footer.php'); ?>

</body>
</html>
