<?php
require 'db.php';

// Insert Attendance Record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guru_id = $_POST['guru_id'];
    $keterangan = $_POST['keterangan'];

    $query = $conn->prepare("INSERT INTO absenguru (guru_id, keterangan) VALUES (?, ?)");
    $query->bind_param("is", $guru_id, $keterangan);

    if ($query->execute()) {
        $msg = "<p class='text-green-500 font-bold'>Absensi berhasil disimpan!</p>";
    } else {
        $msg = "<p class='text-red-500 font-bold'>Gagal menyimpan absensi.</p>";
    }

    // If AJAX, return only the message and exit
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
        echo $msg;
        exit;
    } else {
        echo $msg;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-green-100 min-h-screen p-6">

    <div class="max-w-3xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-3xl font-extrabold mb-4 flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /><path d="M8 7h.01M16 7h.01M8 17h.01M16 17h.01" /></svg>
            Form Absensi Guru
        </h2>
        <form method="post" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">ID Guru</label>
                <input type="number" name="guru_id" placeholder="ID Guru" required class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Keterangan</label>
                <select name="keterangan" class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
                    <option value="Hadir">Hadir</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                </select>
            </div>
            <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold text-lg shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                Simpan Absensi
            </button>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="max-w-3xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17v-2a4 4 0 0 1 8 0v2M5 21h14a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2z"></path></svg>
            Data Absensi Guru
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-green-400 text-white">
                        <th class="p-3 text-left">Nama Guru</th>
                        <th class="p-3 text-left">Keterangan</th>
                        <th class="p-3 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch attendance records with guru name
                    $absensi = $conn->query("SELECT a.*, g.name FROM absenguru a JOIN guru g ON a.guru_id = g.id ORDER BY a.tanggal DESC");
                    while ($row = $absensi->fetch_assoc()) { 
                        $badgeColor = [
                            'Hadir' => 'bg-green-100 text-green-700',
                            'Alpha' => 'bg-red-100 text-red-700',
                            'Izin'  => 'bg-yellow-100 text-yellow-700',
                            'Sakit' => 'bg-blue-100 text-blue-700'
                        ];
                        $ket = htmlspecialchars($row['keterangan']);
                        $color = $badgeColor[$ket] ?? 'bg-gray-100 text-gray-700';
                    ?>
                    <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                        <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-3">
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