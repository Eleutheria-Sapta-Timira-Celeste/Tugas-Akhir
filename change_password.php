<?php
session_start();
include 'connection/database.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if (isset($_POST['submit'])) {
    $new_password = trim($_POST['new_password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $message = "Password berhasil diubah!";
    } else {
        $message = "Gagal mengubah password.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Ubah Password</title>
</head>
<body>
    <h2>Ubah Password</h2>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Password Baru:</label><br>
        <input type="password" name="new_password" required><br><br>
        <input type="submit" name="submit" value="Ubah Password">
    </form>
</body>
</html>
