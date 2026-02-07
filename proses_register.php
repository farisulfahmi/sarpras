<?php
include 'koneksi.php';

$nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
$username     = mysqli_real_escape_string($koneksi, $_POST['username']);
$password     = $_POST['password'];
$role         = $_POST['role'];

$password_terenkripsi = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO users (username, password, nama_lengkap, role) 
          VALUES ('$username', '$password_terenkripsi', '$nama_lengkap', '$role')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Registrasi Berhasil! Silakan Login.');
            window.location='login.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>