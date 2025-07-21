<!-- header_admin.php -->
<header class="bg-white shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <button id="menu-toggle" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none text-2xl">
            &#9776;
        </button>
        <h1 class="text-xl font-bold text-[#d49f5f] tracking-wide">Admin Panel</h1>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm font-medium text-gray-600">Halo, Admin</span>
        <img src="../assects/images/defaults/avatar_admin.png" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-[#d49f5f]">
    </div>
</header>

<!-- Toggle Script -->
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
