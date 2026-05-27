<?php

session_start();

$_SESSION['login'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Manajemen Data Siswa</title>
    <link rel="stylesheet" href=style.css>
</head>
<body>
    <div class="container">
        <h1>PANEL LOGIN</h1>
        <hr>
        <form action="cek_login.php" method="POST">
            <div class="form-control">
                <input type="text" name="user" placeholder="Masukan username">
</div> 
<div class="form-control">
    <input type="password" name="pass" placeholder="Masukan password">
</div>
<dic class="form-control">
    <button type="submit">LOGIN</button>
</div>
</form>
</div>
</body>
</html>