<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek jika bukan admin, redirect
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$allowed_pages = ['dashboard', 'flash_notice', 'add_notice', 'changeRoutine', 'registered_students', 'changeStaff', 'site_content', 'add_gallery', 'feedback', 'admin_management', 'siswa_management', 'guru_management', 'kelola_kurikulum', 'media_upload'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Scrollbar styling (optional) */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen ml-64 transition-all duration-300" id="main-content">
        
        <!-- Header -->
        <?php include 'headerr_admin.php'; ?>
<<<<<<< HEAD

        <!-- Dynamic Page Content -->
        <div class="p-6">
            <?php
            if (in_array($page, $allowed_pages)) {
                $file_to_include = $page . '.php';
                if (file_exists($file_to_include)) {
                    include $file_to_include;
                } else {
                    echo "<div class='text-red-600 font-semibold'>File <b>$file_to_include</b> tidak ditemukan.</div>";
                }
            } else {
                echo "<div class='text-red-600 font-semibold'>Halaman <b>$page</b> tidak diizinkan.</div>";
            }
            ?>
        </div>
=======
        <?php
            if ($page === 'dashboard') {
                include 'dashboard.php';
            } elseif ($page === 'flash_notice') {
                include 'flash_notice.php';
            } elseif ($page === 'add_notice') {
                include 'add_notice.php';
            }
            ?>

>>>>>>> 4f78e2ffab637718ec2e31f067eeb35338778d70
    </div>

</body>
</html>
