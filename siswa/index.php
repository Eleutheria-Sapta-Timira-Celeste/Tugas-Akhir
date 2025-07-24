<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

$username = $_SESSION['username'];
$foto     = $_SESSION['foto'] ?? 'default.png';

try {
    $query = "SELECT * FROM siswa WHERE username = ?";
    $stmt  = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $user = [
            'nis'             => '',
            'nama'            => '',
            'jenis_kelamin'   => '',
            'kelas'           => '',
            'tempat_lahir'    => '',
            'tanggal_lahir'   => '',
            'nama_ayah'       => '',
            'nama_ibu'        => '',
            'alamat'          => '',
            'no_telepon'      => '',
            'foto'            => $foto
        ];
    }

    $stmt->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$page = $_GET['page'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex bg-[#FFF9F0] min-h-screen">

    <?php include 'sidebar.php'; ?>

    <div class="flex flex-col flex-1 min-h-screen ml-64 transition-all duration-300" id="main-content">
        <?php include 'headerr_siswa.php'; ?>

        <main class="p-6">
            <?php
            if ($page === 'dashboard') {
                include 'dashboard.php';
            } elseif ($page === 'melihat_absensi') {
                include 'melihat_absensi.php';
            } elseif ($page === 'pengaturan') {
                include 'pengaturan.php';
            }
            ?>
        </main>
    </div>

   
</body>
</html>
