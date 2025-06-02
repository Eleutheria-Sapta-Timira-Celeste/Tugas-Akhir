<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION["identity_code"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["isadmin"] != 1) {
    header("Location: scribe.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_attendance'])) {
        $studentName = $_POST['studentName'];
        $date = $_POST['date'];
        $status = $_POST['status'];

        $sql = "INSERT INTO student_attendance (student_name, date, status) VALUES (?, ?, ?)";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sss", $studentName, $date, $status);

        if ($stmt->execute()) {
            echo '<script>alert("Absensi siswa berhasil ditambahkan");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['update_attendance'])) {
        $attendanceId = $_POST['attendanceId'];
        $studentName = $_POST['studentName'];
        $date = $_POST['date'];
        $status = $_POST['status'];

        $sql = "UPDATE student_attendance SET student_name=?, date=?, status=? WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("sssi", $studentName, $date, $status, $attendanceId);

        if ($stmt->execute()) {
            echo '<script>alert("Absensi siswa berhasil diperbarui");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['delete_attendance'])) {
        $attendanceId = $_POST['attendanceId'];
        $sql = "DELETE FROM student_attendance WHERE id=?";
        $stmt = $connectionobj->prepare($sql);
        $stmt->bind_param("i", $attendanceId);

        if ($stmt->execute()) {
            echo '<script>alert("Absensi siswa berhasil dihapus");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Absensi Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
<?php include ('../includes/admin_header.php') ?>

<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold text-center mb-5">Manajemen Absensi Siswa</h1>

    <form method="POST" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="attendanceId" id="attendanceId">
        <div class="mb-4">
            <label class="block">Nama Siswa</label>
            <input type="text" name="studentName" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block">Tanggal</label>
            <input type="date" name="date" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label class="block">Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="Hadir">Hadir</option>
                <option value="Tidak Hadir">Tidak Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" name="add_attendance" class="bg-green-600 text-white px-4 py-2 rounded">Tambah</button>
            <button type="submit" name="update_attendance" class="bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
        </div>
    </form>

    <h2 class="text-xl font-semibold mt-10 mb-3">Daftar Absensi</h2>
    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $connectionobj->query("SELECT * FROM student_attendance ORDER BY date DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td class='border p-2'>{$row['student_name']}</td>
                        <td class='border p-2'>{$row['date']}</td>
                        <td class='border p-2'>{$row['status']}</td>
                        <td class='border p-2'>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='attendanceId' value='{$row['id']}'>
                                <button type='submit' name='delete_attendance' class='text-red-600'>Hapus</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include ('../includes/admin_footer.php') ?>
</body>
</html>