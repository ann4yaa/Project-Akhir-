<?php
session_start();
include "koneksi.php";

if (!isset($_GET['id_prodi']) || empty($_GET['id_prodi'])) {
    echo "<script>alert('ID Prodi tidak ditemukan'); window.location.href='prodi.php';</script>";
    exit();
}

$idp = $_GET['id_prodi'];
$query = mysqli_query($conn, "SELECT * FROM prodi WHERE id_prodi='$idp'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data prodi tidak ditemukan'); window.location.href='prodi.php';</script>";
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $kd_prodi = $_POST['kd_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    
    if (empty($kd_prodi) || empty($nama_prodi)) {
        $error = "Data wajib diisi";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE prodi SET kd_prodi=?, nama_prodi=? WHERE id_prodi=?");
        mysqli_stmt_bind_param($stmt, "ssi", $kd_prodi, $nama_prodi, $idp);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data berhasil diupdate'); window.location.href='prodi.php';</script>";
            exit();
        } else {
            $error = "Gagal mengupdate data: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program Studi</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    
    <div id="main">
        <div class="container">
            <h2>Edit Program Studi</h2>
            <hr>
            
            <?php if ($error != "") { ?>
                <p style="color:red; text-align:center;"><?php echo $error; ?></p>
            <?php } ?>
            
            <form method="POST">
                <table style="width:100%; border:none;">
                    <tr>
                        <td style="width:30%; border:none;"><label>Kode Prodi</label></td>
                        <td style="border:none;">
                            <input type="text" name="kd_prodi" class="form-input" 
                                   value="<?php echo htmlspecialchars($data['kd_prodi']); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;"><label>Nama Prodi</label></td>
                        <td style="border:none;">
                            <input type="text" name="nama_prodi" class="form-input" 
                                   value="<?php echo htmlspecialchars($data['nama_prodi']); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none;">
                            <button type="submit" name="update" class="submit">UPDATE</button>
                            <a href="prodi.php" class="batal">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>