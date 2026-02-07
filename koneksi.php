<?php
$host = "localhost";
$user = "sarpras";
$pass = "sarpras123"; 
$db   = "sarpras"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>