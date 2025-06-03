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
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Daftar Guru</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Username</th>
                    <th class="p-2 border">NIP</th>
                    <th class="p-2 border">Mapel</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $guru->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-2 border"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['username']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['nip']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['mapel']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>