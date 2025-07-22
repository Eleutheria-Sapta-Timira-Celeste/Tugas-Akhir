<?php
include '../connection/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek hak akses admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Tugas-Akhir/login.php");
    exit();
}

// Ambil konten kurikulum
$result = $connectionobj->query("SELECT * FROM konten_kurikulum LIMIT 1");
$kurikulum = $result && $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Proses update jika form disubmit
if (isset($_POST['update_kurikulum']) && $kurikulum) {
    $judul = $_POST['judul'];
    $subjudul = $_POST['subjudul'];
    $deskripsi_singkat = $_POST['deskripsi_singkat'];
    $deskripsi_panjang = $_POST['deskripsi_panjang'];

    $stmt = $connectionobj->prepare("UPDATE konten_kurikulum SET judul=?, subjudul=?, deskripsi_singkat=?, deskripsi_panjang=? WHERE id=?");
    $stmt->bind_param("ssssi", $judul, $subjudul, $deskripsi_singkat, $deskripsi_panjang, $kurikulum['id']);
    $stmt->execute();
    $stmt->close();

    // Simpan pesan sukses dan redirect
    $_SESSION['success_message'] = "Konten kurikulum berhasil diperbarui!";
echo "<script>window.location.href='index.php?page=kelola_kurikulum';</script>";
exit();

}
?>


<main class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-orange-600 mb-4">Edit Konten Kurikulum</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 rounded">
                <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if ($kurikulum): ?>
        <form method="POST">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="judul" class="w-full mb-4 border rounded p-2" required
                value="<?= htmlspecialchars($kurikulum['judul']) ?>">

            <label class="block font-semibold mb-1">Subjudul</label>
            <input type="text" name="subjudul" class="w-full mb-4 border rounded p-2" required
                value="<?= htmlspecialchars($kurikulum['subjudul']) ?>">

            <label class="block font-semibold mb-1">Deskripsi Singkat</label>
            <textarea name="deskripsi_singkat" class="w-full mb-4 border rounded p-2" rows="3"><?= htmlspecialchars($kurikulum['deskripsi_singkat']) ?></textarea>

            <label class="block font-semibold mb-1">Deskripsi Panjang</label>
            <textarea name="deskripsi_panjang" class="w-full mb-4 border rounded p-2" rows="8"><?= htmlspecialchars($kurikulum['deskripsi_panjang']) ?></textarea>

            <div class="text-right">
                <button type="submit" name="update_kurikulum" class="bg-orange-500 text-white px-5 py-2 rounded hover:bg-orange-600">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
        <?php else: ?>
            <p class="text-red-600">❗ Konten kurikulum belum tersedia. Tambahkan terlebih dahulu melalui database.</p>
        <?php endif; ?>
    </div>
</main>


