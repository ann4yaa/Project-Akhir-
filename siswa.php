<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silakan login terlebih dahulu!");
    exit();
}

include "koneksi.php";
//cari data siswa
$cari = isset($_GET['cari']) ? $_GET['cari']: '';

//ambil data siswa + prodi (JOIN)
$data = mysqli_query($conn, "SELECT s.*, p.nama_prodi FROM siswa s
 JOIN prodi p ON s.kd_prodi = p.kd_prodi WHERE
 nama LIKE '%$cari%'
 OR nis LIKE '%$cari%'
 ");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel=stylesheet href=style.css>
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <h2>Data Siswa</h2>
            <hr>
            <a href="tambah_siswa.php" class="tambah">Tambah Data Siswa</a>
            <form method="GET">
                <input type="text" name="cari" placeholder="Cari nama siswa...">
                <button type="submit">Cari</button>
</form>
            <table>
                <tr>
                    <th>IMG</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Prodi</th>
                    <th>ACTION</th>
</tr>
<?php while($row = mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><img src="foto_profil/<?php echo $row['foto_profil']; ?>" width="50"></td>
    <td><?php echo $row['nis']; ?></td>
    <td><?php echo $row['nama']; ?></td>
    <td><?php echo $row['kelas']; ?></td>
    <td><?php echo $row['tahun_ajaran']; ?></td>
    <td><?php echo $row['nama_prodi']; ?></td>
    <td>
        <a href="edit_siswa.php?id=<?php echo $row['id'];?>">EDIT</a>
        <a href="hapus_siswa.php?id=<?php echo $row['id'];?>" onclick="return confirm('Yakin ingin hapus?')">DELETE</a>
    </td>
</tr>
<?php } ?>
</table>
</div>
</div>
</body>
</html>