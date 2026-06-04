<?php
session_start();
include "koneksi.php";
$id = $_GET['id'];

//cek apakah data ada 
$cek = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if(!$data){
    header("location: siswa.php?p=Data tidak ditemukan!");
    exit();
}

//proses hapus data
$hapus = mysqli_query($conn, "DELETE FROM siswa WHERE id = '$id'");

if ($hapus) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href='siswa.php';</script>";
    exit();
} else {
    echo "<script>alert('Data gagal dihapus'); window.location.href='siswa.php';</script>";
    exit();
}
?>