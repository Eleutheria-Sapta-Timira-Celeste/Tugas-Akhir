<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = $conn->prepare("SELECT * FROM guru WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        $guru = $result->fetch_assoc();
        if (password_verify($password, $guru['password'])) {
            $_SESSION['guru'] = $guru;
            header("Location: dashboard_guru.php");
            exit();
        } else {
            echo "Username or password incorrect.";
        }
    } else {
        echo "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form method="post" class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Login Guru</h2>
        <input type="text" name="username" placeholder="Username" class="w-full mb-3 p-2 border rounded">
        <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded">
        <button type="submit" class="bg-blue-500 text-white p-2 w-full rounded">Login</button>
        <div class="mt-4 text-center">
            <p>Belum memiliki akun?</p>
            <a href="register.php" class="bg-green-500 text-white p-2 w-full rounded block mt-2">Register</a>
        </div>
    </form>
</body>
</html>