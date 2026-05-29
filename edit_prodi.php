<?php
session_start();
include "koneksi.php";
$idp = $_GET['id_prodi'];
$query = mysqli_query($conn, "SELECT * FROM prodi WHERE id_prodi='$idp'");
$data = mysqli_fetch_assoc($query);

$error = "";
if(isset($_POST['update'])){
    $kd_prodi = $_POST['kd_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    if(empty($kd_prodi) || empty($nama_prodi)){
        $error = "Data wajib diisi";
    } else {
    mysqli_query($conn, "UPDATE prodi
    SET kd_prodi='$kd_prodi', nama_prodi='$nama_prodi'
    WHERE id_prodi='$idp'");
    echo "<script>alert('Data berhasil diupdate');
    window.location.href='prodi.php';
    </script>";
    exit();
}
}
?>
<?php if($error != ""){
    <p style="color:red;"><?php echo $error; ?></p>
<?php }?>

<form method="POST">
    <label>Kode Prodi</label><br>
    <input type="text" name="kd_prodi" value="<?php
    echo $data['kd_prodi']; ?>" required>
    <label>Nama Prodi</label>
    <input type="text" name="nama_prodi" value="<?php
    echo $data['nama_prodi']; ?>" required>
    <button type="submit" name="update" class="submit">UPDATE</button>
    <a href="prodi.php" class="batal">BATAL</a>
</form>