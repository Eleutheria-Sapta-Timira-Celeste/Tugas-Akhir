<?php
require 'db.php';

// Insert Schedule Record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guru_id = $_POST['guru_id'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $kelas = $_POST['kelas'];
    $mapel = $_POST['mapel'];

    $query = $conn->prepare("INSERT INTO jadwalmengajar (guru_id, hari, jam_mulai, jam_selesai, kelas, mapel) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("isssss", $guru_id, $hari, $jam_mulai, $jam_selesai, $kelas, $mapel);

    if ($query->execute()) {
        echo "<p class='text-green-500 font-bold'>Jadwal berhasil disimpan!</p>";
    } else {
        echo "<p class='text-red-500 font-bold'>Gagal menyimpan jadwal.</p>";
    }
}

// Fetch Schedules
$jadwal = $conn->query("SELECT j.*, g.name FROM jadwalmengajar j JOIN guru g ON j.guru_id = g.id ORDER BY hari");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Mengajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Form Jadwal Mengajar</h2>
        <form method="post">
            <input type="number" name="guru_id" placeholder="ID Guru" class="w-full mb-3 p-2 border rounded">
            <label class="block mb-2 font-semibold">Hari:</label>
            <select name="hari" class="w-full p-2 border rounded">
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
            </select>
            <input type="time" name="jam_mulai" placeholder="Jam Mulai" class="w-full mb-3 p-2 border rounded">
            <input type="time" name="jam_selesai" placeholder="Jam Selesai" class="w-full mb-3 p-2 border rounded">
            <input type="text" name="kelas" placeholder="Kelas" class="w-full mb-3 p-2 border rounded">
            <input type="text" name="mapel" placeholder="Mapel" class="w-full mb-3 p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white p-2 w-full rounded mt-4">Simpan Jadwal</button>
        </form>
    </div>

    <!-- Schedule Table -->
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-6">
        <h2 class="text-2xl font-bold mb-4">Data Jadwal Mengajar</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2 border">Guru</th>
                    <th class="p-2 border">Hari</th>
                    <th class="p-2 border">Jam Mulai</th>
                    <th class="p-2 border">Jam Selesai</th>
                    <th class="p-2 border">Kelas</th>
                    <th class="p-2 border">Mapel</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $jadwal->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-2 border"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['hari']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['jam_mulai']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['jam_selesai']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['kelas']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['mapel']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>