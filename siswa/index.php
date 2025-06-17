<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Login Siswa</h2>
    <form action="auth.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700">NIS</label>
        <input type="text" name="nis" required class="w-full px-4 py-2 border rounded">
      </div>
      <div>
        <label class="block text-gray-700">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded">
      </div>
      <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
      <p class="text-sm text-center mt-2">Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Daftar di sini</a></p>
    </form>
  </div>
</body>
</html>
