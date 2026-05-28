<?php

session_start();
session_unset();
session_destroy();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Program: no-cache");
header("location: indek.php");
exit();
?>