-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jul 2025 pada 15.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pgri371`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama_siswa` varchar(100) DEFAULT NULL,
  `guru` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_admin`, `email`, `logo`, `created_at`) VALUES
(1, 'Administrator', '$2y$10$2hm20Xtu97CnC04KVYz9..DmiR.7rsBvJmgTek50C2Rmbu05JNfU2', 'Administrator', 'info.smppgri371@gmail.com', 'assects/images/admin_and_scribe/logo_warna.png', '2025-06-23 15:31:11'),
(2, 'Admin', '$2y$10$UgevOwX4Cr8sJ0d1Q5HJ3uUaiLpSgoLX5LSJU3/pDEpBWnO8Xrj8W', 'Dela Rustiana Sari', 'delarustianasarii@gmail.com', 'assects/images/admin_and_scribe/Logo STMIK Antar Bangsa.png', '2025-07-25 13:44:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contactfeedback`
--

CREATE TABLE `contactfeedback` (
  `id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(30) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `message` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `contactfeedback`
--

INSERT INTO `contactfeedback` (`id`, `date`, `time`, `name`, `email`, `message`) VALUES
(52, '05/05/2025', '03:26 PM', 'Gracia', 'nlala8868@gmail.com', 'Sekolah yang bagus'),
(56, '16/05/2025', '10:19 PM', 'Yola Nabilah', 'nabilahyola@gmail.com', 'Sekolah yang bagus'),
(57, '16/05/2025', '10:23 PM', 'Lala', 'nlala8868@gmail.com', 'Sekolah yang bagus dan cocok untuk anak anak mengembangkan ilmu'),
(58, '16/05/2025', '10:31 PM', 'Lala', 'nlala8868@gmail.com', 'Sekolah yang bagus dan cocok untuk anak anak mengembangkan ilmu'),
(59, '16/05/2025', '10:32 PM', 'Yola Nabilah', 'nabilbilaaa2@gmail.com', 'bagus'),
(60, '16/05/2025', '10:38 PM', 'Yola Nabilah', 'nabilbilaaa2@gmail.com', 'bagus'),
(61, '16/05/2025', '10:39 PM', 'Yola Nabilah', 'nabilbilaaa2@gmail.com', 'bagus'),
(62, '16/05/2025', '10:40 PM', 'Yola Nabilah', 'nabilbilaaa2@gmail.com', 'bagus'),
(63, '16/05/2025', '11:01 PM', 'Yola Nabilah', 'nabilbilaaa2@gmail.com', 'bagus'),
(64, '17/05/2025', '08:31 PM', 'dela', 'dela123@gmail.com', 'selalu upgrade kualitas sekolh'),
(65, '23/06/2025', '01:26 AM', 'Gracia', 'yasyasinta471@gmail.com', 'nice school'),
(66, '04/07/2025', '09:10 PM', 'Yola Nabilah', 'nabilahyola@gmail.com', 'sekolah yang penuh dengan ilmu yang bermanfaat'),
(67, '04/07/2025', '09:11 PM', 'Yola Nabilah', 'nabilahyola@gmail.com', 'sekolah yang penuh dengan ilmu yang bermanfaat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `flash_notice`
--

CREATE TABLE `flash_notice` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `trun_flash` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `flash_notice`
--

INSERT INTO `flash_notice` (`id`, `title`, `image_url`, `message`, `trun_flash`) VALUES
(1, 'PENDAFTARAN DIBUKA!!', 'assects/images/flashNotice/spmb.jpg', 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026 SMP PGRI 371 Pondok Aren\r\nBergabunglah bersama kami dan wujudkan masa depan cerah!\r\nTersedia program pendidikan berkualitas dengan fokus pada pembentukan karakter, ilmu pengetahuan, dan keterampilan.\r\nDaftar sekarang dan raih peluang terbaik untuk masa depan!', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_album`
--

CREATE TABLE `gallery_album` (
  `id` int(11) NOT NULL,
  `album_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `gallery_album`
--

INSERT INTO `gallery_album` (`id`, `album_name`) VALUES
(16, 'Pekemahan Jumat Sabtu'),
(17, 'Memperingati Hari Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `album` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `album`, `image_url`) VALUES
(29, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.07 (1).jpeg'),
(30, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.07.jpeg'),
(31, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.06 (1).jpeg'),
(32, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.06.jpeg'),
(34, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.05 (1).jpeg'),
(35, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.04.jpeg'),
(36, 'Pekemahan Jumat Sabtu', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.05 (2).jpeg'),
(37, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.59.jpeg'),
(38, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.58 (2).jpeg'),
(39, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.58 (1).jpeg'),
(40, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.58.jpeg'),
(42, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.57 (1).jpeg'),
(43, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.57.jpeg'),
(44, 'Memperingati Hari Guru', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.30.56.jpeg'),
(45, 'Perkemahan Jumat Sabtu 1', 'assects/images/gallery/WhatsApp Image 2025-05-19 at 13.22.04.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `gelar` varchar(50) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `posisi_staff` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `username`, `email`, `password`, `nama`, `nip`, `gelar`, `mapel`, `foto`, `posisi_staff`) VALUES
(1, 'guru01', 'sumiati@gmail.com', '$2y$10$a.8/wv8xAfBTMhwVr0rNIup3.prjdjH8KwgFRpFiE/N3YvyOxTuB6', 'Sumiati', '110191919197788109', 'S.Pd', 'Matematika', 'sumiati.jpg', 'Bendahara Sekolah, & PKS Bidang Kesiswaan'),
(2, 'guru02', 'suhemah@gmail.com', '$2y$10$sy31X/aAn77W.IICuvg/b.EmRcYLXnyu9E7dfEeTwH/0FgEH9kiOW', 'Suhemah', '112209218189153490', 'S.Pd', 'IPA', 'suhemah.jpg', 'Guru IPA'),
(3, 'guru03', 'rita@gmail.com', '$2y$10$cmjz9B9Ham07YeqOqVngoeM5siiqOzRhFD.zdDCz8CbH9lDeX1P8S', 'Rita Fahriani', '101919176171717160', 'S.Pd', 'IPS', 'rita.jpg', 'Guru IPS'),
(4, 'guru04', 'bayu@gmail.com', '$2y$10$0OZRb0F6ul0IkXAoeud86OyLCxHnrXK22og1vXRk1na69b/bbh68m', 'Bayu Heru Nugroho', '217181929271791234', '-', 'PJOK', 'bayu.jpg', 'Guru PJOK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam` varchar(20) DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `konten_kurikulum`
--

CREATE TABLE `konten_kurikulum` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `subjudul` varchar(255) NOT NULL,
  `deskripsi_singkat` text DEFAULT NULL,
  `deskripsi_panjang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konten_kurikulum`
--

INSERT INTO `konten_kurikulum` (`id`, `judul`, `subjudul`, `deskripsi_singkat`, `deskripsi_panjang`) VALUES
(1, 'Kurikulum', 'Tentang Kurikulum Merdeka', 'SMP PGRI 371 Pondok Aren telah menerapkan Kurikulum Merdeka sebagai bentuk komitmen dalam meningkatkan kualitas pembelajaran yang berfokus pada pengembangan karakter, potensi, dan kemandirian siswa.', 'Kurikulum Merdeka adalah kurikulum yang dirancang oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia sebagai upaya transformasi sistem pembelajaran di Indonesia. Kurikulum ini memberikan keleluasaan bagi satuan pendidikan dan pendidik untuk menyesuaikan proses belajar dengan kebutuhan dan potensi peserta didik. Pendekatan yang digunakan berfokus pada pengembangan kompetensi esensial dan karakter siswa melalui pembelajaran yang lebih kontekstual, interaktif, dan menyenangkan. Dengan adanya kebebasan dalam menentukan materi ajar serta pelaksanaan projek penguatan Profil Pelajar Pancasila, Kurikulum Merdeka mendorong terciptanya suasana belajar yang mandiri, aktif, dan kolaboratif.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manipulators`
--

CREATE TABLE `manipulators` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `identity_code` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `image` varchar(500) NOT NULL,
  `last_update` datetime DEFAULT current_timestamp(),
  `role` enum('admin','author','guru','murid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manipulators`
--

INSERT INTO `manipulators` (`id`, `name`, `identity_code`, `password`, `image`, `last_update`, `role`) VALUES
(1, ' Administrator', '12345678', '12345678', 'assects/images/admin_and_scribe/pgri-putih.png', NULL, 'admin'),
(2, 'Admin_1', '2120021', '12345678', 'assects/images/admin_and_scribe/avatar.png', '0000-00-00 00:00:00', 'author'),
(7, 'Guru_1', '000', '123', 'assets/images/guru/avatar1.png', '2025-05-26 08:31:45', 'guru'),
(8, 'Guru_2', '111', '123', 'assets/images/guru/avatar2.png', '2025-05-26 08:31:45', 'guru'),
(9, 'Murid_1', '222', '123', 'assets/images/murid/avatar1.png', '2025-05-26 08:31:45', 'murid'),
(10, 'Murid_2', '333', '123', 'assets/images/murid/avatar2.png', '2025-05-26 08:31:45', 'murid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `type` enum('image','video','youtube') NOT NULL,
  `path` text NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp(),
  `position` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `media`
--

INSERT INTO `media` (`id`, `type`, `path`, `uploaded_at`, `position`) VALUES
(1, 'video', 'admin/uploads/1752932667_document_6329962164220074353.mp4', '2025-07-19 20:44:27', 'home'),
(3, 'image', 'admin/uploads/1752936511_gedung_utama.jpg', '2025-07-19 21:48:31', 'aboutus'),
(8, 'image', 'admin/uploads/1752939821_lapangan.jpg', '2025-07-19 22:43:41', 'pengumuman'),
(11, 'image', 'admin/uploads/1752940542_siswa_foto.jpg', '2025-07-19 22:55:42', 'informasi_sekolah'),
(13, 'image', 'admin/uploads/1753542293_WhatsApp Image 2025-07-22 at 20.03.27.jpeg', '2025-07-26 22:04:53', 'hubungi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `page` varchar(30) NOT NULL,
  `site` varchar(20) NOT NULL,
  `total_notification` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `notification`
--

INSERT INTO `notification` (`id`, `page`, `site`, `total_notification`) VALUES
(1, 'join_us', 'new_students', 0),
(2, 'contact_us', 'new_feedback', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pimpinan_sekolah`
--

CREATE TABLE `pimpinan_sekolah` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `position` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `image_src` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pimpinan_sekolah`
--

INSERT INTO `pimpinan_sekolah` (`id`, `name`, `position`, `contact_no`, `image_src`) VALUES
(39, 'Sukardi, S.Pd.I., M.M', 'Kepala Sekolah SMP', '984464031667898765', 'assects/images/staff/sukardi.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schoolroutine`
--

CREATE TABLE `schoolroutine` (
  `id` int(11) NOT NULL,
  `class` varchar(1000) DEFAULT NULL,
  `routine_url` varchar(1000) DEFAULT NULL,
  `last_modified` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `schoolroutine`
--

INSERT INTO `schoolroutine` (`id`, `class`, `routine_url`, `last_modified`) VALUES
(1, 'Kelas IX', 'assects/images/Routines/kelas 9.png', '22:24 12/07/2025'),
(5, 'Kelas VIII', 'assects/images/Routines/kelas 8.png', '22:24 12/07/2025'),
(19, 'Kelas VII', 'assects/images/Routines/kelas 7.png', '20:50 12/07/2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `school_notice`
--

CREATE TABLE `school_notice` (
  `id` int(11) NOT NULL,
  `logo` varchar(999) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `image_url` varchar(999) NOT NULL,
  `about` varchar(500) NOT NULL,
  `notice_description` varchar(9999) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(30) NOT NULL,
  `total_views` int(10) NOT NULL,
  `total_downloads` int(10) NOT NULL,
  `last_modified` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `school_notice`
--

INSERT INTO `school_notice` (`id`, `logo`, `posted_by`, `image_url`, `about`, `notice_description`, `date`, `time`, `total_views`, `total_downloads`, `last_modified`) VALUES
(124, 'assects/images/admin_and_scribe/logo_warna.png', 'administrator', 'assects/images/notices_files/back to school.jpg', 'Pengumuman Awal Masuk Sekolah Tahun Ajaran 2025/2026', 'Tahun ajaran baru 2025/2026 akan dimulai pada Senin, 14 Juli 2025.\r\nSeluruh siswa SMP diharapkan hadir tepat waktu dan mempersiapkan perlengkapan sekolah dengan baik.\r\nMari kita songsong tahun pelajaran ini dengan semangat dan disiplin!', '09/07/2025', '09:47 PM', 1, 1, 'Not Modified'),
(125, 'assects/images/admin_and_scribe/logo_warna.png', 'administrator', 'assects/images/notices_files/informasi pembagian kelas.png', ' Informasi Pembagian Kelas Siswa SMP PGRI 371 Pondok Aren Tahun Ajaran 2025/2026', ' Hai siswa-siswi SMP!\r\nPembagian kelas untuk tahun ajaran baru akan diumumkan pada Jumat, 12 Juli 2025, melalui papan pengumuman sekolah dan grup resmi WhatsApp kelas.\r\nYuk, cek kelas barumu dan siap-siap kenalan dengan teman-teman baru! 😄', '09/07/2025', '09:58 PM', 0, 0, 'Not Modified'),
(126, 'assects/images/admin_and_scribe/logo_warna.png', 'administrator', 'assects/images/notices_files/MPLS Sekolah Banner.png', ' Pengumuman Jadwal MPLS (Masa Pengenalan Lingkungan Sekolah)', '🎉 Selamat datang untuk seluruh siswa baru SMP!\r\nMPLS akan dilaksanakan pada tanggal 14–16 Juli 2025 pukul 13.00 – 16.30 WIB.\r\nWajib hadir dengan seragam putih biru lengkap, membawa alat tulis, dan tetap semangat!\r\nMari mulai perjalanan barumu dengan pengalaman yang seru dan positif! 🚀', '09/07/2025', '10:02 PM', 0, 0, 'Not Modified');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki - Laki','Perempuan') DEFAULT 'Laki - Laki',
  `alamat` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `username`, `email`, `nama`, `nis`, `kelas`, `tempat_lahir`, `tanggal_lahir`, `nama_ayah`, `nama_ibu`, `foto`, `password`, `jenis_kelamin`, `alamat`, `no_telepon`) VALUES
(1, 'siswa01', 'nabilbilaaa2@gmail.com', 'Nabila', '1223334444', 'VII', 'Jakarta', '2011-04-30', 'Kunto', 'Putri Jayanti', '686d2db2bef45_foto.jpg', '$2y$10$QUYtwKOR4IKg10Zc3mWwJutPlS3KC1xC54eWe6pwDl2UbeZdVjFJ6', 'Perempuan', 'Jl. Bugenvile 1', '08999562195'),
(2, 'siswa02', 'allysha@gmail.com', 'Allysha', '1223334440', 'VIII', 'Tangerang', '2025-07-12', 'Aji', 'Pratiwi', 'foto.jpg', '$2y$10$2C8.rig8jHnmDpWbMKz8GeHw6aGwd7twhQNIonDKaZ6QAMngj85pm', 'Perempuan', 'Jl. Kencana Putra', '08999562195'),
(3, 'siswa03', 'yasyasinta471@gmail.com', 'Putri', '1223334232', 'IX', 'Medan', '0000-00-00', 'Endang', 'Fatiah', 'foto.jpg', '$2y$10$EvEE/wW5srkyhKTADGYIB.fgE1.ElQHVeYyNWtHgwzJV3XWZGyXP.', 'Perempuan', 'Jl. Korlantas Lama', '08999241189'),
(4, 'siswa05', 'delarustianasarii@gmail.com', 'Jihan Putri', '0987657896', 'VII', 'Tangerang', '2025-07-19', 'Tio', 'Gina', 'Logo STMIK Antar Bangsa.png', '$2y$10$YSHmiEiYVI88.LQBn3vrJ.4MPQ0bazo5r0iaMmTwAZZPxsAbc174q', 'Perempuan', 'Jl Pondok Kacang Timur', '085772892884');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spmb`
--

CREATE TABLE `spmb` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `alamat_tinggal` text DEFAULT NULL,
  `tempat_tinggal` enum('Bersama Orang Tua','Wali','Kos','Lainnya') DEFAULT NULL,
  `moda_transportasi` varchar(100) DEFAULT NULL,
  `anak_keberapa` int(11) DEFAULT NULL,
  `jumlah_saudara_kandung` int(11) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `penerima_kip` enum('Ya','Tidak') DEFAULT NULL,
  `no_kip` varchar(30) DEFAULT NULL,
  `tinggi_cm` int(11) DEFAULT NULL,
  `berat_kg` int(11) DEFAULT NULL,
  `jarak_tempat_tinggal` varchar(50) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nik_ayah` varchar(20) DEFAULT NULL,
  `tempat_lahir_ayah` varchar(50) DEFAULT NULL,
  `tanggal_lahir_ayah` date DEFAULT NULL,
  `pendidikan_ayah` varchar(50) DEFAULT NULL,
  `pekerjaan_ayah` varchar(50) DEFAULT NULL,
  `penghasilan_ayah` int(11) DEFAULT NULL,
  `no_telp_ayah` varchar(20) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `nik_ibu` varchar(20) DEFAULT NULL,
  `tempat_lahir_ibu` varchar(50) DEFAULT NULL,
  `tanggal_lahir_ibu` date DEFAULT NULL,
  `pendidikan_ibu` varchar(50) DEFAULT NULL,
  `pekerjaan_ibu` varchar(50) DEFAULT NULL,
  `penghasilan_ibu` int(11) DEFAULT NULL,
  `no_telp_ibu` varchar(20) DEFAULT NULL,
  `foto_pas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spmb`
--

INSERT INTO `spmb` (`id`, `nama_lengkap`, `jenis_kelamin`, `nis`, `nik`, `tempat_lahir`, `tanggal_lahir`, `agama`, `alamat_tinggal`, `tempat_tinggal`, `moda_transportasi`, `anak_keberapa`, `jumlah_saudara_kandung`, `no_telp`, `penerima_kip`, `no_kip`, `tinggi_cm`, `berat_kg`, `jarak_tempat_tinggal`, `nama_ayah`, `nik_ayah`, `tempat_lahir_ayah`, `tanggal_lahir_ayah`, `pendidikan_ayah`, `pekerjaan_ayah`, `penghasilan_ayah`, `no_telp_ayah`, `nama_ibu`, `nik_ibu`, `tempat_lahir_ibu`, `tanggal_lahir_ibu`, `pendidikan_ibu`, `pekerjaan_ibu`, `penghasilan_ibu`, `no_telp_ibu`, `foto_pas`, `created_at`) VALUES
(1, 'Byeon-Woo-Seok', 'Laki-laki', '1223334444', '3321012404030009', 'Tangerang', '2025-07-07', 'Islam', 'Jl. Kenangan Indah', 'Bersama Orang Tua', 'Mobil', 1, 2, '08999562195', 'Ya', '88888888899', 192, 67, '3 km', 'Jae-Wook', '2828292200008111', 'Sumedang', '2025-07-07', 'SLTA', 'Buruh', 100000000, '09999999', 'Hye-Yeon', '2828887127277221', 'Solo', '2025-07-07', 'SMP', 'Buruh', 900000, '0999991000', '1751896035_foto.jpg', '2025-07-07 13:47:15'),
(2, 'Shopee Anggraeni', 'Perempuan', '1223334121', '3321012404030017', 'Tangerang', '2025-07-14', 'Islam', 'Jl. Kenangan Indah', 'Bersama Orang Tua', 'Motor', 1, 2, '08999562195', 'Ya', '88888888899', 155, 34, '3 km', 'Kunto', '2828292200101222', 'Sumedang', '2025-07-14', 'SLTA', 'Buruh', 100000000, '09999999', 'Putri Jayanti', '2828887127277221', 'Solo', '2025-07-14', 'S1', 'Ibu Rumah Tangga', 9000000, '09999910925', '1752502284_foto.jpg', '2025-07-14 14:11:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `post` varchar(100) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `image_src` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `post`, `qualification`, `contact`, `image_src`) VALUES
(1, 'Sumiati, S.Pd', 'Bendahara & PKS Bidang Kesiswaan', 'S.Pd', '9844640316', 'assects/images/staff/6122720573781034406.jpg'),
(2, 'M. Aden Muchtar', 'PKS Bidang Kurikulum & Wali Kelas IX', 'S.Pd', '9804903845', 'assects/images/staff/6122720573781034405.jpg'),
(3, 'Adi Ersa', 'Kepala Tata Usaha', 'S.Pd', '9842438801', 'assects/images/staff/avatar.png'),
(4, 'Rita Fahriani', 'Guru IPS', 'S.Pd', '9860155878', 'assects/images/staff/6122720573781034402.jpg'),
(5, 'Bayu Heru Nugroho', 'Pembina Osis dan Wali Kelas VIII', 'S.Pd', '9842751110', 'assects/images/staff/6122720573781034403.jpg'),
(6, 'Noor Shadad Afriansyah', 'Wali Kelas VIII & Guru Bahasa Inggris', 'S.Pd', '9815948821', 'assects/images/staff/avatar.png'),
(7, 'Dedy Adnan', 'Guru BTQ', 'S.Pd', '9814951994', 'assects/images/staff/6122720573781034404.jpg'),
(48, 'Suhemah', 'Guru ', 'S.Pd', '123456', 'assects/images/staff/6122720573781034407.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`, `image`) VALUES
(1, 'admin01', 'admin123', 'admin', 'Admin Utama', 'default.png'),
(2, 'guru01', 'guru123', 'guru', 'Pak Guru', 'default.png'),
(3, 'siswa01', 'siswa123', 'siswa', 'Budi Siswa', 'default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `web_content`
--

CREATE TABLE `web_content` (
  `id` int(11) NOT NULL,
  `content_about` varchar(500) NOT NULL,
  `one` varchar(1000) NOT NULL,
  `two` varchar(1000) NOT NULL,
  `three` varchar(1000) NOT NULL,
  `four` varchar(1000) NOT NULL,
  `five` varchar(1000) NOT NULL,
  `six` varchar(1000) NOT NULL,
  `seven` varchar(1000) NOT NULL,
  `eight` varchar(1000) NOT NULL,
  `nine` varchar(500) NOT NULL,
  `ten` varchar(500) NOT NULL,
  `eleven` varchar(500) NOT NULL,
  `twelve` varchar(500) NOT NULL,
  `thirteen` varchar(500) NOT NULL,
  `fourteen` varchar(500) NOT NULL,
  `fifteen` varchar(1000) NOT NULL,
  `sixteen` varchar(1000) NOT NULL,
  `seventeen` varchar(500) NOT NULL,
  `eighteen` varchar(500) NOT NULL,
  `ninteen` varchar(500) NOT NULL,
  `twenty` varchar(500) NOT NULL,
  `twentyone` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `web_content`
--

INSERT INTO `web_content` (`id`, `content_about`, `one`, `two`, `three`, `four`, `five`, `six`, `seven`, `eight`, `nine`, `ten`, `eleven`, `twelve`, `thirteen`, `fourteen`, `fifteen`, `sixteen`, `seventeen`, `eighteen`, `ninteen`, `twenty`, `twentyone`) VALUES
(1, 'index', 'Kami berkomitmen untuk menciptakan generasi yang berakhlak mulia, berilmu, berpengetahuan, serta berwawasan lingkungan. SMP PGRI 371 Pondok Aren mendukung setiap peserta didik agar mampu melanjutkan ke jenjang pendidikan yang lebih tinggi, dengan fondasi moral dan akademik yang kuat. Sebagai lembaga pendidikan yang ramah lingkungan dan religius, kami menanamkan nilai-nilai luhur dan sikap disiplin kepada siswa sejak dini.', 'Banyak alasan mengapa SMP PGRI 371 menjadi pilihan tepat untuk masa depan anak Anda:\r\n✅ Guru Profesional & Berkualitas\r\nGuru-guru berdedikasi yang membimbing siswa tidak hanya dalam pelajaran akademik, tetapi juga dalam pembentukan karakter.\r\n✅ Lingkungan Belajar Nyaman & Religius\r\nSuasana sekolah yang kondusif, bersih, dan mendukung perkembangan spiritual serta kedisiplinan siswa.\r\n✅ Pembelajaran Berbasis Teknologi\r\nKami mengintegrasikan teknologi dalam proses pembelajaran agar siswa siap menghadapi tantangan zaman.\r\n✅ Pembentukan Karakter Jujur & Disiplin\r\nKami mendidik siswa agar menjadi pribadi yang jujur, bertanggung jawab, dan disiplin dalam kehidupan sehari-hari.', 'Guru-guru kami memiliki kualifikasi tinggi dan berdedikasi untuk memberikan pembelajaran terbaik bagi siswa.', 'Lingkungan belajar kami mendukung kenyamanan dan ketenangan dalam kegiatan belajar mengajar.', 'Kami memanfaatkan teknologi digital untuk memperluas akses siswa terhadap pembelajaran yang modern dan efektif.\r\n\r\n', 'SMP PGRI 371 dilengkapi dengan fasilitas pendidikan yang mendukung berbagai kegiatan akademik dan non-akademik siswa.', 'Lingkungan belajar di SMP PGRI 371 Pondok Aren sangat menyenangkan, terbuka, dan penuh semangat. Para guru dan staf di sekolah ini luar biasa — mereka ramah, sabar, dan selalu siap membantu. Kami merasa senang belajar di sekolah ini karena para guru membuat suasana kelas menjadi nyaman dan mudah untuk berinteraksi.\r\n\r\nDi sekolah, kami mempelajari berbagai materi yang menarik dan relevan dengan masa depan kami. Dukungan dari para guru sangat membantu kami dalam memahami pelajaran dan menghadapi tantangan dengan percaya diri. Selain itu, sekolah juga rutin mengadakan kegiatan ekstrakurikuler yang sangat bermanfaat untuk mengembangkan keterampilan sosial, kerja sama, dan kepercayaan diri kami.', 'SMP PGRI 371 Pondok Aren mulai menerapkan sistem Ujian Berbasis Online sejak tahun 2024 untuk siswa kelas 7 sebagai tahap awal. Saat ini, pelaksanaan ujian online telah mencakup siswa dari kelas 7 hingga kelas 9 secara rutin.\r\n\r\nUjian berbasis online merupakan salah satu bentuk pemanfaatan teknologi dalam dunia pendidikan yang bertujuan untuk meningkatkan efisiensi, kecepatan, dan akurasi dalam proses evaluasi belajar siswa. Melalui sistem ini, siswa dapat mengerjakan soal-soal ujian menggunakan perangkat seperti komputer atau tablet, baik di laboratorium sekolah maupun di ruang kelas yang telah disiapkan.\r\n\r\nSelain mendukung program digitalisasi sekolah, ujian online juga membantu siswa lebih terbiasa dengan penggunaan teknologi dalam proses belajar, serta mempersiapkan mereka menghadapi tantangan pendidikan di masa depan.', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'about', 'SMP PGRI 371 Pondok Aren terletak di kawasan Pondok Aren, Tangerang Selatan. Sekolah ini melayani jenjang pendidikan dari kelas 7 hingga kelas 9 dengan pendekatan pembelajaran yang aktif, menyenangkan, dan membentuk karakter positif pada siswa.\r\n\r\nDipimpin oleh Kepala Sekolah Bapak Sukardi, S.Pd.I., M.M, kegiatan belajar mengajar dilaksanakan setiap hari dari pukul 13.00 hingga 17.00 WIB.\r\nSekolah menyediakan lingkungan belajar yang aman dan nyaman, dengan fasilitas pendukung seperti ruang kelas yang tertata rapi, lapangan olahraga, air bersih, toilet terpisah untuk putra dan putri.\r\nSelain kegiatan akademik, SMP PGRI 371 Pondok Aren juga rutin mengadakan berbagai kegiatan ekstrakurikuler seperti pramuka. Kegiatan ini membantu siswa mengembangkan bakat, meningkatkan percaya diri, dan memperkuat kemampuan sosial mereka.\r\nMelalui suasana belajar yang kondusif dan dukungan dari seluruh warga sekolah, kami berkomitmen untuk mencetak siswa yang berprestasi, sopan, dan siap menghadapi masa d', 'Saya sangat senang dan bersyukur mendapat kepercayaan untuk menjabat sebagai Kepala Sekolah di SMP PGRI 371 Pondok Aren. Terima kasih kepada seluruh tim manajemen dan yayasan atas kepercayaan yang diberikan kepada saya untuk memimpin sekolah ini.\r\n\r\nKami berkomitmen untuk memberikan pendidikan berkualitas yang tidak hanya mendorong siswa untuk mencintai proses belajar, tetapi juga membentuk mereka menjadi pribadi yang bermanfaat bagi masyarakat. Tujuan kami adalah membantu setiap siswa mencapai potensi terbaiknya, baik dalam bidang akademik maupun karakter.\r\n\r\nKami juga sangat terbuka kepada orang tua. Silakan datang kapan saja untuk berdiskusi mengenai perkembangan dan pendidikan putra-putri Anda. Kami sedang membangun komunitas belajar yang positif, aktif, dan berorientasi pada keunggulan, dengan semangat kebersamaan antara guru, siswa, dan orang tua.', 'Untuk menciptakan lingkungan belajar yang tertib, aman, dan nyaman, seluruh warga sekolah wajib mematuhi tata tertib berikut:', 'Siswa wajib hadir tepat waktu', 'Siswa wajib menggunakan seragam lengkap sesuai jadwal', 'Siswa wajib bersikap sopan dan hormat kepada guru, staf, dan sesama siswa.', 'Menjaga nama baik sekolah di dalam dan luar lingkungan sekolah', 'Dilarang membawa dan menggunakan ponsel saat jam pelajaran, kecuali atas izin guru.', 'Bersikap baik', 'Mengerjakan tugas tepat waktu', 'Dilarang meninggalkan kelas tanpa izin guru', 'Dilarang membawa senjata tajam, rokok, minuman keras, narkoba, atau barang berbahaya lainnya.', 'Dilarang berisik saat jam pelajaran dimulai', 'SMP PGRI 371 Pondok Aren secara rutin mengadakan berbagai kegiatan menarik seperti perkemahan Pramuka, peringatan hari besar nasional, hingga acara kebersamaan dan kreativitas siswa.\r\nMelalui kegiatan ini, diharapkan siswa dapat memperkuat rasa kebersamaan, disiplin, serta semangat menghargai nilai-nilai kebangsaan dan karakter positif.', 'Kegiatan Perkemahan Pramuka SMP PGRI 371 Pondok Aren\r\nSebagai bagian dari pendidikan karakter dan kemandirian siswa, SMP PGRI 371 Pondok Aren melaksanakan kegiatan Perkemahan Pramuka yang diikuti oleh peserta didik dari berbagai tingkatan kelas.\r\nKegiatan ini bertujuan untuk menumbuhkan semangat gotong royong, kepemimpinan, disiplin, dan cinta alam dalam suasana penuh kebersamaan.\r\nTerima kasih kepada seluruh pembina, guru, dan siswa yang telah berpartisipasi aktif.\r\nPramuka Hebat, Siswa Bermartabat!', 'Peringatan Hari Guru Nasional di SMP PGRI 371 Pondok Aren\r\nDalam rangka memperingati Hari Guru Nasional, SMP PGRI 371 Pondok Aren menggelar serangkaian kegiatan yang penuh makna sebagai bentuk penghargaan terhadap dedikasi dan perjuangan para pendidik.\r\nSuasana haru dan hangat menyelimuti peringatan ini, dengan penampilan dari siswa, pemberian penghargaan simbolis, serta momen kebersamaan yang mempererat hubungan antara guru dan murid.\r\nTerima kasih, Guru! Atas ilmu, kesabaran, dan kasih sayang yang tak pernah lelah diberikan.\r\n\"Engkaulah pelita dalam gulita, pahlawan tanpa tanda jasa.\"', 'SMP PGRI 371 Pondok Aren menyediakan berbagai fasilitas untuk mendukung kenyamanan dan kualitas pembelajaran, seperti ruang kelas ber-AC, perpustakaan, lapangan olahraga, UKS, dan MCK.\r\nKami juga aktif mengembangkan minat dan bakat siswa melalui kegiatan ekstrakurikuler seperti Pramuka, Futsal, Marawis, Tari, Badminton, dan Vokal.\r\nBersama kami, mari tumbuh menjadi generasi yang berprestasi dan berkarakter! ', 'Ruang kelas yang nyaman dengan AC membantu menciptakan suasana belajar yang lebih fokus dan menyenangkan. Dengan lingkungan yang bersih dan rapi, siswa dapat belajar dengan lebih maksimal tanpa terganggu oleh suhu panas.', 'Lapangan olahraga adalah tempat ideal bagi siswa untuk berolahraga dan menyalurkan energi secara positif. Kegiatan fisik yang menyenangkan ini juga mengajarkan pentingnya kerjasama tim dan menjaga kesehatan tubuh.', 'Lapangan olahraga yang bersih dan terawat memastikan kenyamanan serta keamanan di sekolah. Siswa dapat beraktivitas fisik dengan leluasa, yang mendukung gaya hidup sehat dan kebugaran tubuh sekaligus menjaga kebersihan lingkungan sekolah.', 'UKS menyediakan fasilitas kesehatan bagi siswa yang membutuhkan pertolongan pertama. Dengan tenaga medis yang siap sedia, siswa dapat merasa lebih aman saat mengalami masalah kesehatan ringan di sekolah.'),
(3, 'notice', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'contactus', 'Selamat Datang di SMP PGRI 371 Pondok Aren, Sekolah yang menghadirkan lingkungan belajar yang inspiratif dan beragam, dengan komitmen membentuk generasi berkarakter, berilmu, dan berprestasi.\r\nUntuk informasi lebih lanjut tentang pendaftaran, program ekstrakurikuler, atau fasilitas sekolah, silakan hubungi kami:\r\n📞 021-2273-6571\r\n📧 371smppgrii@gmail.com\r\n\r\n', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 'join', 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026 SMP PGRI 371 Pondok Aren\r\nBergabunglah bersama kami dan wujudkan masa depan cerah!\r\nTersedia program pendidikan berkualitas dengan fokus pada pembentukan karakter, ilmu pengetahuan, dan keterampilan.\r\nDaftar sekarang dan raih peluang terbaik untuk masa depan!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'extras', 'SMP PGRI 371 Pondok Aren menangkap momen-momen berkesan seperti kegiatan, piknik, dan kenangan tak terlupakan. Selaras dengan Kebijakan Pendidikan Nasional, rutinitas harian, hari libur, dan beragam mata pelajaran memperkaya perjalanan akademik kami. Repositori digital memberikan akses ke berbagai buku pelajaran, dan staf, komite, serta Komite Orang Tua (PTA) memastikan lingkungan belajar yang mendukung. Yang membanggakan, website ini dikembangkan langsung oleh siswa kami sebagai gerbang menuju komunitas pendidikan yang aktif dan dinamis.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `contactfeedback`
--
ALTER TABLE `contactfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `flash_notice`
--
ALTER TABLE `flash_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konten_kurikulum`
--
ALTER TABLE `konten_kurikulum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `manipulators`
--
ALTER TABLE `manipulators`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pimpinan_sekolah`
--
ALTER TABLE `pimpinan_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `schoolroutine`
--
ALTER TABLE `schoolroutine`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `school_notice`
--
ALTER TABLE `school_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `spmb`
--
ALTER TABLE `spmb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `web_content`
--
ALTER TABLE `web_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `contactfeedback`
--
ALTER TABLE `contactfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `flash_notice`
--
ALTER TABLE `flash_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `konten_kurikulum`
--
ALTER TABLE `konten_kurikulum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `manipulators`
--
ALTER TABLE `manipulators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pimpinan_sekolah`
--
ALTER TABLE `pimpinan_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `schoolroutine`
--
ALTER TABLE `schoolroutine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `school_notice`
--
ALTER TABLE `school_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `spmb`
--
ALTER TABLE `spmb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `web_content`
--
ALTER TABLE `web_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
