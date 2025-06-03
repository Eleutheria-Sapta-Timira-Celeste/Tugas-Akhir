<?php
require 'db.php';

// Insert Attendance Record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guru_id = $_POST['guru_id'];
    $keterangan = $_POST['keterangan'];

    $query = $conn->prepare("INSERT INTO absenguru (guru_id, keterangan) VALUES (?, ?)");
    $query->bind_param("is", $guru_id, $keterangan);

    if ($query->execute()) {
        echo "<p class='text-green-500 font-bold'>Absensi berhasil disimpan!</p>";
    } else {
        echo "<p class='text-red-500 font-bold'>Gagal menyimpan absensi.</p>";
    }
}

// Fetch Attendance Records
$absensi = $conn->query("SELECT a.*, g.name FROM absenguru a JOIN guru g ON a.guru_id = g.id ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Form Absensi Guru</h2>
        <form method="post">
            <input type="number" name="guru_id" placeholder="ID Guru" class="w-full mb-3 p-2 border rounded">
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
        <h2 class="text-2xl font-bold mb-4">Data Absensi Guru</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2 border">Nama Guru</th>
                    <th class="p-2 border">Keterangan</th>
                    <th class="p-2 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $absensi->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-2 border"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['tanggal']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>