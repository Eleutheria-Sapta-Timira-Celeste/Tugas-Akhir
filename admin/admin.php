<?php
include '../connection/database.php';
session_start();

// Cek login admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");

    exit();
}


$admin_id = $_SESSION['id'];

// Ambil data admin dari database
$getAdminQuery = "SELECT * FROM admin WHERE id = ?";
$stmt = $connectionobj->prepare($getAdminQuery);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$adminData = $result->fetch_assoc();

$defaultavatar = "../assects/defaults/logo_admin.png";

// Proses update admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {

    $previousPassword = $_POST['previousPassword'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confrimPassword'];
    $newUsername = $_POST['newUsername'];
    $newNamaAdmin = $_POST['newNamaAdmin'];
    $newEmail = $_POST['newEmail'];

    $IDImage = 'file-upload-modified';
    $fileUploadName = $_FILES[$IDImage]['name'];
    $fileUploadTmp = $_FILES[$IDImage]['tmp_name'];

    $targetDirectory = '../assects/images/admin_and_scribe/';
    $targetFilePath = $targetDirectory . basename($fileUploadName);

    $sqlfileurl = $_SESSION["logo"];

    if (!empty($fileUploadName)) {
        if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
            $sqlfileurl = "assects/images/admin_and_scribe/" . basename($fileUploadName);
            $_SESSION["logo"] = $sqlfileurl; // update session logo
        }
    }

    // Cek password lama
    $checkAdminQuery = "SELECT password FROM admin WHERE id = ?";
    $stmt2 = $connectionobj->prepare($checkAdminQuery);
    $stmt2->bind_param("i", $admin_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $row = $result2->fetch_assoc();

    if (password_verify($previousPassword, $row['password'])) {

        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE admin SET username=?, password=?, nama_admin=?, email=?, logo=? WHERE id=?";
        $stmt3 = $connectionobj->prepare($updateQuery);
        $stmt3->bind_param("sssssi", $newUsername, $hashedNewPassword, $newNamaAdmin, $newEmail, $sqlfileurl, $admin_id);

        if ($stmt3->execute()) {
            $_SESSION['username'] = $newUsername; // update session username
            echo '
            <script>
            alert("Data Admin berhasil diperbarui!");
            window.location.replace("admin.php");
            </script>
            ';
        } else {
            echo '<script>alert("Error update: ' . $stmt3->error . '");</script>';
        }

        $stmt3->close();

    } else {
        echo '
        <script>
        alert("Password lama salah!");
        </script>
        ';
    }

    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengaturan Admin</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- HEADER -->
    <?php include ('../includes/admin_header.php'); ?>

    <!-- SECTION ISI -->
    <main>
        <section class="text-gray-600 body-font px-5 py-10">
            <div class="container mx-auto">

                <div class="flex flex-col text-center w-full mb-5">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color: #ef6c00;">Pengaturan Admin</h1>
                    <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                        Di halaman ini, Anda dapat memperbarui data admin, mengganti logo, username, email, dan password.
                    </p>
                </div>

                <button data-modal-target="authentication-modal2" data-modal-toggle="authentication-modal2"
                    class="mt-10 block text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    🛡️ Ubah Detail Admin
                </button>

            </div>
        </section>
    </main>

    <!-- Modal update admin -->
    <div id="authentication-modal2" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Perbarui Informasi Admin
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal2">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validatePassword()">

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Foto / Logo</label>
                            <img src="../<?php echo !empty($adminData['logo']) ? $adminData['logo'] : $defaultavatar; ?>"
                                alt="Admin Logo" class="h-24 w-auto mb-3 rounded-lg border">
                            <input type="file" name="file-upload-modified" accept="image/*"
                                class="block w-full text-sm border border-gray-300 rounded-lg cursor-pointer">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Username</label>
                            <input type="text" name="newUsername" value="<?php echo htmlspecialchars($adminData['username']); ?>"
                                class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Nama Admin</label>
                            <input type="text" name="newNamaAdmin" value="<?php echo htmlspecialchars($adminData['nama_admin']); ?>"
                                class="w-full border px-3 py-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Email</label>
                            <input type="email" name="newEmail" value="<?php echo htmlspecialchars($adminData['email']); ?>"
                                class="w-full border px-3 py-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Password Lama</label>
                            <input type="password" name="previousPassword" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-semibold">Password Baru</label>
                            <input type="password" name="password" id="password"
                                class="w-full border px-3 py-2 rounded" minlength="8" required>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 font-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="confrimPassword" id="confirm_password"
                                class="w-full border px-3 py-2 rounded" minlength="8" required>
                        </div>

                        <button type="submit" name="update_admin"
                            class="w-full bg-[#ef6c00] hover:bg-[#cc5200] text-white font-semibold py-2 px-4 rounded">
                            Simpan Perubahan
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include ('../includes/admin_footer.php'); ?>

    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password != confirm_password) {
                alert("Password baru tidak cocok!");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
