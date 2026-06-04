<?php
session_start();
include "koneksi.php";
$idp = $_GET['id_prodi'];

//cel apakah prodi dipakai di tabel siswa
$q = mysqli_query($conn, "SELECT * FROM prodi
WHERE id_prodi='$idp'");
$dp = mysqli_fetch_assoc($q);
$kd_prodi = $dp['kd_prodi'];

$cek =mysqli_query($conn, "SELECT * FROM 
siswa WHERE kd_prodi='$kd_prodi'");
if(mysqli_num_rows($cek) > 0){
    header("location: prodi.php?p=Data tidak bisa dihapus karena masih digunakan");
} else {
    mysqli_query($conn, "DELETE FROM prodi WHERE id_prodi='$idp'");
    echo "<script>alert('Data prodi berhasil dihapus'); window.location.href='prodi.php';</script>";
}
exit();
?>