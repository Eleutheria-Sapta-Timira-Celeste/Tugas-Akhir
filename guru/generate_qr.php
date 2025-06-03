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
<body class="bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Buat QR Code</h2>
        <form method="post">
            <input type="number" name="id" placeholder="ID" class="w-full mb-3 p-2 border rounded">
            <input type="text" name="name" placeholder="Nama" class="w-full mb-3 p-2 border rounded">
            <select name="role" class="w-full p-2 border rounded">
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 w-full rounded mt-4">Generate QR Code</button>
        </form>
    </div>
</body>
</html>