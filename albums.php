<?php
session_start();
include 'connection/database.php';

if (isset($_POST['sessionAlbum'])) {
    $albumname = $_POST["albumname"];
    $_SESSION["selectedAlbum"] = $albumname;
    echo '
        <script>
        window.location.replace("gallery.php");
        
        </script>';
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums Sekolah</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="css/utilities.css">
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/animation.css">
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">

    <style>

    </style>
</head>
<?php include('includes/header.php') ?>

<div class="bg-white dark:bg-[#fdf6f6] h-full py-2 sm:py-2 lg:py-5 mb-7">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8 mt-5">
        <div class="mb-4 flex items-center justify-between gap-8 sm:mb-8 md:mb-12">
            <div class="flex items-center gap-12">
                <h2 class="text-2xl font-bold text-[#ef6c00] lg:text-3xl dark:text-[#e65c00]">Galeri</h2>

                <p class="hidden max-w-screen-sm text-gray-500 dark:text-gray-800 md:block">
                Silakan buka galeri sekolah untuk mengakses dan melihat semua gambar yang ada di dalamnya
                </p>
            </div>           
        </div>        
    </div>
    
</div>



<section class="mb-10 text-gray-600 body-font">
    <div class="container px-5 py-0 mx-auto">
        <div class="flex flex-wrap -m-4">

            <?php
            $fetch_all_album = "SELECT * FROM `gallery_album`;";
            $albums = mysqli_query($connection, $fetch_all_album);
            $totalAlbums = mysqli_num_rows($albums);

            if ($totalAlbums > 0) {
                while ($row = mysqli_fetch_assoc($albums)) {
                    $album_name = $row["album_name"];
                    $fetch_latest_photo = "SELECT image_url FROM `gallery_images` WHERE album = '$album_name' ORDER BY id DESC LIMIT 1;";
                    $photo_result = mysqli_query($connection, $fetch_latest_photo);

                    if ($photo_result && mysqli_num_rows($photo_result) > 0) {
                        $photo_row = mysqli_fetch_assoc($photo_result);
                        $latest_photo_url = $photo_row["image_url"];

                        echo '
                        <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                            <a class="block relative h-48 rounded overflow-hidden">
                                <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="'.$latest_photo_url.'">
                            </a>
                            <div class="mt-4">
                            <form method="post" id="album' . $album_name. '">
                                <h2 class="text-gray-900 title-font text-lg font-medium">'.$album_name.'</h2>
                                <input type="hidden" name="albumname" value="' . $album_name . '" />
                                <button type="submit" name="sessionAlbum" class="mt-1 focus:outline-none text-white bg-[#ef6c00] hover:bg-[#e65c00] focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-[#ef6c00] dark:hover:bg-[#e65c00] dark:focus:ring-orange-500">Open</button>

                            </form>
                            </div>
                        </div>';
                    }
                }
            }
            ?>

        </div>
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<?php include('includes/footer.php') ?>

</body>
<script>
console.clear();
</script>

</html>