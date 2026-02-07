<?php
session_start();
include 'koneksi.php';

// Pastikan hanya user yang login yang bisa kirim data
if (!isset($_SESSION['id_user'])) {
    header("location:login.php");
    exit();
}

// Menangkap data dari form
$id_user         = $_SESSION['id_user'];
$id_barang       = $_POST['id_barang'] ?: 'NULL'; // Jika kosong, set NULL (untuk pengadaan)
$jenis_pengajuan = $_POST['jenis_pengajuan'];
$deskripsi       = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

// Query simpan ke tabel pengajuan
// Perhatikan: Karena id_barang bisa NULL, kita tidak menggunakan kutip jika nilainya NULL
if ($id_barang == 'NULL') {
    $query = "INSERT INTO pengajuan (id_user, id_barang, jenis_pengajuan, deskripsi, status) 
              VALUES ('$id_user', NULL, '$jenis_pengajuan', '$deskripsi', 'pending')";
} else {
    $query = "INSERT INTO pengajuan (id_user, id_barang, jenis_pengajuan, deskripsi, status) 
              VALUES ('$id_user', '$id_barang', '$jenis_pengajuan', '$deskripsi', 'pending')";
}

if (mysqli_query($koneksi, $query)) {
    // Sesuai flowchart: Setelah kirim -> kembali ke Dashboard User untuk cek status
    header("location:dashboard_user.php?pesan=berhasil_kirim");
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>