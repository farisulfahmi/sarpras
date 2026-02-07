<?php
session_start();
include 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Akses ditolak");
}

// Menangkap data dari form Modal
$id_pengajuan = $_POST['id'];
$aksi         = $_POST['aksi'];
$catatan      = mysqli_real_escape_string($koneksi, $_POST['catatan']);

$status_baru = ($aksi == 'setuju') ? 'disetujui' : 'ditolak';

// Query Update
$sql = "UPDATE pengajuan SET 
        status = '$status_baru', 
        catatan_admin = '$catatan' 
        WHERE id_pengajuan = '$id_pengajuan'";

if (mysqli_query($koneksi, $sql)) {
    header("location:admin_pengajuan.php?pesan=berhasil_update");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>