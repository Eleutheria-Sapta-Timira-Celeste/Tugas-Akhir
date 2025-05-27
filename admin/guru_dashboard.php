<?php
session_start();
include '../connection/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ✅ Student Attendance Submission
    if (isset($_POST["absensi_murid"])) {
        foreach ($_POST["absensi_murid"] as $murid_id => $status) {
            $query = "INSERT INTO absensi_murid (murid_id, tanggal, status) VALUES ('$murid_id', CURDATE(), '$status')";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Database Error: " . mysqli_error($connection)); // Debugging errors
            }
        }
        header("Location: guru_dashboard.php?success=absensi_murid_recorded");
        exit();
    }

    if (!empty($murid_id) && !empty($status)) {
    $query = "INSERT INTO absensi_murid (murid_id, tanggal, status) VALUES ('$murid_id', CURDATE(), '$status')";
    mysqli_query($connection, $query);
}

    // ✅ Teacher Attendance Submission
    if (isset($_POST["absensi_guru"])) {
        foreach ($_POST["absensi_guru"] as $guru_id => $status) {
            if (!isset($guru_id) || empty($guru_id)) {
                die("⚠️ Error: Undefined array key 'guru_id' in submitted form.");
            }

            $query = "INSERT INTO absensi_guru (guru_id, tanggal, status) VALUES ('$guru_id', CURDATE(), '$status')";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Database Error: " . mysqli_error($connection));
            }
        }
        header("Location: guru_dashboard.php?success=absensi_guru_recorded");
        exit();
    }
}

// Fetch Murid & Guru List
$murid_list = mysqli_query($connection, "SELECT id, name FROM manipulators WHERE role = 'murid'");
$guru_list = mysqli_query($connection, "SELECT id, name FROM manipulators WHERE role = 'guru'");

// Ensure Data is Sent Before Inserting
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ Submit Murid Attendance
    if (isset($_POST["absensi_murid"])) {
        foreach ($_POST["absensi_murid"] as $murid_id => $status) {
            $query = "INSERT INTO absensi_murid (murid_id, tanggal, status) VALUES ('$murid_id', CURDATE(), '$status')";
            mysqli_query($connection, $query);
        }
        header("Location: guru_dashboard.php?success=absensi_murid_recorded");
        exit();
    }

    // ✅ Submit Guru Attendance
    if (isset($_POST["absensi_guru"])) {
        foreach ($_POST["absensi_guru"] as $guru_id => $status) {
            $query = "INSERT INTO absensi_guru (guru_id, tanggal, status) VALUES ('$guru_id', CURDATE(), '$status')";
            mysqli_query($connection, $query);
        }
        header("Location: guru_dashboard.php?success=absensi_guru_recorded");
        exit();
    }
}


// ✅ Fetch Attendance Records
$absensi_murid_result = mysqli_query($connection, "SELECT * FROM absensi_murid ORDER BY tanggal DESC");
$absensi_guru_result = mysqli_query($connection, "SELECT * FROM absensi_guru ORDER BY tanggal DESC");


// ✅ Fetch Attendance History
$riwayat_murid_result = mysqli_query($connection, "SELECT * FROM riwayat_absensi_murid ORDER BY tanggal DESC");
$riwayat_guru_result = mysqli_query($connection, "SELECT * FROM riwayat_absensi_guru ORDER BY tanggal DESC");


if (isset($_GET['success'])) {
    echo "<script>alert('Success: " . htmlspecialchars($_GET['success']) . "');</script>";
    
    // Remove success parameter from URL
    echo "<script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>";
}

if (isset($_POST["absensi_murid"]) && is_array($_POST["absensi_murid"])) {
    foreach ($_POST["absensi_murid"] as $murid_id => $status) {
        $query = "INSERT INTO absensi_murid (murid_id, tanggal, status) VALUES ('$murid_id', CURDATE(), '$status')";
        mysqli_query($connection, $query);
    }
}


$riwayat_murid_result = mysqli_query($connection, "SELECT * FROM riwayat_absensi_murid ORDER BY tanggal DESC");
if (!$riwayat_murid_result) {
    die("Database Error: " . mysqli_error($connection));
}

// ✅ Fetch Attendance History for Murid
$riwayat_murid_result = mysqli_query($connection, "SELECT rm.murid_id, m.name AS murid_name, rm.tanggal, rm.status 
    FROM riwayat_absensi_murid rm 
    JOIN manipulators m ON rm.murid_id = m.id 
    ORDER BY rm.tanggal DESC");

// ✅ Fetch Attendance History for Guru
$riwayat_guru_result = mysqli_query($connection, "SELECT rg.guru_id, g.name AS guru_name, rg.tanggal, rg.status 
    FROM riwayat_absensi_guru rg 
    JOIN manipulators g ON rg.guru_id = g.id 
    ORDER BY rg.tanggal DESC");
?>b

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="w-full max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-2xl">

    <nav class="bg-blue-600 p-4 text-white flex justify-between shadow-lg">
        <h1 class="text-xl font-bold">📜 Dashboard Guru</h1>
    </nav>

    <div class="flex flex-col md:flex-row space-y-6 md:space-x-6 mt-6">
        
        <!-- 🔹 Student Attendance Section -->
        <div class="md:w-1/2">
            <!-- Murid Attendance Form -->
<h2 class="text-2xl font-semibold text-gray-800 mb-4">📝 Form Absensi Murid</h2>
<form method="POST">
    <table class="w-full border border-gray-300 rounded-md">
        <thead>
            <tr class="bg-gray-300">
                <th class="p-3 border">Murid Name</th>
                <th class="p-3 border">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($murid_list)) { ?>
            <tr class="bg-white">
                <td class="p-3 border"><?= htmlspecialchars($row['name']) ?></td>
                <td class="p-3 border text-center">
                    <select name="absensi_murid[<?= $row['id'] ?>]" class="border rounded-lg p-2 bg-gray-50">
                        <option value="Hadir">✅ Hadir</option>
                        <option value="Absen">❌ Absen</option>
                        <option value="Izin">🚶 Izin</option>
                        <option value="Sakit">🤒 Sakit</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

                            </td>
                        </tr>
                        <?php  ?>
                    </tbody>
                </table>
                <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 px-6 rounded-lg shadow-lg font-bold hover:scale-105 transition-transform">
                    📌 Submit Absensi Murid
                </button>
            </form>

            <!-- 📜 Student Attendance History -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">📜 Riwayat Absensi Murid</h2>
<table class="w-full border border-gray-300 rounded-lg shadow-md text-center">
    <thead>
        <tr class="bg-gray-300">
            <th class="p-2 border">Murid Name</th>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($riwayat_murid_result)) { ?>
        <tr class="border">
            <td class="p-2 border"><?= htmlspecialchars($row['murid_name']) ?></td>
            <td class="p-2 border"><?= htmlspecialchars($row['tanggal']) ?></td>
            <td class="p-2 border font-semibold text-center"><?= htmlspecialchars($row['status']) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

        </div>

        <!-- 🔹 Teacher Attendance Section -->
        <div class="md:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📌 Form Absensi Guru</h2>
<form method="POST">
    <table class="w-full border border-gray-300 rounded-md">
        <thead>
            <tr class="bg-gray-300">
                <th class="p-3 border">Guru Name</th>
                <th class="p-3 border">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($guru_list)) { ?>
            <tr class="bg-white">
                <td class="p-3 border"><?= htmlspecialchars($row['name']) ?></td>
                <td class="p-3 border text-center">
                    <select name="absensi_guru[<?= $row['id'] ?>]" class="border rounded-lg p-2 bg-gray-50">
                        <option value="Hadir">✅ Hadir</option>
                        <option value="Absen">❌ Absen</option>
                        <option value="Izin">📜 Izin</option>
                        <option value="Sakit">🤒 Sakit</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 px-6 rounded-lg shadow-lg font-bold hover:scale-105 transition-transform">
        📌 Submit Absensi Guru
    </button>
</form>


            <!-- 📜 Teacher Attendance History -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">📜 Riwayat Absensi Guru</h2>
            <table class="w-full border border-gray-300 rounded-lg shadow-md text-center">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="p-2 border">Guru Name</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($riwayat_guru_result)) { ?>
                    <tr class="border">
                        <td class="p-2 border"><?= htmlspecialchars($row['guru_id']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td class="p-2 border font-semibold text-center"><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
</html>



