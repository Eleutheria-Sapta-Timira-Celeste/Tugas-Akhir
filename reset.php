<?php
include 'koneksi.php';

$valid = false;
$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = mysqli_query($conn, "SELECT * FROM reset_tokens WHERE token='$token'");

    if ($data = mysqli_fetch_assoc($query)) {
        $email = $data['email'];
        $role = $data['role'];
        $expired = strtotime($data['expired_at']);

        if (time() > $expired) {
            $message = "⛔ Link kadaluarsa!";
        } else {
            $valid = true;
        }

        if (isset($_POST['submit'])) {
            $new_pass = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            mysqli_query($conn, "UPDATE $role SET password='$new_pass' WHERE email='$email'");
            mysqli_query($conn, "DELETE FROM reset_tokens WHERE token='$token'");
            $message = "✅ Password berhasil diubah. <a href='login.php' class='text-blue-600 underline'>Login</a>";
            $valid = false;
        }
    } else {
        $message = "⛔ Token tidak valid.";
    }
} else {
    $message = "⛔ Token tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Reset Password</h2>
        <?php if ($message): ?>
            <div class="mb-4 text-center text-sm text-red-600"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($valid): ?>
        <form method="POST">
            <label class="block text-sm mb-1">Password Baru</label>
            <input type="password" name="new_password" required class="w-full px-3 py-2 border rounded mb-4" placeholder="Masukkan password baru">
            <button type="submit" name="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Ubah Password
            </button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
