<?php
session_start();
include 'connection/database.php';

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$role     = $_POST['role'];

if (empty($username) || empty($password) || empty($role)) {
    header("Location: login.php?error=Semua field wajib diisi!");
    exit();
}

if ($role == 'admin') {
    $query = "SELECT * FROM admin WHERE username = ?";
} elseif ($role == 'guru') {
    $query = "SELECT * FROM guru WHERE username = ?";
} elseif ($role == 'siswa') {
    $query = "SELECT * FROM siswa WHERE username = ?";
} else {
    header("Location: login.php?error=Role tidak valid!");
    exit();
}

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama']     = $row['nama'];
            header("Location: admin/admin_dashboard.php");
        }
        elseif ($role == 'guru') {
            $_SESSION['username'] = $row['username'];
            $_SESSION['nip']      = $row['nip'];
            $_SESSION['nama']     = $row['nama'];
            $_SESSION['mapel']    = $row['mapel'];
            $_SESSION['foto']     = $row['foto'] ?? 'default.png';
            header("Location: guru/dashboardguru.php");
        }
        elseif ($role == 'siswa') {
            $_SESSION['user'] = array(
                'username'       => $row['username'],
                'nama'           => $row['nama'],
                'nis'            => $row['nis'],
                'kelas'          => $row['kelas'],
                'foto'           => $row['foto'] ?? 'default.png',
                'tempat_lahir'   => $row['tempat_lahir'],
                'tanggal_lahir'  => $row['tanggal_lahir'],
                'nama_ayah'      => $row['nama_ayah'],
                'nama_ibu'       => $row['nama_ibu']
            );
            header("Location: siswa/dashboardsiswa.php");
        }
        exit();
    } else {
        header("Location: login.php?error=Password salah!");
        exit();
    }
} else {
    header("Location: login.php?error=Username tidak ditemukan!");
    exit();
}
?>
