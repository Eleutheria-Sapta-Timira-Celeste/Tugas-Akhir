<?php
include '../connection/database.php';
session_start();
include('../includes/siswa_header.php'); 


// Check if the user is not logged in
if (!isset($_SESSION["identity_code"])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is not a student (siswa)
if ($_SESSION["issiswa"] != 1) {
    header("Location: ../login.php");
    exit();
}

try {
    $query = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";

    $result = mysqli_query($connection, $query);
    $feedback_result = mysqli_query($connection, $query2);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $feedback = mysqli_fetch_assoc($feedback_result);
    } else {
        echo "Error executing the query: " . mysqli_error($connection);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa | Dashboard</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
</head>
<body>
    <?php include('../includes/siswa_header.php') ?>

    <main>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-blue-600">Welcome to Student Panel</h1>
                    <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                        Selamat datang di Panel Siswa! 📚 Akses semua informasi terkait pembelajaranmu di sini.
                    </p>
                </div>
                <div class="flex flex-wrap -m-2">
                    <!-- Card untuk melihat jadwal -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="mySchedule()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="../assects/images/adminavatars/routine.png" alt="schedule">
                            <div class="flex-grow">
                                <h2 class="text-blue-600 title-font font-medium">Jadwal Saya</h2>
                                <p class="text-sm md:text-base text-gray-500">Lihat jadwal pelajaran Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk mengakses materi -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="studyMaterials()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="../assects/images/adminavatars/site content.jpg" alt="materials">
                            <div class="flex-grow">
                                <h2 class="text-blue-600 title-font font-medium">Materi Belajar</h2>
                                <p class="text-sm md:text-base text-gray-500">Akses materi pembelajaran Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card untuk feedback -->
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="giveFeedback()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="../assects/images/adminavatars/feedback.png" alt="feedback">
                            <div class="flex-grow">
                                <h2 class="text-blue-600 title-font font-medium">Berikan Feedback</h2>
                                <p class="text-sm md:text-base text-gray-500">Kirimkan masukanmu tentang website</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('../includes/siswa_footer.php') ?>
</body>

<script>
function mySchedule() {
    window.location.href = "my_schedule.php";
}

function studyMaterials() {
    window.location.href = "study_materials.php";
}

function giveFeedback() {
    window.location.href = "give_feedback.php";
}
</script>

</html>
