<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("location:login.php?pesan=belum_login");
    exit();
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Lab - Inventori Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; background-color: #f4f7f6; font-family: 'Inter', sans-serif; }
        .main-content { flex-grow: 1; padding: 25px; min-height: 100vh; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .step-number { width: 40px; height: 40px; background: #1e3c72; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px; }
        .rule-item { border-left: 4px solid #1e3c72; padding-left: 15px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <?php 
    // Memilih sidebar berdasarkan role agar fleksibel
    if($_SESSION['role'] == 'admin') {
        include 'layout/sidebar.php'; 
    } else {
        include 'layout/sidebar_user.php';
    }
    ?>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 card-custom p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-muted"><i class="bi bi-book me-2"></i>Panduan & Tata Tertib Lab</span>
            </div>
        </nav>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="card card-custom p-4 bg-white h-100">
                    <h5 class="fw-bold mb-4">Alur Peminjaman & Pelaporan</h5>
                    
                    <div class="d-flex mb-4">
                        <div class="step-number shadow-sm">1</div>
                        <div>
                            <h6 class="fw-bold">Pilih Barang</h6>
                            <p class="text-muted small">Cek ketersediaan barang pada dashboard utama. Pastikan barang dalam kondisi "Baik".</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="step-number shadow-sm">2</div>
                        <div>
                            <h6 class="fw-bold">Isi Form Pengajuan</h6>
                            <p class="text-muted small">Klik tombol "Buat Pengajuan", pilih jenis keperluan (Pinjam/Lapor/Pengadaan), dan jelaskan alasannya.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="step-number shadow-sm">3</div>
                        <div>
                            <h6 class="fw-bold">Tunggu Persetujuan Admin</h6>
                            <p class="text-muted small">Pantau status di tabel "Status Pengajuan". Admin akan menyetujui atau menolak permohonan Anda.</p>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="step-number shadow-sm">4</div>
                        <div>
                            <h6 class="fw-bold">Selesai / Pengambilan</h6>
                            <p class="text-muted small">Jika disetujui, silakan hubungi petugas lab untuk serah terima barang atau tindakan lebih lanjut.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card card-custom p-4 bg-white h-100">
                    <h5 class="fw-bold mb-4 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Tata Tertib Umum</h5>
                    
                    <div class="rule-item">
                        <h6 class="fw-bold mb-1">Dilarang Membawa Makanan/Minuman</h6>
                        <p class="text-muted small">Menghindari kerusakan komponen akibat tumpahan cairan.</p>
                    </div>

                    <div class="rule-item">
                        <h6 class="fw-bold mb-1">Cek Kondisi Sebelum Pakai</h6>
                        <p class="text-muted small">Wajib melapor jika menemukan barang rusak saat pertama kali digunakan.</p>
                    </div>

                    <div class="rule-item" style="border-color: #2ecc71;">
                        <h6 class="fw-bold mb-1">Matikan Perangkat</h6>
                        <p class="text-muted small">Pastikan komputer dalam keadaan 'Shut Down' setelah selesai digunakan.</p>
                    </div>

                    <div class="rule-item">
                        <h6 class="fw-bold mb-1">Jaga Kebersihan</h6>
                        <p class="text-muted small">Dilarang mencoret-coret meja atau meninggalkan sampah di area lab.</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            Copyright &copy; <?php echo date('Y'); ?> Farisul Fahmi
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>