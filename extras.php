<?php
include 'connection/database.php';

try {

    // Ambil media gambar utama (optional)
    $imageResult = mysqli_query($connection, "SELECT * FROM media WHERE type = 'image' and position = 'informasi_sekolah' ORDER BY uploaded_at DESC LIMIT 1");
    $topImage = mysqli_fetch_assoc($imageResult);

    $query = "SELECT * FROM web_content WHERE id = 6";
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
    <title>Informasi Sekolah</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="javaScript/extras.js"></script>
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">

</head>

<body>
    <?php include("includes/header.php") ?>

    <?php if ($topImage): ?>
    <div class="relative w-full h-60 sm:h-[500px] overflow-hidden mb-6">
        <img src="<?= $topImage['path'] ?>" alt="Gambar Utama" class="w-full h-full object-cover shadow-md">
    </div>
    <?php endif; ?>

    <main>
        <section class="text-gray-600 body-font">
            <div class="container px-5 py-10 mx-auto">
                <div class="flex flex-col text-center w-full mb-20">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4" style="color:#a9745a;">
                    Informasi Sekolah</h1>
                    <p class="text-sm md:text-base lg:w-2/3 mx-auto leading-relaxed text-base"><?php echo $row['one'];?>
                    </p>
                </div>
                <div class="flex flex-wrap -m-2">
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="gallery()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                                src="assects/images/extras_avatar/galery.jpg">
                            <div class="flex-grow">
                               <h2 class="title-font font-medium" style="color: #a9745a;">Galeri</h2>
                                <p class="text-sm md:text-base text-gray-500">Kegiatan, Momen, dan Hari Besar</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="schoolroutine()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                                src="assects/images/extras_avatar/jad.jpg">
                            <div class="flex-grow">
                                <h2 class="title-font font-medium" style="color: #a9745a;">Jadwal Kelas</h2>
                                <p class="text-sm md:text-base text-gray-500">Jadwal Kelas Sekolah</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="nepalicalender()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100  object-contain object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                                src="assects/images/extras_avatar/calle.jpg">
                            <div class="flex-grow">
                         <h2 class="title-font font-medium" style="color: #a9745a;">Kalender Akademik</h2></h2>
                                <p class="text-sm md:text-base text-gray-500">Liburan, Hari Besar, Pendidikan</p>
                            </div>
                        </div>
                    </div>
                   <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="window.location.href='kurikulum.php'">
                    <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100 cursor-pointer">
                        <img alt="team"
                            class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                            src="assects/images/extras_avatar/kurikulum.jpg">
                        <div class="flex-grow">
                            <h2 class="title-font font-medium" style="color: #a9745a;">Kurikulum</h2>
                            <p class="text-sm md:text-base text-gray-500">Kurikulum Merdeka</p>
                        </div>
                    </div>
</div>

                    
                   
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full" onclick="staffs()">
                        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                                src="assects/images/extras_avatar/stafff.jpg">
                            <div class="flex-grow">
                                <h2 class="title-font font-medium" style="color: #a9745a;">Tenaga Kependidikan</h2></h2>
                                <p class="text-sm md:text-base text-gray-500">Pimpinan dan Staff Sekolah
                                   </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
                        <div data-modal-target="default-modal" data-modal-toggle="default-modal"
                            class="h-full flex items-center border-gray-200 border p-4 rounded-lg hover:bg-blue-100">
                            <img alt="team"
                                class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4 p-1"
                                src="assects/images/extras_avatar/medsos.jpg">
                            <div class="flex-grow">
                        <h2 class="title-font font-medium" style="color: #a9745a;">Sosial Media</h2></h2>
                                <p class="text-sm md:text-base text-gray-500">Terhubung di Platform Lain</p>
                            </div>
                        </div>
                    </div>
                    
                        
                </div>
            </div>
            <!-- Main modal -->
            <div id="default-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Our Social Links
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                                               

                            
                            

                            

                        
                            

                           
<div class="p-4 md:p-5 space-y-4">
    <!-- WhatsApp -->
    <a href="https://wa.me/6281234567890" target="_blank">
        <button type="button"
            class="mb-2 inline-flex items-center rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out"
            style="background-color: #25D366">
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.04 2.003a9.951 9.951 0 0 0-9.951 9.95c0 1.756.47 3.406 1.28 4.838L2 22l5.35-1.373a9.95 9.95 0 0 0 4.69 1.195h.001a9.951 9.951 0 0 0 9.95-9.95 9.95 9.95 0 0 0-9.951-9.95zm0 18.14a8.17 8.17 0 0 1-4.172-1.143l-.3-.179-3.17.814.844-3.088-.195-.317a8.145 8.145 0 1 1 15.145-4.087 8.147 8.147 0 0 1-8.152 8zm4.49-6.176c-.246-.123-1.45-.715-1.674-.797-.224-.083-.388-.123-.552.123s-.633.796-.776.96c-.143.164-.285.185-.53.061-.245-.123-1.036-.381-1.972-1.215-.729-.65-1.221-1.45-1.365-1.695-.143-.245-.016-.377.108-.5.112-.111.245-.286.368-.429.122-.143.163-.245.245-.408.082-.163.041-.306-.02-.428-.061-.123-.551-1.327-.756-1.82-.199-.48-.402-.413-.551-.421l-.47-.008a.899.899 0 0 0-.653.306c-.224.245-.857.837-.857 2.04 0 1.203.877 2.367 1 .523.123.245 1.72 2.63 4.172 3.687.583.253 1.037.403 1.391.513.584.185 1.115.159 1.535.097.468-.07 1.45-.591 1.656-1.162.204-.57.204-1.059.143-1.162-.06-.102-.224-.163-.47-.285z"/>
            </svg>
            WhatsApp
        </button>
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com/smpgri371official" target="_blank">
        <button type="button"
            class="mb-2 inline-flex items-center rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out"
            style="background-color: #E1306C">
            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.75 2h8.5C18.55 2 20 3.45 20 5.25v13.5c0 1.8-1.45 3.25-3.25 3.25h-8.5C5.45 22 4 20.55 4 18.75V5.25C4 3.45 5.45 2 7.75 2zM12 7.25a4.75 4.75 0 1 0 0 9.5 4.75 4.75 0 0 0 0-9.5zm0 7.75a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm4.75-8.25a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5z"/>
            </svg>
            Instagram
        </button>
    </a>
                            

                        
                           

                          
                            

                           

                           
                            
                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="default-modal" type="button"
                                class="text-white bg-[#5c3d15] hover:bg-[#4b320f] focus:ring-4 focus:outline-none focus:ring-[#4b320f] font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#5c3d15] dark:hover:bg-[#4b320f] dark:focus:ring-[#4b320f]">Tutup</button>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
<script>
console.clear();
</script>

</html>