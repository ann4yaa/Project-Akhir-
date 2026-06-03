<?php
session_start();
include "koneksi.php";
$error = "";

//proses simpan
if (isset($_POST['simpan'])){
    $kd_prodi = $_POST['kd_prodi'];
    $np = $_POST['nama_prodi'];
    if(empty($kd_prodi) || empty($np)){
        $error = "Data wajib diisi";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM prodi WHERE kd_prodi='$kd_prodi'");
        if(mysqli_num_rows($cek) > 0){
            $error = "Kode Prodi sudah ada";
        } else {
            mysqli_query($conn, "INSERT INTO prodi VALUES (NULL, '$kd_prodi', '$np')");
            echo "<script> alert('Data prodi berhasil ditambahkan!');
                window.location.href = 'prodi.php';
            </script>";
            exit();
        }
    }
}
?>
<?php if($error != ""){ ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<link rel=stylesheet href=style.css>
<script src="script.js"></script>
<div id="main">
    <div class="container">
<form method="POST">
    <label>Kode Prodi</label><br>
    <input type="text" name="kd_prodi" required><br><br>
    <label>Nama Prodi</label><br>
    <input type="text" name="nama_prodi" required><br><br>
    <button type="submit" name="simpan" class="submit">SIMPAN</button>
    <a href="prodi.php" class="batal">BATAL</a>
</form>
</div>
</div>