<div class="p-6">
    <h1 class="text-2xl font-semibold text-[#bd8035] mb-4">Selamat datang, <?= htmlspecialchars($user['nama']) ?>!</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Profil</h2>
            <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']) ?></p>
            <p><strong>NIP:</strong> <?= htmlspecialchars($user['nip']) ?></p>
            <p><strong>Gelar:</strong> <?= htmlspecialchars($user['gelar']) ?></p>
            <p><strong>Mapel:</strong> <?= htmlspecialchars($user['mapel']) ?></p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Info Kegiatan</h2>
            <p>Silakan gunakan menu di sidebar untuk mengisi absensi harian.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Notifikasi</h2>
            <p>Belum ada notifikasi baru.</p>
        </div>
    </div>
</div>
