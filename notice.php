<?php
include 'connection/database.php';

    // Ambil media gambar utama (optional)
    $imageResult = mysqli_query($connection, "SELECT * FROM media WHERE type = 'image' and position = 'pengumuman' ORDER BY uploaded_at DESC LIMIT 1");
    $topImage = mysqli_fetch_assoc($imageResult);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assects/images/logo2.png">
</head>

<body>
    <?php include("includes/header.php") ?>
   <?php if ($topImage): ?>
    <div class="relative w-full h-60 sm:h-[500px] overflow-hidden mb-6">
        <img src="<?= $topImage['path'] ?>" alt="Gambar Utama" class="w-full h-full object-cover shadow-md">
    </div>
    <?php endif; ?>

    <div class="text-center mt-10">
    <h2 class="text-3xl font-bold text-[#8A6640] border-b-4 inline-block border-[#8A6640] mb-0">
        Pengumuman Sekolah
    </h2>
    </div>

    <script>
        window.onload = function () {
            let alertBox = document.getElementById("alert-border-3");
            alertBox.style.display = "flex";
            setTimeout(() => {
                alertBox.style.opacity = "1";
            }, 200);
        };

        function closethankfeedback() {
            let alertBox = document.getElementById("alert-border-3");
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.style.display = "none";
            }, 500);
        }
    </script>

    <?php
    $fetch_notice_data = "SELECT * FROM `school_notice` ORDER BY id DESC;";
    $notices = mysqli_query($connection, $fetch_notice_data);
    $totalNotice = mysqli_num_rows($notices);

    if ($totalNotice > 0) {
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-6 px-4 md:px-6 lg:px-8 animate-fadeIn">';
        while ($row = mysqli_fetch_assoc($notices)) {
            echo '
                <div class="max-w-xl mx-auto px-4 py-4 bg-white shadow-md rounded-lg transition duration-500 hover:shadow-xl hover:scale-105">
                    <div class="py-2 flex flex-row items-center justify-between">
                        <div class="flex flex-row items-center">
                            <a class="flex flex-row items-center focus:outline-none focus:shadow-outline rounded-lg">
                                <img class="rounded-full h-8 w-8 object-cover" src="' . $row['logo'] . '" alt="">
                                <p class="ml-2 text-base font-medium text-sm md:text-base">' . $row['posted_by'] . '</p>
                            </a>
                        </div>
                        <div class="flex flex-row items-center">
                            <p class="text-xs font-semibold text-gray-500">' . $row['time'] . '&#160;&#160;' . $row['date'] . '</p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <img class="object-cover w-full rounded-lg shadow-md transition duration-500 hover:scale-105 hover:shadow-xl" src="' . $row['image_url'] . '" alt="">
                        <div class="py-2 flex flex-row items-center">
                            <button onclick="view(\'' . $row['image_url'] . '\', ' . $row['id'] . ')" class="flex flex-row items-center focus:outline-none focus:shadow-outline rounded-lg ml-3 hover:scale-105 transition duration-300">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                                <span class="ml-1">' . $row['total_views'] . '</span>
                            </button>

                            <button onclick="download(\'' . $row['image_url'] . '\', ' . $row['id'] . ')" class="flex flex-row items-center focus:outline-none focus:shadow-outline rounded-lg ml-3 hover:scale-105 transition duration-300">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 11l5 5l5 -5" />
                                    <path d="M12 4l0 12" />
                                </svg>
                                <span class="ml-1">' . $row['total_downloads'] . '</span>
                            </button>
                        </div>
                    </div>
                    <div class="py-2">
                        <p class="mb-2 text-base font-medium text-sm md:text-base break-words">Subject: ' . $row['about'] . '</p>
                        <p class="text-justify leading-snug text-base text-sm md:text-base break-words">' . $row['notice_description'] . '</p>
                    </div>
                </div>
            ';
        }
        echo '</div>';
    }
    ?>

    <?php include("includes/footer.php") ?>
</body>

<script>
    function closedialouge() {
        document.getElementsByClassName('closewarn')[0].style.display = 'none';
    }

    function view(url, id) {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=view&notice_id=${id}`
        }).then(() => {
            window.open(url, '_blank');
        });
    }

    function download(url, id) {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=download&notice_id=${id}`
        }).then(() => {
            const a = document.createElement('a');
            a.href = url;
            a.download = url.split('/').pop();
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    }

    console.clear();
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && isset($_POST['notice_id'])) {
        $action = $_POST['action'];
        $notice_id = (int)$_POST['notice_id'];

        if ($action === 'view') {
            mysqli_query($connection, "UPDATE `school_notice` SET total_views = total_views + 1 WHERE id = $notice_id");
        } elseif ($action === 'download') {
            mysqli_query($connection, "UPDATE `school_notice` SET total_downloads = total_downloads + 1 WHERE id = $notice_id");
        }
        exit;
    }
}
?>
</html>
