<?php
session_start();
if (!isset($_SESSION['guru'])) {
    header("Location: login.php");
    exit();
}
$guru = $_SESSION['guru'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="bg-white max-w-2xl mx-auto p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Selamat datang, <?= htmlspecialchars($guru['name']) ?>!</h1>
        <p><strong>NIP:</strong> <?= $guru['nip'] ?></p>
        <p><strong>Mapel:</strong> <?= $guru['mapel'] ?></p>
        <div class="mt-6">
            <a href="logout.php" class="text-blue-600 hover:underline">Logout</a>
        </div>
    </div>
</body>
</html>