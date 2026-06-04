<?php
session_start();
header("Cache-Control: no-cache, must-revalidate, max-age=0");
if(!isset($_SESSION['login'])||$_SESSION['login']!= true){
    exit();
}
include "koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM prodi");

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$data = mysqli_query($conn, "SELECT * FROM prodi WHERE
 kd_prodi LIKE '%$cari%'
 OR nama_prodi LIKE '%$cari%'
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Prodi</title>
    <link rel=stylesheet href=style.css>
    <script src=script.js></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <h2>DATA PRODI</h2>
            <hr>
            <a href="tambah_prodi.php" class="tambah">TAMBAH DATA PRODI</a>
            <br>
            <form method="GET">
                <input type="text" name="cari" placeholder="Cari nama prodi...">
                <button type="submit">Cari</button>
</form>
            <table>
                <tr>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>ACTION</th>
                </tr>
                <?php while($row = mysqli_fetch_assoc($data)){ ?>
            <tr>
                <td><?php echo $row['kd_prodi']; ?></td>
                <td><?php echo $row['nama_prodi']; ?></td>
                <td>
                    <a class="btn-edit" href="edit_prodi.php?id_prodi=<?php
                    echo $row['id_prodi']; ?>">EDIT</a>
                    <a class="btn-delete" href="hapus_prodi.php?id_prodi=<?php
                    echo $row['id_prodi']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    DELETE</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>