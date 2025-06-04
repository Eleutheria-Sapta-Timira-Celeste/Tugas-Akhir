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
    <title>Scan QR Guru</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg mt-10">
        <h2 class="text-2xl font-bold mb-4">Scan QR Guru</h2>
        <div id="qr-reader" style="width: 100%"></div>
        <div id="qr-result" class="mt-4"></div>
    </div>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Assume QR contains guru_id (e.g., just the number)
            document.getElementById('qr-result').innerHTML = 
                `<div class="text-green-600 font-bold">QR Terdeteksi: ${decodedText}</div>
                <div class="mt-2">Mengirim absensi...</div>`;
            // Send to absenguru.php via AJAX
            fetch('absenguru.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `guru_id=${encodeURIComponent(decodedText)}&keterangan=Hadir`
            })
            .then(res => res.text())
            .then(data => {
                document.getElementById('qr-result').innerHTML += 
                    `<div class="mt-2">${data}</div>`;
            });
            html5QrcodeScanner.clear();
        }
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
</body>
</html>