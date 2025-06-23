<?php
include '../connection/database.php';

if (isset($_POST['daftar'])) {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    if ($role == 'admin') {
        mysqli_query($conn, "INSERT INTO admin (username, password, email) VALUES ('$username', '$password', '$email')");
    } elseif ($role == 'guru') {
        mysqli_query($conn, "INSERT INTO guru (username, password) VALUES ('$username', '$password')");
    } else {
        // siswa
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $kelas = $_POST['kelas'];
        $tempat = $_POST['tempat_lahir'];
        $tgl = $_POST['tanggal_lahir'];
        $ayah = $_POST['nama_ayah'];
        $ibu = $_POST['nama_ibu'];
        mysqli_query($conn, "INSERT INTO siswa (username, password, nama, nis, kelas, tempat_lahir, tanggal_lahir, nama_ayah, nama_ibu) VALUES ('$username', '$password', '$nama', '$nis', '$kelas', '$tempat', '$tgl', '$ayah', '$ibu')");
    }

    echo "Registrasi berhasil!";
}
?>

<!-- Form HTML -->
<form method="POST">
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
    </select>
    <input type="text" name="username" required placeholder="Username">
    <input type="password" name="password" required placeholder="Password">
    <input type="email" name="email" placeholder="Email (admin)">
    
    <!-- Tambahan untuk siswa -->
    <div id="siswaFields">
        <input type="text" name="nama" placeholder="Nama Siswa">
        <input type="text" name="nis" placeholder="NIS">
        <input type="text" name="kelas" placeholder="Kelas">
        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir">
        <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir">
        <input type="text" name="nama_ayah" placeholder="Nama Ayah">
        <input type="text" name="nama_ibu" placeholder="Nama Ibu">
    </div>

    <button type="submit" name="daftar">Register</button>
</form>
