<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: index.php?p=Silakan login terlebih dahulu!");
    exit();
}

date_default_timezone_set('Asia/Jakarta');
$hour = (int) date('G');
if ($hour < 12) {
    $greeting = 'Selamat pagi';
} elseif ($hour < 15) {
    $greeting = 'Selamat siang';
} elseif ($hour < 18) {
    $greeting = 'Selamat sore';
} else {
    $greeting = 'Selamat malam';
}

$days = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
];
$months = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];
$today = sprintf(
    '%s, %02d %s %s',
    $days[date('l')],
    date('j'),
    $months[(int) date('n')],
    date('Y')
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Home</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <h2>APLIKASI MANAJEMEN DATA SISWA</h2>
            <hr>
            <p><strong><?= $greeting ?>!</strong></p>
            <p>Tanggal hari ini: <?= $today ?></p>
            <p>Selamat datang di aplikasi Data Siswa SMKS PGRI 3 Malang</p>
        </div>
    </div>
</body>
</html>