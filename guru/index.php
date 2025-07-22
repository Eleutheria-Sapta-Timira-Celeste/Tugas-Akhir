<?php
include '../connection/database.php';

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

$username = $_SESSION['username'];
$foto     = $_SESSION['foto'] ?? 'default.png';

// Ambil data dari database
try {
    $query = "SELECT * FROM guru WHERE username = ?";
    $stmt  = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $user = [
            'foto'  => $foto,
            'nip'   => '',
            'nama'  => '',
            'gelar' => '',
            'mapel' => ''
        ];
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FFF9F0] flex">

    <?php include 'sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen ml-64 transition-all duration-300" id="main-content">
        <?php include 'headerr_guru.php'; ?>

        <?php
        if ($page === 'dashboard') {
            include 'dashboard.php';
        } elseif ($page === 'inputabsensi') {
            include 'inputabsensi.php';
        } elseif ($page === 'pengaturan') {
            include 'pengaturan.php';
        }
        ?>
    </div>

</body>
</html>
