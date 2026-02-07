<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
$data  = mysqli_fetch_assoc($query);

if ($data && password_verify($password, $data['password'])) {
    $_SESSION['username'] = $username;
    $_SESSION['role']     = $data['role'];
    $_SESSION['id_user']  = $data['id_user'];

    if ($data['role'] == "admin") {
        header("location:dashboard_admin.php");
    } else {
        header("location:dashboard_user.php");
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>