<?php
include 'connection/database.php';

try {

    $query = "SELECT * FROM web_content WHERE id = 4";
    $result = mysqli_query($connection, $query);


    if ($result) {

        $row = mysqli_fetch_assoc($result);
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
    <title>Hubungi Kami</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">

</head>

<body>
    <?php include('includes/header.php') ?>
    <main>

        <section class="text-gray-600 body-font">
            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                    <img class="object-cover object-center rounded" alt="hero" src="assects/images/schoolImages/beranda2.jpg">
                </div>
                <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-[#ef6c00]">Hubungi Kami
                        <br class="hidden lg:inline-block">
                    </h1>
                    <p class="text-sm md:text-base text-justify mb-8 leading-relaxed"><?php echo $row['one']; ?></p>
                    <div class="flex justify-center">
                        <button class="inline-flex text-white border-0 py-2 px-6 focus:outline-none rounded text-lg" style="background-color: #ef6c00;" onmouseover="this.style.backgroundColor='#d65f00'"
                        onmouseout="this.style.backgroundColor='#ef6c00'" onclick="callschool()">Telepon </button>
                        <button class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg" onclick="mailschool()">Pesan</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap pt-0">
                <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
                    <iframe width="100%" height="100%" class="absolute inset-0" frameborder="0" title="map" marginheight="0" marginwidth="0" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0066111507244!2d106.71516667366417!3d-6.262858293725734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fbde4fad8e85%3A0x3b42dbae77127176!2sSMP%20PGRI%20371%20Pondok%20Aren!5e0!3m2!1sid!2sid!4v1746365234125!5m2!1sid!2sid" style="filter: grayscale(0) contrast(1.2) opacity(0.7);"></iframe>
                    <div class="pr-2 bg-white relative flex flex-wrap py-6 rounded shadow-md">
                        <div class="lg:w-1/2 px-6">
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">Alamat</h2>
                            <p class="text-sm md:text-base text-justify mt-1 cursor-pointer" onclick="locationmap()"> Jl. Puskesmas No.6, Pondok Aren, Tangerang Selatan</p>
                        </div>
                        <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">EMAIL</h2>
                            <a class="text-sm md:text-base text-justify text-indigo-500 leading-relaxed cursor-pointer" onclick="mailschool()"> 371smppgri@gmail.com</a>
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">Telepon</h2>
                            <p class="text-sm md:text-base text-justify leading-relaxed cursor-pointer" onclick="callschool()"> 021-2272-6571</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Umpan Balik</h2>
                    <p class="text-sm md:text-base leading-relaxed mb-5 text-gray-600">Masukan Anda yang sangat berharga bagi sekolah kami sangat ditunggu dan dihargai di sini.</p>
                    <form method="post" action="">
                        <div class="relative mb-4 hidesent">
                            <label for="name" class="leading-7 text-sm text-gray-600">Nama</label>
                            <input required type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4 hidesent">
                            <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                            <input required type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4 hidesent">
                            <label for="message" class="leading-7 text-sm text-gray-600">Pesan</label>
                            <textarea required id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>


                       <div id="alert-border-3" class="flex items-center p-4 mb-4 border-t-4 rounded-md closethank inlinefeed" 
                        style="background-color: #fffdcf; color: #000; border-color: #fffdcf;" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4 inlinefeed" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                         fill="currentColor" viewBox="0 0 20 20">
                         <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 
                         1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 
                        1v4h1a1 1 0 0 1 0 2Z" />
                         </svg>
                    <div class="ms-3 text-sm font-medium inlinefeed">
                        Terima Kasih Atas Saran dan Masukan Anda
                    </div>
                <button onclick="closethankfeedback()" type="button" 
                    class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:opacity-80 inline-flex items-center justify-center h-8 w-8 inlinefeed" 
                    style="background-color: #fffdcf; color: #000;" data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Batalkan</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                     </svg>
                    </button>
                </div>
                       <button class="text-white border-0 py-2 px-6 focus:outline-none rounded text-lg"
                         style="background-color: #ef6c00; hover:background-color;">
                             Kirim
                        </button>


                    </form>
                    <p class="text-xs text-gray-500 mt-3 feedbacktext">Masukan Anda akan diteruskan ke Admin Sekolah.</p>
                </div>
            </div>
        </section>

    </main>
    <script>
        document.getElementsByClassName('closethank')[0].style.display = 'none';

        function closethankfeedback() {
            document.getElementsByClassName('closethank')[0].style.display = 'none';
            document.getElementsByClassName('hidesent')[0].style.display = 'block';
            document.getElementsByClassName('hidesent')[1].style.display = 'block';
            document.getElementsByClassName('hidesent')[2].style.display = 'block';
            document.getElementsByClassName('feedbacktext')[0].innerHTML = "Masukan Anda akan diteruskan ke Admin Sekolah.";
        }
    </script>
    <?php include('includes/footer.php') ?>
</body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('Asia/Kathmandu');
    $currentDate = date("d/m/Y");
    $currentTime = date("h:i A");
    


    $mysqli = $connectionobj;

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contactfeedback (date, time, name, email, message) VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sssss", $currentDate, $currentTime, $name, $email, $message);

    if ($stmt->execute()) {
        mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = total_notification + 1 WHERE id = 2");
        echo "
            <script>
            document.getElementsByClassName('closethank')[0].style.display = 'block';
            document.getElementsByClassName('inlinefeed')[0].style.display = 'inline-block';
            document.getElementsByClassName('inlinefeed')[1].style.display = 'inline-block';
            document.getElementsByClassName('inlinefeed')[2].style.display = 'inline';
            document.getElementsByClassName('inlinefeed')[3].style.display = 'inline';
            document.getElementsByClassName('hidesent')[0].style.display = 'none';
            document.getElementsByClassName('hidesent')[1].style.display = 'none';
            document.getElementsByClassName('hidesent')[2].style.display = 'none';
            document.getElementsByClassName('feedbacktext')[0].innerHTML = 'Masukan dan saranmu akan kami teruskan ke admin sekolah.';
            </script>
        ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
<script>console.clear();</script>

</html>
