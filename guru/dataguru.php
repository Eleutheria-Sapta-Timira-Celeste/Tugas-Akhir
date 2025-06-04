<?php
require 'db.php';

// Fetch Teachers List
$guru = $conn->query("SELECT * FROM guru ORDER BY name");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-green-100 min-h-screen p-6">

    <div class="max-w-4xl mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-3xl font-extrabold mb-2 flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m9-5a4 4 0 1 0-8 0 4 4 0 0 0 8 0z" /></svg>
            Daftar Guru
        </h2>
        <p class="text-gray-500 mb-6">Berikut adalah daftar guru yang terdaftar di sistem.</p>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-green-400 text-white">
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Username</th>
                        <th class="p-3 text-left">NIP</th>
                        <th class="p-3 text-left">Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $guru->fetch_assoc()) { ?>
                        <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50">
                            <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['username']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['nip']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($row['mapel']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>