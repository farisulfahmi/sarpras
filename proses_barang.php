<?php
include 'koneksi.php';

$aksi = $_GET['aksi'];

if ($aksi == 'tambah') {
    $kode    = $_POST['kode_barang'];
    $nama    = $_POST['nama_barang'];
    $kat     = $_POST['kategori'];
    $stok    = $_POST['stok'];
    $kondisi = $_POST['kondisi'];

    $query = "INSERT INTO barang (kode_barang, nama_barang, kategori, stok, kondisi) 
              VALUES ('$kode', '$nama', '$kat', '$stok', '$kondisi')";
    
    mysqli_query($koneksi, $query);
    header("location:admin_inventori.php?pesan=tambah_berhasil");

} elseif ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id'");
    header("location:admin_inventori.php?pesan=hapus_berhasil");
}
?>