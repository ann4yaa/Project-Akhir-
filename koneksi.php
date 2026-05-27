<?php

$hostname = "Localhost";
$username = "root";
$password = "";
$database = "hagiaRajendra_penilaian";

$conn = mysqli_connect($hostname, $username, $password);

if (!$conn) {
    $pilih_db = mysqli_select_db($conn, $database);
    if($pilih_db){
        //
    } else {
        echo "Koneksi Gagal, di periksa lagi.";
    }
}
?>