<?php
include 'koneksi.php';

$aksi = $_GET['aksi'];

if ($aksi == 'tambah') {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // Hash password sebelum simpan
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location='admin_users.php';</script>";
    } else {
        $query = "INSERT INTO users (username, password, nama_lengkap, role) 
                  VALUES ('$username', '$password_hash', '$nama', '$role')";
        
        if(mysqli_query($koneksi, $query)) {
            header("location:admin_users.php?pesan=tambah_berhasil");
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>