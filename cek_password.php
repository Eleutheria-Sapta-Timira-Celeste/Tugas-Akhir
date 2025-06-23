<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection/database.php';

// Username yang mau dites
$username = 'admin2'; 

// Password yang mau dites (plain text yang kamu ketik di form)
$password_input = 'password123';

$query = "SELECT * FROM admin WHERE username='$username'";
$result = $mysqli->query($query);

if ($result && $result->num_rows == 1) {
    $user = $result->fetch_assoc();

    echo "<h3>Data dari tabel admin:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";

    echo "<h3>Hasil password_verify:</h3>";
    if (password_verify($password_input, $user['password'])) {
        echo "<p style='color:green'>✅ Password COCOK!</p>";
    } else {
        echo "<p style='color:red'>❌ Password TIDAK cocok!</p>";
    }
} else {
    echo "<p style='color:red'>❌ Username admin2 TIDAK ditemukan!</p>";
}
?>
