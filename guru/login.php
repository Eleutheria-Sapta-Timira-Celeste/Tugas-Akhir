<?php
include 'koneksi.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek data
    $stmt = $conn->prepare("SELECT * FROM guru WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['username'] = $user['username']; // ← ini kunci
            $_SESSION['nip']      = $user['nip'];
            $_SESSION['nama']     = $user['nama'];
            $_SESSION['mapel']    = $user['mapel'];
            $_SESSION['foto']     = $user['foto'] ?? '';

            header("Location: dashboardguru.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
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
<body>
      <main>
        <section class="bg-gray-100 dark:bg-white-900">
         <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                    <img class="w-80 h-22 mr-2" src="../assects/images/defaults/logoadmin.png" alt="logo">

                </a>
    
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-white-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
             <h2 class="text-2xl font-bold text-center mb-6">Masuk Sebagai Guru</h2>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded"><?= $error ?></div>
            <?php endif; ?>

          <form class="space-y-4 md:space-y-6" action="" method="POST">
            <div>
                <label class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Username</label>
                <input type="text" name="username" id="text" class="bg-white-50 border border-white-300 text-white-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text- darkblack:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Username" required="">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan Password" class="bg-white-50 border border-white-300 text-white-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
            <div class="text-right mb-3">
                <a href="lupa_password.php" class="text-sm text-blue-500 hover:text-blue-700">Lupa Password?</a>
            </div>
            
            <!-- Tombol Login -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Login
            </button>
        </form>

        <!-- Garis pisah -->
        <hr class="my-6">

        <!-- Belum punya akun -->
        <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="register.php" class="text-blue-600 hover:text-blue-800 font-semibold">Daftar di sini</a>
        </p>
         </div>
    </div>
    </div>
      </section>

    </main>
</body>
</html>
