<?php
session_start();
include 'cek_login.php';
include 'koneksi.php';

$username = $_SESSION['username'];
$nip      = $_SESSION['nip'];
$nama     = $_SESSION['nama'];
$mapel    = $_SESSION['mapel'];
$foto     = $_SESSION['foto'] ?? 'default.png';

$pesan = "";

// Reset semua absensi
if (isset($_POST['reset'])) {
    if ($conn->query("DELETE FROM absensi")) {
        unset($_SESSION['absensi_header']);
        $pesan = "Data absensi berhasil direset.";
    } else {
        $pesan = "Gagal mereset data absensi.";
    }
}

// Simpan header hanya sekali
if (isset($_POST['simpan_header'])) {
    $_SESSION['absensi_header'] = [
        'mapel'   => $_POST['mapel'],
        'tanggal' => $_POST['tanggal'],
        'jam'     => $_POST['jam'],
        'kelas'   => $_POST['kelas']
    ];
}

// Simpan absensi siswa
if (isset($_POST['simpan_siswa']) && isset($_SESSION['absensi_header'])) {
    $h = $_SESSION['absensi_header'];
    $nama_siswa = $_POST['nama_siswa'];
    $status     = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO absensi (mapel, tanggal, jam, kelas, nama_siswa, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $h['mapel'], $h['tanggal'], $h['jam'], $h['kelas'], $nama_siswa, $status);
    if ($stmt->execute()) {
        $pesan = "Absensi berhasil disimpan!";
    } else {
        $pesan = "Gagal menyimpan absensi.";
    }
}

$data_absensi = $conn->query("SELECT * FROM absensi ORDER BY nama_siswa ASC LIMIT 50");
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

<?php include('../includes/header_siswa.php'); ?>

<div class="flex flex-1">
    <aside class="w-64 bg-[#F5E8C7] p-6 shadow-md">
        <nav class="space-y-4">
            <a href="dashboardguru.php" class="block px-4 py-2 hover:bg-[#D9C38C]">🏠 Dashboard</a>
            <a href="input_absensi.php" class="block px-4 py-2 bg-[#E4C988] rounded">📝 Input Absensi</a>
            <a href="jadwalmengajar.php" class="block px-4 py-2 hover:bg-[#D9C38C]">📅 Jadwal Mengajar</a>
            <a href="Pengaturan.php" class="block px-4 py-2 hover:bg-[#D9C38C]">⚙️ Pengaturan</a>
        </nav>
    </aside>

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
            <input type="hidden" name="mapel" value="<?= htmlspecialchars($mapel) ?>">
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

        <!-- Informasi Absensi -->
        <?php if ($info): ?>
        <div class="bg-white p-4 rounded border border-[#E4C988] text-sm text-gray-800 mb-4">
            <div class="space-y-1 text-sm">
                <div class="flex">
                    <div class="w-36 font-semibold">Guru</div>
                    <div>: <?= htmlspecialchars($nama) ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-semibold">Mata Pelajaran</div>
                    <div>: <?= htmlspecialchars($info['mapel']) ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-semibold">Kelas</div>
                    <div>: <?= htmlspecialchars($info['kelas']) ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-semibold">Tanggal</div>
                    <div>: <?= date('d/m/Y', strtotime($info['tanggal'])) ?></div>
                </div>
                <div class="flex">
                    <div class="w-36 font-semibold">Jam</div>
                    <div>: <?= date('H.i', strtotime($info['jam'])) ?></div>
                </div>
            </div>
        </div>

        <!-- Form Input Nama & Status -->
        <form method="post" class="bg-white p-6 rounded shadow border border-[#E4C988] max-w-xl mb-10">
            <div class="mb-4">
                <label class="block">Nama Siswa</label>
                <input type="text" name="nama_siswa" required class="w-full px-3 py-2 rounded border bg-gray-100">
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
            <button type="submit" name="simpan_siswa" class="bg-[#C08261] text-white px-4 py-2 rounded">Simpan Kehadiran</button>
        </form>
        <?php endif; ?>

        <!-- Tabel Absensi -->
        <div class="bg-white p-6 rounded shadow border border-[#E4C988] overflow-auto">
            <h3 class="text-xl font-semibold text-[#C08261] mb-4">Data Absensi Terbaru</h3>
            <table class="min-w-full table-auto border text-sm text-left">
                <thead class="bg-[#F5E8C7] text-gray-800">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $data_absensi->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2"><?= $no++ ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Tombol Reset -->
            <form method="post" onsubmit="return confirm('Yakin ingin reset semua data absensi?')" class="mt-6">
                <button type="submit" name="reset" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    🔄 Reset Semua Absensi
                </button>
            </form>

            <!-- Tombol Cetak -->
<a href="cetak_absensi.php" target="_blank" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    🖨️ Cetak Absensi
</a>
        </div>
    </main>
</div>

<?php include('../includes/admin_footer.php'); ?>
</body>
</html>
