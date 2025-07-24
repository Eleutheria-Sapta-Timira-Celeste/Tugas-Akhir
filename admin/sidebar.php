<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

try {
    $query1 = "SELECT * FROM notification WHERE id = 1";
    $query2 = "SELECT * FROM notification WHERE id = 2";
    $result1 = mysqli_query($connection, $query1);
    $result2 = mysqli_query($connection, $query2);

    if ($result1 && $result2) {
        $row = mysqli_fetch_assoc($result1);
        $feedback = mysqli_fetch_assoc($result2);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    mysqli_close($connection);
}
?>
<aside id="sidebar" class="bg-[#d49f5f] text-white h-screen fixed top-0 left-0 w-64 flex flex-col transition-all duration-300 ease-in-out z-40 overflow-y-auto mt-auto">
    <div class="p-4 text-center border-b border-orange-300">
        <img src="../assects/images/defaults/logo_warna.png" alt="Logo" class="mx-auto mb-2 w-16 h-16">
        <span class="text-sm font-bold sidebar-label block">SMP PGRI 371 Pondok Aren</span>
    </div>
    <nav class="mt-4 flex flex-col px-2 space-y-1 text-sm">
        <button onclick="flash_notice()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📝 <span class="sidebar-label">Kartu Sambutan</span>
        </button>
        <button onclick="add_notice()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📢 <span class="sidebar-label">Tambah Pengumuman</span>
        </button>
        <button onclick="registered_students()" class="hover:bg-[#bd8035] p-2 rounded flex items-center justify-between">
            <div class="flex items-center gap-3">
                👨‍🎓 <span class="sidebar-label">Pendaftar</span>
            </div>
            <?php if ($row['total_notification'] != 0): ?>
                <span class="bg-red-600 px-2 py-0.5 text-xs rounded-full"><?= $row['total_notification']; ?></span>
            <?php endif; ?>
        </button>
        <button onclick="changeRoutine()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📅 <span class="sidebar-label">Jadwal Kelas</span>
        </button>
        <button onclick="changeStaff()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            👥 <span class="sidebar-label">Ubah Staff</span>
        </button>
        <button onclick="site_content()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            🌐 <span class="sidebar-label">Konten Website</span>
        </button>
        <button onclick="add_gallery()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            🖼️ <span class="sidebar-label">Tambah Galeri</span>
        </button>
        <button onclick="feedback_page()" class="hover:bg-[#bd8035] p-2 rounded flex items-center justify-between">
            <div class="flex items-center gap-3">
                💬 <span class="sidebar-label">Feedback</span>
            </div>
            <?php if ($feedback['total_notification'] != 0): ?>
                <span class="bg-red-600 px-2 py-0.5 text-xs rounded-full"><?= $feedback['total_notification']; ?></span>
            <?php endif; ?>
        </button>
        <button onclick="admin()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            🔐 <span class="sidebar-label">Kelola Admin</span>
        </button>
        <button onclick="siswa_management()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📋 <span class="sidebar-label">Akun Siswa</span>
        </button>
        <button onclick="guru_management()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📘 <span class="sidebar-label">Akun Guru</span>
        </button>
        <button onclick="kelola_kurikulum()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            📚 <span class="sidebar-label">Kurikulum</span>
        </button>
        <button onclick="homepage_media()" class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            🏠 <span class="sidebar-label">Media Beranda</span>
        </button>
        
        
        <button onclick="logoutsession()" 
            class="hover:bg-[#bd8035] p-2 rounded flex items-center gap-3">
            ⏻ <span class="sidebar-label"> Logout <?php echo $_SESSION["username"]; ?></span>
        </button>

        <div class="mt-auto px-3 pb-4"></div>
    </div>
        
    </nav>
</aside>




<script>
        function add_notice() { window.location.href = "index.php?page=add_notice"; }
        function site_content() { window.location.href = "index.php?page=site_content"; }
        function feedback_page() { window.location.href = "index.php?page=feedback"; }
        function flash_notice() { window.location.href = "index.php?page=flash_notice"; }
        function add_gallery() { window.location.href = "index.php?page=add_gallery"; }
        function registered_students() { window.location.href = "index.php?page=registered_students"; }
        function changeRoutine() { window.location.href = "index.php?page=changeRoutine"; }
        function changeStaff() { window.location.href = "index.php?page=changeStaff"; }
        function admin() { window.location.href = "index.php?page=admin_management"; }
        function siswa_management() { window.location.href = "index.php?page=siswa_management"; }
        function guru_management() { window.location.href = "index.php?page=guru_management"; }
        function kelola_kurikulum() { window.location.href = "index.php?page=kelola_kurikulum"; }
        function homepage_media() { window.location.href = "index.php?page=media_upload"; }
        function logoutsession() {
    if (confirm("Yakin ingin logout?")) {
        window.location.href = "/Tugas-Akhir/logout.php";
    }
}

    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const labels = document.querySelectorAll('.sidebar-label');

    let sidebarCollapsed = false;

    toggleButton.addEventListener('click', () => {
        sidebarCollapsed = !sidebarCollapsed;

        if (sidebarCollapsed) {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');
            labels.forEach(label => label.classList.add('hidden'));
        } else {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');
            labels.forEach(label => label.classList.remove('hidden'));
        }
    });
});
</script>

