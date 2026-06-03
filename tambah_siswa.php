<?php
session_start();
include "koneksi.php";
$prodi = mysqli_query($conn, "SELECT * FROM prodi");
$error ="";

if (isset($_POST['simpan'])){
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tajaran = $_POST['tahun_ajaran'];
    $kd_prodi = $_POST['kd_prodi'];
    $jk = $_POST['jenis_kelamin'];
    //upload foto profil
    $foto_profil = $_FILES['foto_profil']['name'];
    $tmp = $_FILES['foto_profil']['tmp_name'];

    move_uploaded_file($tmp, "foto_profil/" .$foto_profil);

    if(empty($nis) || empty($nama) || empty($kelas)
        || empty($tajaran) || empty($kd_prodi)
    ||empty($jk)){
        $error = "Data wajib diisi";
    } else {
        mysqli_query($conn, "INSERT INTO siswa (nis, nama, kelas, tahun_ajaran, kd_prodi, jenis_kelamin, foto_profil) 
        VALUES ('$nis', '$nama', '$kelas', '$tajaran', '$kd_prodi', '$jk', '$foto_profil')");
        header('location: siswa.php');
        exit();
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
<form method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Foto Profil</td>
            <td><input type="file" name="foto_profil" accept="image/*"></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td><input type="text" name="nis" required></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" required></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td><input type="text" name="kelas" required></td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td><input type="text" name="tahun_ajaran" required></td>
        </tr>
        <tr>
            <td>Program</td>
            <td>
                <select name="kd_prodi" required>
                    <?php while($p = mysqli_fetch_assoc($prodi)) { ?>
                        <option value="<?php echo $p['kd_prodi']; ?>">
                            <?php echo $p['nama_prodi']; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <input type="radio" name="jenis_kelamin" value="L" required> Laki-laki
                <input type="radio" name="jenis_kelamin" value="P" required> Perempuan
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" name="simpan" class="submit">Submit</button>
                <a href="siswa.php" class="batal">Batal</a>
            </td>
        </tr>
</table>
</form>
</div>
</div>