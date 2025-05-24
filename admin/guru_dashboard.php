<?php
session_start();
include '../connection/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Student Attendance Submission
    if (isset($_POST["absensi_murid"])) {
        foreach ($_POST["absensi_murid"] as $murid_name => $status) {
            $query = "INSERT INTO absensi_murid (murid_name, date, status) VALUES ('$murid_name', CURDATE(), '$status')";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Database Error: " . mysqli_error($connection)); // Debugging errors
            }
        }
        header("Location: guru_dashboard.php?success=absensi_murid_recorded");
        exit();
    }

    // Teacher Attendance Submission
    if (isset($_POST["absensi_guru"])) {
        foreach ($_POST["absensi_guru"] as $nama_guru => $status) {
            if (!isset($nama_guru) || empty($nama_guru)) {
                die("⚠️ Error: Undefined array key 'nama_guru' in submitted form.");
            }

            $query = "INSERT INTO absensi_guru (nama_guru, date, status) VALUES ('$nama_guru', CURDATE(), '$status')";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Database Error: " . mysqli_error($connection));
            }
        }
        header("Location: guru_dashboard.php?success=absensi_guru_recorded");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["absensi_murid"])) {
    foreach ($_POST["absensi_murid"] as $murid_name => $status) {
        $query = "INSERT INTO absensi_murid (murid_name, date, status) VALUES ('$murid_name', CURDATE(), '$status')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Database Error: " . mysqli_error($connection)); // Reveal errors
        } else {
            echo "Inserted: " . $murid_name . " - Status: " . $status . "<br>"; // Debugging output
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["absensi_guru"])) {
    foreach ($_POST["absensi_guru"] as $nama_guru => $status) {
        if (!isset($nama_guru) || empty($nama_guru)) {
            die("⚠️ Error: Undefined array key 'nama_guru' in submitted form.");
        }

        $query = "INSERT INTO absensi_guru (nama_guru, date, status) VALUES ('$nama_guru', CURDATE(), '$status')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Database Error: " . mysqli_error($connection));
        }
    }
    header("Location: guru_dashboard.php?success=absensi_guru_recorded");
    exit();
}

    header("Location: guru_dashboard.php?success=absensi_murid_recorded");
    exit();
}
    $absensi_murid_result = mysqli_query($connection, "SELECT * FROM absensi_murid ORDER BY date DESC");
    $absensi_guru_result = mysqli_query($connection, "SELECT * FROM absensi_guru ORDER BY date DESC");


if (isset($_GET['success']) && $_GET['success'] === 'absensi_murid_recorded') {
    echo "<script>alert('absensi_murid Recorded!');</script>";
}



$result = mysqli_query($connection, "SELECT murid_name, date, status FROM absensi_murid ORDER BY date DESC");

// echo "<table class='w-full border border-gray-300 rounded-lg shadow-md'>";
// echo "<thead><tr class='bg-gray-200'><th>Murid</th><th>Date</th><th>Status</th></tr></thead>";
// echo "<tbody>";

// while ($row = mysqli_fetch_assoc($result)) {
//     echo "<tr class='border'>";
//     echo "<td class='p-2 border'>" . htmlspecialchars($row['murid_name']) . "</td>";
//     echo "<td class='p-2 border'>" . htmlspecialchars($row['date']) . "</td>";
//     echo "<td class='p-2 border font-semibold text-center'>";
//     echo !empty($row['status']) ? htmlspecialchars($row['status']) : "<span class='text-red-600'>No Status Recorded</span>";
//     echo "</td></tr>";
// }




echo "</tbody></table>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Present Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
function showForm(formType) {
    document.getElementById("student-form").style.display = (formType === 'murid') ? "block" : "none";
    document.getElementById("teacher-form").style.display = (formType === 'guru') ? "block" : "none";
}
</script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="w-full max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-2xl">
    <nav class="bg-blue-600 p-4 text-white flex justify-between shadow-lg">
        <h1 class="text-xl font-bold">📜 Dashboard Guru</h1>
        <div class="space-x-6">
            <button onclick="showForm('student')" class="hover:underline">Absensi Murid</button>
            <button onclick="showForm('teacher')" class="hover:underline">Absensi Guru</button>
        </div>
    </nav>

    <div class="flex flex-col md:flex-row space-y-6 md:space-x-6 mt-6">
        <!-- Student Attendance Section -->
        <div id="student-section" class="md:w-1/2">
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
                        <tr class="bg-white">
                            <td class="p-3 border">John Doe</td>
                            <td class="p-3 border text-center">
                                <select name="absensi_murid[John Doe]" class="border rounded-lg p-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-all">
                                    <option value="Hadir">✅ Hadir</option>
                                    <option value="Absen">❌ Absen</option>
                                    <option value="Izin">🚶 Izin</option>
                                    <option value="Sakit">🤒 Sakit</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="mt-6 w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-lg shadow-lg text-lg font-bold hover:scale-105 transition-transform duration-200">
                    📌 Submit Student Attendance
                </button>
            </form>

            <!-- Student Attendance Records -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">📜 Riwayat Absensi Murid</h2>
            <table class="w-full border border-gray-300 rounded-lg shadow-md text-center">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="p-2 border">Murid Name</th>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($absensi_murid_result)) { ?>
                    <tr class="border">
                        <td class="p-2 border"><?= htmlspecialchars($row['murid_name']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['date']) ?></td>
                        <td class="p-2 border font-semibold text-center <?= ($row['status'] === 'Hadir') ? 'text-green-600' : ($row['status'] === 'Sakit' ? 'text-yellow-600' : ($row['status'] === 'Izin' ? 'text-blue-600' : 'text-red-600')) ?>">
                            <?= !empty($row['status']) ? htmlspecialchars($row['status']) : "<span class='text-red-600'>No Status Recorded</span>" ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Teacher Attendance Section -->
        <div id="teacher-section" class="md:w-1/2">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📌 Mark Teacher Attendance</h2>
            <form method="POST">
                <table class="w-full border border-gray-300 rounded-md">
                    <thead>
                        <tr class="bg-gray-300">
                            <th class="p-3 border">Teacher Name</th>
                            <th class="p-3 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="p-3 border">Mr. Anderson</td>
                            <td class="p-3 border text-center">
                                <select name="absensi_guru[Mr. Anderson]" class="border rounded-lg p-2 bg-gray-50">
                                        <option value="Hadir">✅ Hadir</option>
                                        <option value="Absen">❌ Absen</option>
                                        <option value="Izin">📜 Izin</option>
                                        <option value="Sakit">🤒 Sakit</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="mt-6 w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-lg shadow-lg text-lg font-bold hover:scale-105 transition-transform duration-200">
                    📌 Submit Teacher Attendance
                </button>
            </form>

            <!-- Teacher Attendance Records -->
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">📜 Teacher Attendance Records</h2>
            <table class="w-full border border-gray-300 rounded-lg shadow-md text-center">
                <thead>
                    <tr class="bg-gray-300">
                        <th class="p-2 border">Teacher Name</th>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($absensi_guru_result)) { ?>
                    <tr class="border">
                        <td class="p-2 border"><?= htmlspecialchars($row['nama_guru']) ?></td>
                        <td class="p-2 border"><?= htmlspecialchars($row['date']) ?></td>
                        <td class="p-2 border font-semibold text-center <?= ($row['status'] === 'Present') ? 'text-green-600' : ($row['status'] === 'Sick' ? 'text-yellow-600' : ($row['status'] === 'Out' ? 'text-blue-600' : 'text-red-600')) ?>">
                            <?= !empty($row['status']) ? htmlspecialchars($row['status']) : "<span class='text-red-600'>No Status Recorded</span>" ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>


