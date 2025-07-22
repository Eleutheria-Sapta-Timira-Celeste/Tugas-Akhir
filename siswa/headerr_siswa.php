<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const logo = document.getElementById('sidebar-logo');
    const menuTexts = document.querySelectorAll('.menu-text');
    const mainContent = document.getElementById('main-content');

    const isExpanded = sidebar.classList.contains('w-64');

    if (isExpanded) {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        logo.classList.add('w-10', 'h-10');
        logo.classList.remove('w-16', 'h-16');
        mainContent.classList.remove('ml-64');
        mainContent.classList.add('ml-20');
        menuTexts.forEach(text => text.classList.add('hidden'));
        localStorage.setItem('sidebarState', 'collapsed');
    } else {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-64');
        logo.classList.remove('w-10', 'h-10');
        logo.classList.add('w-16', 'h-16');
        mainContent.classList.remove('ml-20');
        mainContent.classList.add('ml-64');
        menuTexts.forEach(text => text.classList.remove('hidden'));
        localStorage.setItem('sidebarState', 'expanded');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById('sidebar');
    const logo = document.getElementById('sidebar-logo');
    const menuTexts = document.querySelectorAll('.menu-text');
    const mainContent = document.getElementById('main-content');
    const state = localStorage.getItem('sidebarState');

    if (state === 'collapsed') {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        logo.classList.add('w-10', 'h-10');
        logo.classList.remove('w-16', 'h-16');
        mainContent.classList.remove('ml-64');
        mainContent.classList.add('ml-20');
        menuTexts.forEach(text => text.classList.add('hidden'));
    }
});
</script>
<header class="bg-[#bd8035] text-white flex items-center justify-between h-16 px-4 transition-all duration-300">
    <div class="flex items-center gap-4">
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none">
            ☰
        </button>
        <span class="font-bold text-lg">SMP PGRI 371 Pondok Aren</span>
    </div>
</header>
