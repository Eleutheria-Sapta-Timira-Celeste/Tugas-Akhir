<?php
include 'connection/database.php';

try {

    $query = "SELECT * FROM web_content WHERE id = 5";
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
    <title>SPMB</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">
    <script>
        function conactUs() {
            window.location.href = "contactUs.php";
        }

        function showContent() {
            document.getElementsByClassName("hide_after_submission")[0].style.display = "block";
            document.getElementsByClassName("hide_after_submission")[1].style.display = "block";
            document.getElementsByClassName("thankyou_register")[0].style.display = "none";
        }
        console.clear();
    </script>

</head>

<body>
    <?php include ("includes/header.php") ?>

    <section class="text-gray-600 body-font" id="joinUsSection">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="hero" src="assects/images/flashNotice/spmb.jpg">
            </div>
            <div
                class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium" style="color: #ef6c00;">SPMB
                    <br class="hidden lg:inline-block">
                </h1>
                <p class="mb-8 leading-relaxed">
                    <?php echo $row['one']; ?>
                </p>
                <div id="spmb_siswa" class="flex justify-center">
                    <a href="spmb/index.php" class="btn">
                        <button
                            class="inline-flex text-white bg-[#ef6c00] border-0 py-2 px-6 focus:outline-none hover:bg-[#e65c00] rounded text-lg">Klik untuk mendaftarkan </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <?php include ("includes/footer.php") ?>
</body>

<script>
    function displayFileName() {
        var fileInput = document.getElementById('file-upload');
        var fileInfoContainer = document.getElementById('file-info');


        if (fileInput.files.length > 0) {
            fileInfoContainer.innerHTML = '         File: ' + fileInput.files[0].name;
            fileInfoContainer.classList.remove('hidden');

        }
    }

    function displayFileNameShow() {
        var fileInput = document.getElementById('dropzone-file');
        var fileInfoContainer = document.getElementById('file-info-modified');

        if (fileInput.files.length > 0) {
            fileInfoContainer.innerHTML = 'File: ' + fileInput.files[0].name;
            fileInfoContainer.classList.remove('hidden');
        }
    }
</script>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fileUploadName = $_FILES['file-upload']['name'];
    $fileUploadTmp = $_FILES['file-upload']['tmp_name'];


    $targetDirectory = 'assects/images/Registered_Students/';
    $targetFilePath = "assects/images/Registered_Students/" . basename($fileUploadName);
    $sqlfileurl = "";

    if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {

        $sqlfileurl = "../assects/images/Registered_Students/" . basename($fileUploadName);
    }

    if ($connectionobj->connect_error) {
        die("Connectionobj failed: " . $connectionobj->connect_error);
    }

    date_default_timezone_set('Asia/Kathmandu');
    $currentDate = date("d/m/Y");
    $currentTime = date("h:i A");

    // Retrieve the details from the form
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $father_name = $_POST["father_name"];
    $mother_name = $_POST["mother_name"];
    $admit_to = $_POST["admit_to"];
    $previous_school = $_POST["previous_school"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $intro = $_POST["intro"];

    $registered_on = $currentDate . " " . $currentTime;

    // Insert data into the admission_form table
    $sql = "INSERT INTO `admission_form` (`full_name`, `address`, `gender`, `dob`, `father_name`, `mother_name`, `admit_to`, `previous_school`, `email`, `phone`, `intro`, `registered_on`, `image_url`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $connectionobj->prepare($sql);

    $stmt->bind_param("sssssssssssss", $full_name, $address, $gender, $dob, $father_name, $mother_name, $admit_to, $previous_school, $email, $phone, $intro, $registered_on, $sqlfileurl);

    if ($stmt->execute()) {
        mysqli_query($connectionobj, "UPDATE `notification` SET total_notification = total_notification + 1 WHERE id = 1");
        echo '
            <script>
            document.getElementsByClassName("hide_after_submission")[0].style.display = "none";
                    document.getElementsByClassName("hide_after_submission")[1].style.display = "none";
                    document.getElementsByClassName("thankyou_register")[0].style.display = "block";
            </script>
        ';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

}

?>
</html>