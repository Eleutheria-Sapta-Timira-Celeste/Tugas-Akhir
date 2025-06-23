<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'koneksi.php';

$message = '';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $role = null;

    foreach (['admin', 'guru', 'siswa'] as $r) {
        $query = mysqli_query($conn, "SELECT * FROM $r WHERE email='$email'");
        if (mysqli_num_rows($query) > 0) {
            $role = $r;
            break;
        }
    }

    if ($role) {
        $token = bin2hex(random_bytes(32));
        $expired_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        mysqli_query($conn, "INSERT INTO reset_tokens (email, role, token, expired_at) VALUES ('$email', '$role', '$token', '$expired_at')");

        $link = "http://localhost/reset.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Ganti
            $mail->SMTPAuth = true;
            $mail->Username = 'your@example.com'; // Ganti
            $mail->Password = 'yourpassword';     // Ganti
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('noreply@example.com', 'Reset Password');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Anda';
            $mail->Body = "Klik link berikut untuk reset password: <a href='$link'>$link</a>";

            $mail->send();
            $message = "✅ Link reset dikirim ke email.";
        } catch (Exception $e) {
            $message = "❌ Gagal kirim email: {$mail->ErrorInfo}";
        }
    } else {
        $message = "❌ Email tidak ditemukan!";
    }
}
?>

<!-- TailwindCSS Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Lupa Password</h2>
        <?php if ($message): ?>
            <div class="mb-4 text-center text-sm text-red-600"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded mb-4" placeholder="Masukkan email Anda">
            <button type="submit" name="reset" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Kirim Link Reset
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="login.php" class="text-sm text-blue-600 hover:underline">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>
