<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $nip = $_POST['nip'];
    $mapel = $_POST['mapel'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $conn->prepare("INSERT INTO guru (username, name, nip, mapel, password) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $username, $name, $nip, $mapel, $password);
    
    if ($query->execute()) {
        echo "Registration successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form method="post" class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Register Guru</h2>
        <input type="text" name="username" placeholder="Username" class="w-full mb-3 p-2 border rounded">
        <input type="text" name="name" placeholder="Name" class="w-full mb-3 p-2 border rounded">
        <input type="text" name="nip" placeholder="NIP" class="w-full mb-3 p-2 border rounded">
        <input type="text" name="mapel" placeholder="Mapel" class="w-full mb-3 p-2 border rounded">
        <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded">
        <button type="submit" class="bg-green-500 text-white p-2 w-full rounded">Register</button>
    </form>
</body>
</html>