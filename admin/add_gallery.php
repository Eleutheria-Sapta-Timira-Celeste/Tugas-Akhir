<?php
include '../connection/database.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['newImagesToAlbum'])) {
        $albumName = $_POST['albumName'];
        $albumId = $_POST['albumId'];
        $isSucess = false;
        // Count total files
        $countfiles = count($_FILES['file-upload-modified']['name']);
    
        // Looping all files
        for ($i = 0; $i < $countfiles; $i++) {
            $fileUploadName = $_FILES['file-upload-modified']['name'][$i];
            $fileUploadTmp = $_FILES['file-upload-modified']['tmp_name'][$i];
    
            $targetDirectory = '../assects/images/gallery/';
            $targetFilePath = "../assects/images/gallery/" . basename($fileUploadName);
            $sqlfileurl = "";
    
            if (move_uploaded_file($fileUploadTmp, $targetFilePath)) {
                $isSucess = true;
                $sqlfileurl = "assects/images/gallery/" . basename($fileUploadName);
    
                if ($connectionobj->connect_error) {
                    die("Connection failed: " . $connectionobj->connect_error);
                }
    
                // Insert data into the gallery_images table
                $sql = "INSERT INTO gallery_images (album, image_url) VALUES (?, ?)";
                $stmt = $connectionobj->prepare($sql);
                $stmt->bind_param("ss", $albumName, $sqlfileurl);
    
                if ($stmt->execute()) {
                    
                } else {
                    echo "Error: " . $stmt->error;
                }
    
                $stmt->close();
            } else {
                echo "Failed to move file.";
            }
        }
        echo '<script>alert("New images added successfully");
        window.location.replace("add_gallery.php");
        
        </script>';
        $connectionobj->close();
    }
    
    if (isset($_POST['deleteAlbum'])) {
        $album_Id = $_POST['album_Id'];
        mysqli_query($connection, "DELETE FROM `gallery_album` WHERE id = $album_Id;");
        echo '
            <script>
            window.location.replace("add_gallery.php");            
            </script>';
        exit;
    }
    if (isset($_POST['deleteImage'])) {
        $imageId = $_POST['imageId'];
        
        mysqli_query($connection, "DELETE FROM `gallery_images` WHERE id = $imageId;");
        echo '
            <script>
            window.location.replace("add_gallery.php");            
            </script>';
        exit;
    }

    if (isset($_POST["submit_new_album"])) {
        // Retrieve from album name field
        $album_name = $_POST["album_name"];

        // Insert data into the album talble and create new table according to album name field
        $sql = "INSERT INTO gallery_album (album_name) VALUES (?)";

        $stmt = $connectionobj->prepare($sql);

        $stmt->bind_param("s", $album_name);

        if ($stmt->execute()) {
            echo '
            <script>
            alert("New Album is Created")
            window.location.replace("add_gallery.php");
            
            </script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $connectionobj->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambahkan Galeri</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../assects/images/admin_logo.png">
    <link rel="stylesheet" href="../css/animation.css">

</head>

<body>
    <?php include "../includes/admin_header.php"; ?>




    <section class="text-gray-600 body-font">
        <div class="container px-5 py-10 mx-auto">
            <div class="flex flex-col text-center w-full mb-5">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-[#ef6c00]">Tambah Galeri</h1>
                <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base">
                Yth. Tim Pengelola Website Sekolah, Semoga dalam keadaan sehat dan lancar dalam menjalankan aktivitas.
                Mohon bantuannya untuk menambahkan dokumentasi kegiatan/proyek terbaru ke dalam website sekolah. Silakan masuk ke panel admin, pilih menu "Galeri", kemudian buat album baru yang sesuai dengan kegiatan tersebut. Setelah itu, unggah foto-foto terkait dan pastikan album tersebut diatur agar dapat ditampilkan kepada publik.
                Apabila membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi saya. Terima kasih atas kerja samanya.
                </p>
            </div>
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="mt-10 block text-white bg-[#ef6c00] hover:bg-[#e65c00] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]"
                type="button">
                Tambah Album Baru
            </button>
        </div>
    </section>


    <!-- Modal toggle -->


    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Buat Album Baru
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="" method="POST">
                        <div>
                            <label for="album_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Album</label>
                            <input type="text" name="album_name" id="album_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#cc5200] focus:border-[#cc5200] block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Nama Album Baru" required>
                        </div>


                        <button type="submit" name="submit_new_album"
                            class="w-full text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">Buat</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="mx-10 mb-10" id="accordion-color" data-accordion="collapse"
        data-active-classes="bg-[#cc5200] dark:bg-gray-800 text-[#ef6c00[ dark:text-white">
        <?php
        $fetch_all_album = "SELECT * FROM `gallery_album`;";
        $albums = mysqli_query($connection, $fetch_all_album);
        $totalAlbums = mysqli_num_rows($albums);

        if ($totalAlbums > 0) {
            while ($row = mysqli_fetch_assoc($albums)) {
                $albumId = $row["id"];
                $album_name = $row["album_name"];

                echo '
        
      <h2 id="accordion-color-heading-' . $albumId . '">
           <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-white border border-b-0 border-gray-50 bg-[#fa7c0f] hover:bg-[#e65c00] focus:ring-4 focus:ring-[#cc5200] dark:focus:ring-[#cc5200] dark:border-gray-700 gap-3"
                data-accordion-target="#accordion-color-body-' . $albumId . '" aria-expanded="false"
                aria-controls="accordion-color-body-' . $albumId . '">
                <span>' . $row["album_name"] . '</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>

        </h2>

        <div id="accordion-color-body-' .
                    $albumId .
                    '" class="hidden" aria-labelledby="accordion-color-heading-' .
                    $albumId .
                    '">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">


            <div class="flex justify-center m-5">
            <button  data-modal-target="addImagestoAlbum' .
                    $albumId .
                    '" data-modal-toggle="addImagestoAlbum' .
                    $albumId .
                    '" class="mx-5 block text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]" type="button">
                        Tambah Gambar
            </button>


            <button data-modal-target="deleteModal' .$albumId .'" data-modal-toggle="deleteModal' . $albumId .'" class="mx-5 block text-white bg-[#dc1209] hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
            Hapus Album?
            </button>
        </div>
        
        <!-- Add Images to album model -->

        <div id="addImagestoAlbum' .
                    $albumId .
                    '" tabindex="-1" aria-hidden="true"
        class="fadeIn hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Pilih Gambar Untuk ' . $album_name . '
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="addImagestoAlbum' .
                    $albumId .
                    '">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" enctype="multipart/form-data" action="" method="POST">
                        <div>
                            <label for="imagesSchoolMemories"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Gambar</label>
                                <input name="file-upload-modified[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" accept="image/*" required multiple>


                                <input name="albumName" class="hidden block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="' . $album_name . '" type="text">
                                <input name="albumId" class="hidden block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="' . $albumId . '" type="text">
                        </div>


                        <button type="submit" name="newImagesToAlbum"
                            class="w-full text-white bg-[#ef6c00] hover:bg-[#cc5200] focus:ring-4 focus:outline-none focus:ring-[#cc5200] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#ef6c00] dark:hover:bg-[#cc5200] dark:focus:ring-[#cc5200]">Tambah Gambar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>





        <!-- Main modal -->
        <div id="deleteModal' .
                    $albumId .
                    '" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal' .
                    $albumId .
                    '">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah kamu yakin ingin menghapus ' . $album_name . '?<br><br>CATATAN: Album akan dihapus dari panel admin dan dari website. Jika kamu berubah pikiran, kamu dapat memulihkannya kapan saja karena masih tersimpan di server.</p>
                    <div class="flex justify-center items-center space-x-4">

                    <form class="space-y-4" action="" method="POST">
                        <button data-modal-toggle="deleteModal' .
                    $albumId .
                    '" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Tidak, Batal
                        </button>
                        
                        <input type="text" value="'.$albumId.'" class="hidden" name="album_Id">
                        <button type="submit" name="deleteAlbum" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                          Ya, Saya yakin
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div> 


            
            <section class="bg-white dark:bg-gray-900">
        <div class="py-4 px-2 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">






        
            <div class="grid gap-2 lg:gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            
            
            ';

                $fetch_all_images =
                    "SELECT * FROM `gallery_images` WHERE album = ? ORDER BY id DESC";
                $stmt_images = mysqli_prepare($connection, $fetch_all_images);
                mysqli_stmt_bind_param($stmt_images, "s", $album_name);
                mysqli_stmt_execute($stmt_images);
                $result_images = mysqli_stmt_get_result($stmt_images);
                $total_images = mysqli_num_rows($result_images);

                if ($total_images > 0) {
                    while ($imagerow = mysqli_fetch_assoc($result_images)) {
                        $imageId = $imagerow["id"];
                        echo '
                 







            
                <div class="text-center text-gray-500 dark:text-gray-400">
                    <img style="transition: 0.3s;" class="object-cover object-center hover:object-scale-down  mx-auto mb-4 w-36 h-36 rounded-lg"
                        src="../' .
                            $imagerow["image_url"] .
                            '"
                        alt="cannot load image">
                    <ul class="flex justify-center mt-4 space-x-4">
                        <li>
                        <form action="" method="POST"  onsubmit="return confrimImageDelete()">
                        <input name="imageId" type="text" value="'.$imageId.'" class="hidden">
                            <button type="submit" name="deleteImage" class="text-[#39569c] hover:text-gray-900 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 482.428 482.429"
                                    xml:space="preserve" aria-hidden="true">
                                    <g>
                                        <g>
                                            <path d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098
			c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117
			h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828
			C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879
			C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096
			c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266
			c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979
			V115.744z" />
                                            <path d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07
			c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z" />
                                            <path d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07
			c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z" />
                                            <path d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07
			c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z" />
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            </form>
                        </li>
                    </ul>
                </div>
                ';
                    }
                }
                echo '  </div>
        </div>
    </section>

    
            </div>
        </div>';
            }
        }
        ?>

    </div>

    <?php include "../includes/admin_footer.php"; ?>



</body>
<script>
function confrimImageDelete() {
            var deleteImg = confirm("Are you sure want to delete this image");

            if (deleteImg) {
                return true;
            }
            return false;
        }
</script>

</html>