<?php
session_start();
session_destroy();
header("Location: login.php"); // sesuaikan jika login ada di luar folder siswa
exit;
