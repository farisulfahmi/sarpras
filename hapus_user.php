<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin yang bisa menghapus
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("location:login.php?pesan=belum_login");
    exit();
}

// Menangkap ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $current_user_id = $_SESSION['id_user'];

    // MENCEGAH ADMIN MENGHAPUS DIRINYA SENDIRI
    if ($id == $current_user_id) {
        echo "<script>
                alert('Anda tidak bisa menghapus akun Anda sendiri saat sedang login!');
                window.location='admin_users.php';
              </script>";
        exit();
    }

    // Proses Hapus Data
    $query = "DELETE FROM users WHERE id_user = '$id'";
    $hapus = mysqli_query($koneksi, $query);

    if ($hapus) {
        // Berhasil, kembali ke halaman users dengan notifikasi
        header("location:admin_users.php?pesan=hapus_berhasil");
    } else {
        // Gagal karena kendala database (misal: ID sedang digunakan di tabel pengajuan)
        echo "<script>
                alert('Gagal menghapus! User mungkin memiliki keterkaitan data dengan pengajuan barang.');
                window.location='admin_users.php';
              </script>";
    }
} else {
    header("location:admin_users.php");
}
?>