<?php
require 'phpqrcode/qrlib.php';
require 'db.php';

// Generate QR Code
function generateQRCode($id, $name, $role) {
    $data = "ID: $id, Nama: $name, Role: $role";
    $filename = "qrcodes/$id.png";
    QRcode::png($data, $filename, QR_ECLEVEL_L, 10);
    return $filename;
}

// Store QR Code in Database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    
    $qr_file = generateQRCode($id, $name, $role);
    
    if ($role == 'guru') {
        $query = $conn->prepare("UPDATE guru SET qr_code = ? WHERE id = ?");
    } else {
        $query = $conn->prepare("UPDATE absensiswa SET qr_code = ? WHERE id = ?");
    }
    $query->bind_param("si", $qr_file, $id);
    $query->execute();
    
    echo "<p class='text-green-500 font-bold'>QR Code generated successfully!</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Generate QR Code</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-green-100 min-h-screen p-6">
    <div class="max-w-lg mx-auto bg-white/90 p-8 rounded-2xl shadow-2xl mt-10">
        <h2 class="text-3xl font-extrabold mb-6 flex items-center gap-2">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" /><path d="M7 7h.01M17 7h.01M7 17h.01M17 17h.01" /></svg>
            Buat QR Code
        </h2>
        <form method="post" class="space-y-4">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">ID</label>
                <input type="number" name="id" placeholder="ID" required class="w-full p-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Nama</label>
                <input type="text" name="name" placeholder="Nama" required class="w-full p-3 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Role</label>
                <select name="role" class="w-full p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                    <option value="guru">Guru</option>
                    <option value="siswa">Siswa</option>
                </select>
            </div>
            <button type="submit"
                class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold text-lg shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                Generate QR Code
            </button>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($qr_file)): ?>
            <div class="mt-8 text-center">
                <p class="text-green-600 font-semibold mb-2">QR Code berhasil dibuat!</p>
                <img src="<?= htmlspecialchars($qr_file) ?>" alt="QR Code" class="mx-auto w-48 h-48 rounded-lg shadow-lg border-4 border-blue-100 bg-white">
                <p class="mt-2 text-gray-500 text-sm">Scan QR ini untuk absen.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>