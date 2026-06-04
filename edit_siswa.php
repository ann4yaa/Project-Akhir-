<?php
session_start();
include "koneksi.php";

//cek login
if (!isset($_SESSION['login'])) {
    header("location:index.php");
    exit();
}

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:siswa.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("location:siswa.php");
    exit();
}

$prodi = mysqli_query($conn, "SELECT * FROM prodi");
$error = "";

if (isset($_POST['update'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tajaran = $_POST['tahun_ajaran'];
    $kd_prodi = $_POST['kd_prodi'];
    $jk = $_POST['jenis_kelamin'];
    
    // Proses upload foto baru jika ada
    $foto_profil = $data['foto_profil']; // Gunakan foto lama sebagai default
    
    if ($_FILES['foto_profil']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Ada file yang diupload
        $file_name = $_FILES['foto_profil']['name'];
        $tmp_name = $_FILES['foto_profil']['tmp_name'];
        $error_upload = $_FILES['foto_profil']['error'];
        
        if ($error_upload === UPLOAD_ERR_OK) {
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $foto_profil_baru = time() . "_" . uniqid() . "." . $ext;
            $target_dir = "foto_profil/";
            
            // Buat folder jika belum ada
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            // Hapus foto lama jika bukan default.png
            if ($data['foto_profil'] != "default.png" && file_exists($target_dir . $data['foto_profil'])) {
                unlink($target_dir . $data['foto_profil']);
            }
            
            // Upload foto baru
            if (move_uploaded_file($tmp_name, $target_dir . $foto_profil_baru)) {
                $foto_profil = $foto_profil_baru;
            } else {
                $error = "Gagal mengupload foto!";
            }
        } else {
            $error = "Error upload file!";
        }
    }
    
    if (empty($nis) || empty($nama) || empty($kelas) || empty($tajaran) || empty($kd_prodi) || empty($jk)) {
        $error = "Data wajib diisi";
    }
    
    if (empty($error)) {
        // Gunakan prepared statement untuk keamanan
        $stmt = mysqli_prepare($conn, "UPDATE siswa SET nis=?, nama=?, kelas=?, tahun_ajaran=?, kd_prodi=?, jenis_kelamin=?, foto_profil=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssssssi", $nis, $nama, $kelas, $tajaran, $kd_prodi, $jk, $foto_profil, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data berhasil diupdate'); window.location.href='siswa.php';</script>";
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
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <h2>EDIT DATA SISWA</h2>
            <hr>
            
            <?php if ($error != "") { ?>
                <p style="color:red; text-align:center;"><?php echo $error; ?></p>
            <?php } ?>
            
            <form method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><strong>Foto Profil</strong></td>
                        <td>
                            <?php 
                            $foto_path = "foto_profil/" . $data['foto_profil'];
                            if (!empty($data['foto_profil']) && file_exists($foto_path)) {
                                echo '<img src="' . $foto_path . '" width="80" height="80" style="object-fit: cover; border-radius: 50%; margin-bottom: 10px;"><br>';
                            } else {
                                echo '<img src="foto_profil/default.png" width="80" height="80" style="object-fit: cover; border-radius: 50%; margin-bottom: 10px;"><br>';
                            }
                            ?>
                            <input type="file" name="foto_profil" accept="image/*">
                            <small style="color:gray;">Kosongkan jika tidak ingin mengubah foto</small>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>NIS</strong></td>
                        <td><input type="text" name="nis" class="form-input" value="<?php echo htmlspecialchars($data['nis']); ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><input type="text" name="nama" class="form-input" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Kelas</strong></td>
                        <td><input type="text" name="kelas" class="form-input" value="<?php echo htmlspecialchars($data['kelas']); ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Ajaran</strong></td>
                        <td><input type="text" name="tahun_ajaran" class="form-input" value="<?php echo htmlspecialchars($data['tahun_ajaran']); ?>" required></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>
                            <label style="margin-right:15px;">
                                <input type="radio" name="jenis_kelamin" value="L" <?php if($data['jenis_kelamin'] == "L") echo "checked"; ?> required> 
                                Laki-laki
                            </label>
                            <label>
                                <input type="radio" name="jenis_kelamin" value="P" <?php if($data['jenis_kelamin'] == "P") echo "checked"; ?> required> 
                                Perempuan
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Program Studi</strong></td>
                        <td>
                            <select name="kd_prodi" class="form-input" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php while($p = mysqli_fetch_assoc($prodi)) { ?>
                                    <option value="<?php echo $p['kd_prodi']; ?>" 
                                        <?php if($p['kd_prodi'] == $data['kd_prodi']) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($p['nama_prodi']); ?>
                                    </option> 
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="update" class="submit" style="width:100%;">UPDATE</button>
                            <a href="siswa.php" class="batal" style="display:block; text-align:center; margin-top:10px;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>