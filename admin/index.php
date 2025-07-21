<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex">

    <?php include 'sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-h-screen ml-64 transition-all duration-300" id="main-content">
        <?php include 'headerr_admin.php'; ?>
        <?php include 'dashboard.php'; ?>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const labels = document.querySelectorAll('.sidebar-label');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-16');

            mainContent.classList.toggle('ml-64');
            mainContent.classList.toggle('ml-16');

            labels.forEach(label => {
                label.classList.toggle('hidden');
            });
        });
    </script>

</body>
</html>
