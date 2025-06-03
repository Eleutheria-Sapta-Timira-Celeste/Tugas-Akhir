<?php
require 'db.php';

// Process Scanned QR Data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['qr_data'];
    preg_match('/ID: (\d+), Nama: (.*), Role: (guru|siswa)/', $data, $matches);

    if ($matches) {
        $id = $matches[1];
        $name = $matches[2];
        $role = $matches[3];

        // Log attendance
        if ($role == 'guru') {
            $query = $conn->prepare("INSERT INTO absenguru (guru_id, keterangan) VALUES (?, 'Hadir')");
        } else {
            $query = $conn->prepare("INSERT INTO absensiswa (nama_siswa, kelas, keterangan) VALUES (?, '', 'Hadir')");
        }
        $query->bind_param("s", $id);
        $query->execute();

        echo "<p class='text-green-500 font-bold'>Attendance recorded for $name!</p>";
    } else {
        echo "<p class='text-red-500 font-bold'>Invalid QR Code!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scan QR Code</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Scan QR Code</h2>
        <div id="qr-reader" class="mb-6"></div>
        <form id="qr-form" method="post">
            <input type="hidden" name="qr_data" id="qr-data">
            <button type="submit" class="bg-blue-500 text-white p-2 w-full rounded mt-4">Submit Attendance</button>
        </form>
    </div>

    <script>
        function onScanSuccess(qrCodeMessage) {
            document.getElementById("qr-data").value = qrCodeMessage;
            document.getElementById("qr-form").submit();
        }

        let html5QrCode = new Html5Qrcode("qr-reader");
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            onScanSuccess
        );
    </script>
</body>
</html>