<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "hagiaRajendra_penilaian"; 

$conn = mysqli_connect($hostname, $username, $password);

if ($conn) {

    $pilih_db = mysqli_select_db($conn, $database);
    
    if (!$pilih_db) {
        echo "Database tidak ditemukan!";
    }
} else {
    echo "Koneksi ke server MySQL Gagal.";
}
?>