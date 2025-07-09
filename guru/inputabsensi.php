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

// Reset header absensi
if (isset($_POST['reset_header'])) {
    unset($_SESSION['absensi_header']);
    $pesan = "Header absensi telah direset!";
}

// Reset semua data absensi milik guru ini
if (isset($_POST['reset_tabel'])) {
    $stmt = $connection->prepare("DELETE FROM absensi WHERE guru = ? AND mapel = ?");
    $stmt->bind_param("ss", $nama, $mapel);
    if ($stmt->execute()) {
        $pesan = "Semua data absensi Anda untuk mapel ini telah dihapus!";
    } else {
        $pesan = "Gagal menghapus data absensi!";
    }
}

// Reset absensi per kelas
if (isset($_POST['reset_tabel_spesifik']) && isset($_POST['kelas_reset'])) {
    $kelas_reset = $_POST['kelas_reset'];
    $stmt = $connection->prepare("DELETE FROM absensi WHERE guru = ? AND mapel = ? AND kelas = ?");
    $stmt->bind_param("sss", $nama, $mapel, $kelas_reset);
    if ($stmt->execute()) {
        $pesan = "Data absensi kelas $kelas_reset berhasil dihapus.";
    } else {
        $pesan = "Gagal menghapus data absensi kelas $kelas_reset.";
    }
}

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
if (isset($_POST['simpan_semua']) && isset($_SESSION['absensi_header'])) {
    $h = $_SESSION['absensi_header'];
    $status_data = $_POST['status'];
    $jumlah_berhasil = 0;
    $jumlah_gagal = 0;

    $stmt_delete = $connection->prepare("DELETE FROM absensi WHERE guru = ? AND tanggal = ? AND jam = ?");
    $stmt_delete->bind_param("sss", $nama, $h['tanggal'], $h['jam']);
    $stmt_delete->execute();

    foreach ($status_data as $username_siswa => $status) {
        $stmt_siswa = $connection->prepare("SELECT nama, kelas FROM siswa WHERE username = ?");
        $stmt_siswa->bind_param("s", $username_siswa);
        $stmt_siswa->execute();
        $result_siswa = $stmt_siswa->get_result();

        if ($result_siswa->num_rows > 0) {
            $siswa = $result_siswa->fetch_assoc();
            $nama_siswa = $siswa['nama'];
            $kelas = $siswa['kelas'];

            $stmt_insert = $connection->prepare("INSERT INTO absensi (username, nama_siswa, guru, kelas, mapel, jam, status, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("ssssssss", $username_siswa, $nama_siswa, $nama, $kelas, $h['mapel'], $h['jam'], $status, $h['tanggal']);
            if ($stmt_insert->execute()) {
                $jumlah_berhasil++;
            } else {
                $jumlah_gagal++;
            }
        }
    }

    $pesan = "$jumlah_berhasil absensi berhasil disimpan.";
    if ($jumlah_gagal > 0) {
        $pesan .= " $jumlah_gagal gagal disimpan.";
    }
}

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
    <aside class="w-64 bg-[#F5E8C7] p-6 shadow-md">
        <nav class="space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 hover:bg-[#D9C38C]">🏠 Dashboard</a>
            <a href="inputabsensi.php" class="block px-4 py-2 bg-[#E4C988] rounded">📝 Input Absensi</a>
            <a href="Pengaturan.php" class="block px-4 py-2 hover:bg-[#D9C38C]">⚙ Pengaturan</a>
        </nav>
    </aside>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Form Input Absensi</h2>

        <?php if ($pesan): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <?php if (!$info): ?>
            <form method="post" class="bg-white p-6 rounded shadow border border-[#E4C988] max-w-xl mx-auto mb-8">
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
                <button type="submit" name="simpan_header" class="bg-[#C08261] text-white px-4 py-2 rounded w-full">Simpan Header</button>
            </form>
        <?php endif; ?>

        <?php if ($info): ?>
            <div class="bg-white p-4 rounded border border-[#E4C988] text-sm text-gray-800 mb-4">
                <div class="space-y-1">
                    <div class="flex"><div class="w-32 font-semibold">Guru</div><div>: <?= htmlspecialchars($nama) ?></div></div>
                    <div class="flex"><div class="w-32 font-semibold">Mapel</div><div>: <?= htmlspecialchars($mapel) ?></div></div>
                    <div class="flex"><div class="w-32 font-semibold">Kelas</div><div>: <?= htmlspecialchars($info['kelas']) ?></div></div>
                    <div class="flex"><div class="w-32 font-semibold">Tanggal</div><div>: <?= date('d/m/Y', strtotime($info['tanggal'])) ?></div></div>
                    <div class="flex"><div class="w-32 font-semibold">Jam</div><div>: <?= date('H:i', strtotime($info['jam'])) ?></div></div>
                </div>
                <form method="post" class="mt-3 text-center">
                    <button type="submit" name="reset_header" onclick="return confirm('Yakin ingin reset header absensi?')" class="bg-red-500 text-white px-4 py-2 rounded">🔄 Reset Header</button>
                </form>
            </div>

            <form method="post" class="bg-white p-6 rounded shadow border border-[#E4C988] overflow-auto mb-8">
                <h3 class="text-lg font-semibold text-[#C08261] mb-4 text-center">Daftar Kehadiran Siswa</h3>
                <table class="min-w-full border text-sm text-center mb-4">
                    <thead class="bg-[#F5E8C7] text-center text-gray-800">
    <tr>
        <th class="border px-1 py-1 align-middle" rowspan="2">No</th>
        <th class="border px-1 py-1 align-middle" rowspan="2">NISN</th>
        <th class="border px-1 py-1 align-middle" rowspan="2">Nama</th>
        <th class="border px-1 py-1" colspan="4">Kehadiran</th>
    </tr>
    <tr>
        <th class="border px-1 py-1">Hadir</th>
        <th class="border px-1 py-1">Izin</th>
        <th class="border px-1 py-1">Sakit</th>
        <th class="border px-1 py-1">Alpha</th>
    </tr>
</thead>

                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $kelas = $info['kelas'];
                        $siswa = $connection->query("SELECT username, nama, nis FROM siswa WHERE kelas = '$kelas' ORDER BY nama ASC");
                        while ($row = $siswa->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="border px-3 py-2"><?= $no++ ?></td>
                            <td class="border px-3 py-2"><?= htmlspecialchars($row['nis']) ?></td>
                            <td class="border px-3 py-2 text-left"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="border px-3 py-2"><input type="radio" name="status[<?= $row['username'] ?>]" value="Hadir" required></td>
                            <td class="border px-3 py-2"><input type="radio" name="status[<?= $row['username'] ?>]" value="Izin"></td>
                            <td class="border px-3 py-2"><input type="radio" name="status[<?= $row['username'] ?>]" value="Sakit"></td>
                            <td class="border px-3 py-2"><input type="radio" name="status[<?= $row['username'] ?>]" value="Alpha"></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="text-center">
                    <button type="submit" name="simpan_semua" class="bg-[#C08261] text-white px-6 py-2 rounded hover:bg-opacity-90">✅ Simpan Semua</button>
                </div>
            </form>
        <?php endif; ?>

        <!-- Riwayat -->
        <?php
        $stmt = $connection->prepare("SELECT * FROM absensi WHERE guru = ? AND mapel = ? ORDER BY kelas ASC, tanggal DESC, jam DESC");
        $stmt->bind_param("ss", $nama, $mapel);
        $stmt->execute();
        $result = $stmt->get_result();

        $grouped_absensi = [];
        while ($row = $result->fetch_assoc()) {
            $grouped_absensi[$row['kelas']][] = $row;
        }

        foreach ($grouped_absensi as $kelas => $data):
        ?>
        <div class="bg-white p-6 rounded shadow border border-[#E4C988] overflow-auto mt-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold text-[#C08261]">Riwayat Kelas <?= htmlspecialchars($kelas) ?> - Mapel <?= htmlspecialchars($mapel) ?></h3>
                <div class="space-x-2">
                    <a href="cetak_absensi.php?kelas=<?= urlencode($kelas) ?>&mapel=<?= urlencode($mapel) ?>" class="text-sm text-blue-600 underline">🖨 Cetak</a>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="kelas_reset" value="<?= htmlspecialchars($kelas) ?>">
                        <button type="submit" name="reset_tabel_spesifik" onclick="return confirm('Yakin ingin hapus semua absensi kelas ini?')" class="text-sm text-red-600 underline">🔄 Reset</button>
                    </form>
                </div>
            </div>
            <table class="min-w-full table-fixed border text-sm text-center">
    <thead class="bg-[#F5E8C7] text-gray-800">
        <tr>
            <th class="w-1/4 border px-4 py-2">Tanggal</th>
            <th class="w-1/4 border px-4 py-2">Jam</th>
            <th class="w-1/4 border px-4 py-2">Nama</th>
            <th class="w-1/4 border px-4 py-2">Status</th>
        </tr>
    </thead>

                <tbody>
                    <?php foreach ($data as $row): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars(date('H:i', strtotime($row['jam']))) ?></td>
                        <td class="border px-4 py-2 text-left"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endforeach; ?>
    </main>
</div>
<?php include('../includes/admin_footer.php'); ?>
</body>
</html>
