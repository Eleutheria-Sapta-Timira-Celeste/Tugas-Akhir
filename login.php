<?php
session_start();
include 'connection/database.php';

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $roles = [
        'admin' => 'admin',
        'guru'  => 'guru',
        'siswa' => 'siswa'
    ];

    $found = false;

    foreach ($roles as $role => $table) {
        $query = "SELECT * FROM $table WHERE username='$username'";
        $result = $connection->query($query);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['role'] = $role;
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $user['id'];               
                $_SESSION['logo'] = $user['logo'] ?? '';

                // Tambahkan khusus untuk guru
                if ($role === 'guru') {
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['mapel'] = $user['mapel'];
                    $_SESSION['foto']  = $user['foto'] ?? 'default.png';
                }

                // Tambahkan untuk siswa
                if ($role === 'siswa') {
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['nis'] = $user['nis'];
                    $_SESSION['foto'] = $user['foto'] ?? 'default.png';
                }

                header("Location: /Tugas-Akhir/$role/index.php");
                exit();
            } else {
                $error = "Password salah!";
                $found = true;
                break;
            }
        }
    }

    if (!$found && !$error) {
        $error = "Username tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
</head>

<body>
    <section class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="flex flex-col items-center w-full max-w-md px-6 py-8 mx-auto">
            <a href="index.php" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-80 h-22" src="/Tugas-Akhir/assects/images/defaults/logoadmin.png" alt="logo">
            </a>

            <div class="w-full bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-center mb-6">Masuk Sebagai Pengguna</h2>

                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline"><?= $error ?></span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"><title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.03a1.2 1.2 0 11-1.697-1.697L8.183 10 5.532 7.349a1.2 1.2 0 111.697-1.697L10 8.183l2.651-2.531a1.2 1.2 0 111.697 1.697L11.819 10l2.529 2.651a1.2 1.2 0 010 1.698z" />
                            </svg>
                        </span>
                    </div>
                <?php endif; ?>

                <form class="space-y-4" method="POST">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               placeholder="Masukkan Username" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               placeholder="Masukkan Password" required>
                    </div>
                    <div class="text-right mb-3">
                        <a href="lupa_password.php" class="text-sm text-blue-500 hover:text-blue-700">Lupa Password?</a>
                    </div>
            
                    <button type="submit" class="w-full bg-[#5c3d15] text-white py-2 rounded hover:bg-[#4b320f]">
                        Login
                    </button>
                </form>

                <hr class="my-6">

                <p class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="register.php" class="text-blue-600 hover:text-blue-800 font-semibold">Daftar di sini</a>
                </p>
            </div>
        </div>
    </section>
</body>

</html>
