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
<body class="bg-gradient-to-br from-blue-100 via-white to-green-100 min-h-screen p-6">

    <div class="max-w-3xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-3xl font-extrabold mb-2 flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /><path d="M8 7h.01M16 7h.01M8 17h.01M16 17h.01" /></svg>
            Jadwal Mengajar
        </h2>
        <p class="text-gray-500 mb-6">Kelola dan lihat jadwal mengajar guru di bawah ini.</p>
        <form method="post" class="space-y-4 mb-8">
            <input type="number" name="guru_id" placeholder="ID Guru" class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Hari</label>
                <select name="hari" class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            <input type="time" name="jam_mulai" placeholder="Jam Mulai" class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            <input type="time" name="jam_selesai" placeholder="Jam Selesai" class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            <input type="text" name="kelas" placeholder="Kelas" class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            <input type="text" name="mapel" placeholder="Mapel" class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold text-lg shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                Simpan Jadwal
            </button>
        </form>
        <!-- Schedule Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-green-400 text-white">
                        <th class="p-3 text-left">Guru</th>
                        <th class="p-3 text-left">Hari</th>
                        <th class="p-3 text-left">Jam Mulai</th>
                        <th class="p-3 text-left">Jam Selesai</th>
                        <th class="p-3 text-left">Kelas</th>
                        <th class="p-3 text-left">Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $jadwal->fetch_assoc()) { ?>
                        <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                            <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="p-3">
                                <?php
                                    $badge = [
                                        'Senin' => 'bg-blue-100 text-blue-700',
                                        'Selasa' => 'bg-green-100 text-green-700',
                                        'Rabu' => 'bg-yellow-100 text-yellow-700',
                                        'Kamis' => 'bg-purple-100 text-purple-700',
                                        'Jumat' => 'bg-pink-100 text-pink-700',
                                        'Sabtu' => 'bg-gray-200 text-gray-700'
                                    ];
                                    $hari = htmlspecialchars($row['hari']);
                                    $color = $badge[$hari] ?? 'bg-gray-100 text-gray-700';
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $color ?>">
                                    <?= $hari ?>
                                </span>
                            </td>
                            <td class="p-3"><?= htmlspecialchars($row['jam_mulai']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['jam_selesai']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['kelas']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['mapel']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>