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

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Form Absensi Siswa</h2>
        <form method="post">
            <input type="text" name="nama_siswa" placeholder="Nama Siswa" class="w-full mb-3 p-2 border rounded">
            <input type="text" name="kelas" placeholder="Kelas" class="w-full mb-3 p-2 border rounded">
            <label class="block mb-2 font-semibold">Keterangan:</label>
            <select name="keterangan" class="w-full p-2 border rounded">
                <option value="Hadir">Hadir</option>
                <option value="Alpha">Alpha</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 w-full rounded mt-4">Simpan Absensi</button>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-6">
        <h2 class="text-2xl font-bold mb-4">Data Absensi Siswa</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2 border">Nama Siswa</th>
                    <th class="p-2 border">Kelas</th>
                    <th class="p-2 border">Keterangan</th>
                    <th class="p-2 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $absensi->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-2 border"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['kelas']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>