<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Menyambung langsung ke database InfinityFree kelompok kalian
$host = "sql105.byetcluster.com"; 
$user = "if0_41601315"; 
$pass = "lightSPace"; // <-- Isi pakai password InfinityFree-mu ya
$db   = "if0_41601315_db_inventaris_lab"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);
?>