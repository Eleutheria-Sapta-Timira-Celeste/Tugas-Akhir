<?php
require 'db.php';

// Insert Attendance Record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $keterangan = $_POST['keterangan'];

    $query = $conn->prepare("INSERT INTO absensiswa (nama_siswa, kelas, keterangan) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nama_siswa, $kelas, $keterangan);

    if ($query->execute()) {
        echo "<p class='text-green-500 font-bold'>Absensi berhasil disimpan!</p>";
    } else {
        echo "<p class='text-red-500 font-bold'>Gagal menyimpan absensi.</p>";
    }
}

// Fetch Attendance Records
$absensi = $conn->query("SELECT * FROM absensiswa ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-gradient-to-tr from-blue-200 via-white to-green-100 p-8 rounded-2xl shadow-xl mt-8">
    <h2 class="text-3xl font-extrabold mb-6 flex items-center gap-2">
        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zm0 0c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0v8"></path></svg>
        Form Absensi Siswa
    </h2>
    <form method="post" class="space-y-4">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nama Siswa</label>
            <input type="text" name="nama_siswa" placeholder="Nama Siswa" required
                class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Kelas</label>
            <input type="text" name="kelas" placeholder="Kelas" required
                class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Keterangan</label>
            <select name="keterangan" class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                <option value="Hadir">Hadir</option>
                <option value="Alpha">Alpha</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        <button type="submit"
            class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold text-lg shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 flex items-center justify-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
            Simpan Absensi
        </button>
    </form>
</div>

    <!-- Attendance Table -->
<div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-xl mt-8">
    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17v-2a4 4 0 0 1 8 0v2M5 21h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2z"></path></svg>
        Data Absensi Siswa
    </h2>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-green-400 text-white">
                    <th class="p-3 text-left">Nama Siswa</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Keterangan</th>
                    <th class="p-3 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $absensi->fetch_assoc()) { ?>
                    <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                        <td class="p-3"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['kelas']) ?></td>
                        <td class="p-3">
                            <?php
                                $badgeColor = [
                                    'Hadir' => 'bg-green-100 text-green-700',
                                    'Alpha' => 'bg-red-100 text-red-700',
                                    'Izin'  => 'bg-yellow-100 text-yellow-700',
                                    'Sakit' => 'bg-blue-100 text-blue-700'
                                ];
                                $ket = htmlspecialchars($row['keterangan']);
                                $color = $badgeColor[$ket] ?? 'bg-gray-100 text-gray-700';
                            ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $color ?>">
                                <?= $ket ?>
                            </span>
                        </td>
                        <td class="p-3"><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>