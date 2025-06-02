-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 04:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `admission_form`
--

CREATE TABLE `admission_form` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `address` varchar(80) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birth_place` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `religion` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu') NOT NULL,
  `father_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) NOT NULL,
  `admit_to` varchar(100) NOT NULL,
  `previous_school` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `intro` varchar(500) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `registered_on` varchar(30) NOT NULL,
  `image_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admission_form`
--

INSERT INTO `admission_form` (`id`, `full_name`, `nisn`, `nik`, `address`, `gender`, `birth_place`, `dob`, `religion`, `father_name`, `mother_name`, `admit_to`, `previous_school`, `email`, `phone`, `intro`, `image`, `registered_on`, `image_url`) VALUES
(14, 'Nishchal Acharya', NULL, NULL, 'sdf', 'Male', '', '2024-01-06', 'Islam', 'sdaf ', 'safsf', '10 ( Nepali Medium )', 'Sundarpur', 'ujwal@gmail.com', '98170099789', 'saf sfaf sadf', NULL, '21/01/2024 05:24 PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contactfeedback`
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
-- Dumping data for table `contactfeedback`
--

INSERT INTO `contactfeedback` (`id`, `date`, `time`, `name`, `email`, `message`) VALUES
(52, '05/05/2025', '03:26 PM', 'Gracia', 'nlala8868@gmail.com', 'Sekolah yang bagus');

-- --------------------------------------------------------

--
-- Table structure for table `flash_notice`
--

CREATE TABLE `flash_notice` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `trun_flash` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `flash_notice`
--

INSERT INTO `flash_notice` (`id`, `title`, `image_url`, `message`, `trun_flash`) VALUES
(1, 'Pendaftaran dibuka!!!', 'assects/images/flashNotice/6095973527506241505.jpg', 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026 SMP PGRI 371 Pondok Aren\r\nBergabunglah bersama kami dan wujudkan masa depan cerah!\r\nTersedia program pendidikan berkualitas dengan fokus pada pembentukan karakter, ilmu pengetahuan, dan keterampilan.\r\nDaftar sekarang dan raih peluang terbaik untuk masa depan!', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album`
--

CREATE TABLE `gallery_album` (
  `id` int(11) NOT NULL,
  `album_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gallery_album`
--

INSERT INTO `gallery_album` (`id`, `album_name`) VALUES
(16, 'Pekemahan Jumat Sabtu'),
(17, 'Memperingati Hari Guru'),
(18, 'Perkemahan Jumat Sabtu 1');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `album` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gallery_images`
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
-- Table structure for table `management_committee`
--

CREATE TABLE `management_committee` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `position` varchar(50) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `image_src` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `management_committee`
--

INSERT INTO `management_committee` (`id`, `name`, `position`, `contact_no`, `image_src`) VALUES
(2, 'Sukardi, S.Pd.I., M.M', 'Kepala Sekolah', '9844640316', 'assects/images/pta/6091613530110412616.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `manipulators`
--

CREATE TABLE `manipulators` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `identity_code` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `image` varchar(500) NOT NULL,
  `last_update` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manipulators`
--

INSERT INTO `manipulators` (`id`, `name`, `identity_code`, `password`, `image`, `last_update`) VALUES
(1, ' Administrator', '2120021', '12345678', 'assects/images/admin_and_scribe/pgri-hitam.png', NULL),
(2, 'Admin_1', '2120021', '12345678', 'assects/images/admin_and_scribe/avatar.png', '05/05/2025 06:11 PM');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `page` varchar(30) NOT NULL,
  `site` varchar(20) NOT NULL,
  `total_notification` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `page`, `site`, `total_notification`) VALUES
(1, 'join_us', 'new_students', 0),
(2, 'contact_us', 'new_feedback', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','guru','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `password`, `level`) VALUES
(1, 'Admin Utama', 'admin', 'admin123', 'admin'),
(2, 'Budi Guru', 'guru1', '9310f83135f238b04af729fec041cca8', 'guru'),
(3, 'Siti Siswa', 'siswa1', '3afa0d81296a4f17d477ec823261b1ec', 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `schoolroutine`
--

CREATE TABLE `schoolroutine` (
  `id` int(11) NOT NULL,
  `class` varchar(1000) DEFAULT NULL,
  `routine_url` varchar(1000) DEFAULT NULL,
  `last_modified` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schoolroutine`
--

INSERT INTO `schoolroutine` (`id`, `class`, `routine_url`, `last_modified`) VALUES
(1, 'Kelas IX', 'assects/images/Routines/kelas 9.png', '02:44 PM 19/05/2025'),
(5, 'Kelas VIII', 'assects/images/Routines/kelas 8.png', '02:43 PM 19/05/2025'),
(19, 'Kelas VII', 'assects/images/Routines/kelas 7.png', '02:51 PM 19/05/2025');

-- --------------------------------------------------------

--
-- Table structure for table `school_notice`
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
-- Dumping data for table `school_notice`
--

INSERT INTO `school_notice` (`id`, `logo`, `posted_by`, `image_url`, `about`, `notice_description`, `date`, `time`, `total_views`, `total_downloads`, `last_modified`) VALUES
(116, 'assects/images/defaults/pgri-putih.png', ' Administrator', 'assects/images/notices_files/6158986921146172281.jpg', 'Kegiatan Perkemahan Jumat Sabtu', 'SMP PGRI 371 Pondok Aren melaksanakan kegiatan pramuka yaitu perkemahan jumat sabtu (PERJUSA) yang dilaksanakan di daerah ciputat, Tangerang Selatan. Manfaat dari kegiatan ini adalah untuk melatih skill leadership dan kebersamaan', '05/05/2025', '06:26 PM', 0, 1, '05:42 PM 07/05/2025');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
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
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `post`, `qualification`, `contact`, `image_src`) VALUES
(1, 'Sumiati', 'Bendahara & PKS Bidang Kesiswaan', 'S.Pd', '9844640316', 'assects/images/staff/6122720573781034406.jpg'),
(2, 'M. Aden Muchtar', 'PKS Bidang Kurikulum & Wali Kelas IX', 'S.Pd', '9804903845', 'assects/images/staff/6122720573781034405.jpg'),
(3, 'Adi Ersa', 'Kepala Tata Usaha', '', '9842438801', 'assects/images/staff/avatar.png'),
(4, 'Rita Fahriani', 'Guru IPS', 'S.Pd', '9860155878', 'assects/images/staff/6122720573781034402.jpg'),
(5, 'Bayu Heru Nugroho', 'Pembina Osis dan Wali Kelas VIII', '', '9842751110', 'assects/images/staff/6122720573781034403.jpg'),
(6, 'Noor Shadad Afriansyah', 'Wali Kelas VIII & Guru Bahasa Inggris', 'S.Pd', '9815948821', 'assects/images/staff/avatar.png'),
(7, 'Dedy Adnan', 'Guru BTQ', 'S.Pd', '9814951994', 'assects/images/staff/6122720573781034404.jpg'),
(48, 'Suhemah', 'Guru ', 'S.Pd', '123456', 'assects/images/staff/6122720573781034407.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `web_content`
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
-- Dumping data for table `web_content`
--

INSERT INTO `web_content` (`id`, `content_about`, `one`, `two`, `three`, `four`, `five`, `six`, `seven`, `eight`, `nine`, `ten`, `eleven`, `twelve`, `thirteen`, `fourteen`, `fifteen`, `sixteen`, `seventeen`, `eighteen`, `ninteen`, `twenty`, `twentyone`) VALUES
(1, 'index', 'Kami berkomitmen untuk menciptakan generasi yang berakhlak mulia, berilmu, berpengetahuan, serta berwawasan lingkungan. SMP PGRI 371 Pondok Aren mendukung setiap peserta didik agar mampu melanjutkan ke jenjang pendidikan yang lebih tinggi, dengan fondasi moral dan akademik yang kuat. Sebagai lembaga pendidikan yang ramah lingkungan dan religius, kami menanamkan nilai-nilai luhur dan sikap disiplin kepada siswa sejak dini.', 'Banyak alasan mengapa SMP PGRI 371 menjadi pilihan tepat untuk masa depan anak Anda:\r\n✅ Guru Profesional & Berkualitas\r\nGuru-guru berdedikasi yang membimbing siswa tidak hanya dalam pelajaran akademik, tetapi juga dalam pembentukan karakter.\r\n✅ Lingkungan Belajar Nyaman & Religius\r\nSuasana sekolah yang kondusif, bersih, dan mendukung perkembangan spiritual serta kedisiplinan siswa.\r\n✅ Pembelajaran Berbasis Teknologi\r\nKami mengintegrasikan teknologi dalam proses pembelajaran agar siswa siap menghadapi tantangan zaman.\r\n✅ Pembentukan Karakter Jujur & Disiplin\r\nKami mendidik siswa agar menjadi pribadi yang jujur, bertanggung jawab, dan disiplin dalam kehidupan sehari-hari.', 'Guru-guru kami memiliki kualifikasi tinggi dan berdedikasi untuk memberikan pembelajaran terbaik bagi siswa.', 'Lingkungan belajar kami mendukung kenyamanan dan ketenangan dalam kegiatan belajar mengajar.', 'Kami memanfaatkan teknologi digital untuk memperluas akses siswa terhadap pembelajaran yang modern dan efektif.\r\n\r\n', 'SMP PGRI 371 dilengkapi dengan fasilitas pendidikan yang mendukung berbagai kegiatan akademik dan non-akademik siswa.', 'Lingkungan belajar di SMP PGRI 371 Pondok Aren sangat menyenangkan, terbuka, dan penuh semangat. Para guru dan staf di sekolah ini luar biasa — mereka ramah, sabar, dan selalu siap membantu. Kami merasa senang belajar di sekolah ini karena para guru membuat suasana kelas menjadi nyaman dan mudah untuk berinteraksi.\r\n\r\nDi sekolah, kami mempelajari berbagai materi yang menarik dan relevan dengan masa depan kami. Dukungan dari para guru sangat membantu kami dalam memahami pelajaran dan menghadapi tantangan dengan percaya diri. Selain itu, sekolah juga rutin mengadakan kegiatan ekstrakurikuler yang sangat bermanfaat untuk mengembangkan keterampilan sosial, kerja sama, dan kepercayaan diri kami.', 'SMP PGRI 371 Pondok Aren mulai menerapkan sistem Ujian Berbasis Online sejak tahun 2024 untuk siswa kelas 7 sebagai tahap awal. Saat ini, pelaksanaan ujian online telah mencakup siswa dari kelas 7 hingga kelas 9 secara rutin.\r\n\r\nUjian berbasis online merupakan salah satu bentuk pemanfaatan teknologi dalam dunia pendidikan yang bertujuan untuk meningkatkan efisiensi, kecepatan, dan akurasi dalam proses evaluasi belajar siswa. Melalui sistem ini, siswa dapat mengerjakan soal-soal ujian menggunakan perangkat seperti komputer atau tablet, baik di laboratorium sekolah maupun di ruang kelas yang telah disiapkan.\r\n\r\nSelain mendukung program digitalisasi sekolah, ujian online juga membantu siswa lebih terbiasa dengan penggunaan teknologi dalam proses belajar, serta mempersiapkan mereka menghadapi tantangan pendidikan di masa depan.', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 'about', 'SMP PGRI 371 Pondok Aren terletak di kawasan Pondok Aren, Tangerang Selatan. Sekolah ini melayani jenjang pendidikan dari kelas 7 hingga kelas 9 dengan pendekatan pembelajaran yang aktif, menyenangkan, dan membentuk karakter positif pada siswa.\r\n\r\nDipimpin oleh Kepala Sekolah Bapak Sukardi, S.Pd.I., M.M, kegiatan belajar mengajar dilaksanakan setiap hari dari pukul 13.00 hingga 17.00 WIB.\r\nSekolah menyediakan lingkungan belajar yang aman dan nyaman, dengan fasilitas pendukung seperti ruang kelas yang tertata rapi, lapangan olahraga, air bersih, toilet terpisah untuk putra dan putri.\r\nSelain kegiatan akademik, SMP PGRI 371 Pondok Aren juga rutin mengadakan berbagai kegiatan ekstrakurikuler seperti pramuka. Kegiatan ini membantu siswa mengembangkan bakat, meningkatkan percaya diri, dan memperkuat kemampuan sosial mereka.\r\nMelalui suasana belajar yang kondusif dan dukungan dari seluruh warga sekolah, kami berkomitmen untuk mencetak siswa yang berprestasi, sopan, dan siap menghadapi masa d', 'Saya sangat senang dan bersyukur mendapat kepercayaan untuk menjabat sebagai Kepala Sekolah di SMP PGRI 371 Pondok Aren. Terima kasih kepada seluruh tim manajemen dan yayasan atas kepercayaan yang diberikan kepada saya untuk memimpin sekolah ini.\r\n\r\nKami berkomitmen untuk memberikan pendidikan berkualitas yang tidak hanya mendorong siswa untuk mencintai proses belajar, tetapi juga membentuk mereka menjadi pribadi yang bermanfaat bagi masyarakat. Tujuan kami adalah membantu setiap siswa mencapai potensi terbaiknya, baik dalam bidang akademik maupun karakter.\r\n\r\nKami juga sangat terbuka kepada orang tua. Silakan datang kapan saja untuk berdiskusi mengenai perkembangan dan pendidikan putra-putri Anda. Kami sedang membangun komunitas belajar yang positif, aktif, dan berorientasi pada keunggulan, dengan semangat kebersamaan antara guru, siswa, dan orang tua.\r\n\r\nSaya siap memimpin dengan semangat dan dedikasi tinggi agar kita semua dapat mencapai visi dan misi sekolah ini bersama-sama. Mari ', 'Untuk menciptakan lingkungan belajar yang tertib, aman, dan nyaman, seluruh warga sekolah wajib mematuhi tata tertib berikut:', 'Siswa wajib hadir tepat waktu', 'Siswa wajib menggunakan seragam lengkap sesuai jadwal', 'Siswa wajib bersikap sopan dan hormat kepada guru, staf, dan sesama siswa.', 'Menjaga nama baik sekolah di dalam dan luar lingkungan sekolah', 'Dilarang membawa dan menggunakan ponsel saat jam pelajaran, kecuali atas izin guru.', 'Bersikap baik', 'Mengerjakan tugas tepat waktu', 'Dilarang meninggalkan kelas tanpa izin guru', 'Dilarang membawa senjata tajam, rokok, minuman keras, narkoba, atau barang berbahaya lainnya.', 'Dilarang berisik saat jam pelajaran dimulai', 'SMP PGRI 371 Pondok Aren secara rutin mengadakan berbagai kegiatan menarik seperti perkemahan Pramuka, peringatan hari besar nasional, hingga acara kebersamaan dan kreativitas siswa.\r\nMelalui kegiatan ini, diharapkan siswa dapat memperkuat rasa kebersamaan, disiplin, serta semangat menghargai nilai-nilai kebangsaan dan karakter positif.', 'Kegiatan Perkemahan Pramuka SMP PGRI 371 Pondok Aren\r\nSebagai bagian dari pendidikan karakter dan kemandirian siswa, SMP PGRI 371 Pondok Aren melaksanakan kegiatan Perkemahan Pramuka yang diikuti oleh peserta didik dari berbagai tingkatan kelas.\r\nKegiatan ini bertujuan untuk menumbuhkan semangat gotong royong, kepemimpinan, disiplin, dan cinta alam dalam suasana penuh kebersamaan.\r\nTerima kasih kepada seluruh pembina, guru, dan siswa yang telah berpartisipasi aktif.\r\nPramuka Hebat, Siswa Bermartabat!', 'Peringatan Hari Guru Nasional di SMP PGRI 371 Pondok Aren\r\nDalam rangka memperingati Hari Guru Nasional, SMP PGRI 371 Pondok Aren menggelar serangkaian kegiatan yang penuh makna sebagai bentuk penghargaan terhadap dedikasi dan perjuangan para pendidik.\r\nSuasana haru dan hangat menyelimuti peringatan ini, dengan penampilan dari siswa, pemberian penghargaan simbolis, serta momen kebersamaan yang mempererat hubungan antara guru dan murid.\r\nTerima kasih, Guru! Atas ilmu, kesabaran, dan kasih sayang yang tak pernah lelah diberikan.\r\n\"Engkaulah pelita dalam gulita, pahlawan tanpa tanda jasa.\"', 'SMP PGRI 371 Pondok Aren menyediakan berbagai fasilitas untuk mendukung kenyamanan dan kualitas pembelajaran, seperti ruang kelas ber-AC, perpustakaan, lapangan olahraga, UKS, dan MCK.\r\nKami juga aktif mengembangkan minat dan bakat siswa melalui kegiatan ekstrakurikuler seperti Pramuka, Futsal, Marawis, Tari, Badminton, dan Vokal.\r\nBersama kami, mari tumbuh menjadi generasi yang berprestasi dan berkarakter! ', 'Ruang kelas yang nyaman dengan AC membantu menciptakan suasana belajar yang lebih fokus dan menyenangkan. Dengan lingkungan yang bersih dan rapi, siswa dapat belajar dengan lebih maksimal tanpa terganggu oleh suhu panas.', 'Lapangan olahraga adalah tempat ideal bagi siswa untuk berolahraga dan menyalurkan energi secara positif. Kegiatan fisik yang menyenangkan ini juga mengajarkan pentingnya kerjasama tim dan menjaga kesehatan tubuh.', 'Fasilitas MCK yang bersih dan terawat memastikan kenyamanan serta kebersihan di sekolah. Siswa dapat merawat kebersihan diri dengan mudah, yang mendukung gaya hidup sehat dan kebersihan lingkungan sekolah.', 'UKS menyediakan fasilitas kesehatan bagi siswa yang membutuhkan pertolongan pertama. Dengan tenaga medis yang siap sedia, siswa dapat merasa lebih aman saat mengalami masalah kesehatan ringan di sekolah.'),
(3, 'notice', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'contactus', 'Selamat Datang di SMP PGRI 371 Pondok Aren, Sekolah yang menghadirkan lingkungan belajar yang inspiratif dan beragam, dengan komitmen membentuk generasi berkarakter, berilmu, dan berprestasi.\r\nUntuk informasi lebih lanjut tentang pendaftaran, program ekstrakurikuler, atau fasilitas sekolah, silakan hubungi kami:\r\n📞 021-2273-6571\r\n📧 371smppgri@gmail.com\r\n\r\n', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 'join', 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026 SMP PGRI 371 Pondok Aren\r\nBergabunglah bersama kami dan wujudkan masa depan cerah!\r\nTersedia program pendidikan berkualitas dengan fokus pada pembentukan karakter, ilmu pengetahuan, dan keterampilan.\r\nDaftar sekarang dan raih peluang terbaik untuk masa depan!', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 'extras', 'Halaman ini di SMP PGRI 371 Pondok Aren menangkap momen-momen berkesan seperti kegiatan, piknik, dan kenangan tak terlupakan. Selaras dengan Kebijakan Pendidikan Nasional, rutinitas harian, hari libur, dan beragam mata pelajaran memperkaya perjalanan akademik kami. Repositori digital memberikan akses ke berbagai buku pelajaran, dan staf, komite, serta Komite Orang Tua (PTA) memastikan lingkungan belajar yang mendukung. Yang membanggakan, website ini dikembangkan langsung oleh siswa kami sebagai gerbang menuju komunitas pendidikan yang aktif dan dinamis.', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission_form`
--
ALTER TABLE `admission_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `contactfeedback`
--
ALTER TABLE `contactfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_notice`
--
ALTER TABLE `flash_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `management_committee`
--
ALTER TABLE `management_committee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manipulators`
--
ALTER TABLE `manipulators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `schoolroutine`
--
ALTER TABLE `schoolroutine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_notice`
--
ALTER TABLE `school_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_content`
--
ALTER TABLE `web_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission_form`
--
ALTER TABLE `admission_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `contactfeedback`
--
ALTER TABLE `contactfeedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `flash_notice`
--
ALTER TABLE `flash_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `management_committee`
--
ALTER TABLE `management_committee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `manipulators`
--
ALTER TABLE `manipulators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schoolroutine`
--
ALTER TABLE `schoolroutine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `school_notice`
--
ALTER TABLE `school_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `web_content`
--
ALTER TABLE `web_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
