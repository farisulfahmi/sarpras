<?php
session_start();
include 'koneksi.php';

// 1. Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("location:login.php?pesan=belum_login");
    exit();
}

// 2. Ambil ID User dari Session
$id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sarpras Lab</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { display: flex; background-color: #f4f7f6; font-family: 'Inter', sans-serif; min-height: 100vh; }
        .main-content { flex-grow: 1; padding: 25px; overflow-y: auto; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .welcome-banner { 
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); 
            color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; 
        }
        .badge-status { padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; }
    </style>
</head>
<body>

    <?php include 'layout/sidebar_user.php'; ?>

    <div class="main-content">
        
        <div class="welcome-banner shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
                    <p class="mb-0 opacity-75">Sistem Inventori & Pelaporan Sarana Prasarana Lab Komputer.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="bi bi-display fs-1 opacity-25"></i>
                </div>
            </div>
        </div>

        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == "berhasil_kirim"): ?>
            <div class="alert alert-success alert-dismissible fade show card-custom mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Pengajuan Anda berhasil dikirim dan sedang menunggu review Admin.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card card-custom p-4 bg-white d-flex flex-row align-items-center">
                    <div class="bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-send-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small fw-bold text-uppercase">Total Pengajuan Saya</h6>
                        <?php 
                        $res = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengajuan WHERE id_user='$id_user'");
                        $count = mysqli_fetch_assoc($res);
                        echo "<h3 class='fw-bold mb-0'>".$count['total']."</h3>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <button class="btn btn-primary btn-lg shadow-sm w-100 p-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPinjam" style="border-radius: 12px;">
                    <i class="bi bi-plus-circle me-2"></i> Buat Pengajuan / Lapor Baru
                </button>
            </div>
        </div>

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat & Status Pengajuan</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Barang / Pengadaan</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Feedback Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Perbaikan Query: Menggunakan id_user yang dinamis dari session
                        $sql = "SELECT p.*, b.nama_barang 
                                FROM pengajuan p 
                                LEFT JOIN barang b ON p.id_barang = b.id_barang 
                                WHERE p.id_user = '$id_user' 
                                ORDER BY p.tanggal_pengajuan DESC";
                        
                        $query = mysqli_query($koneksi, $sql);

                        if(mysqli_num_rows($query) > 0) {
                            while($row = mysqli_fetch_assoc($query)) {
                                // Warna Badge Status
                                $bg = 'bg-warning text-dark';
                                if($row['status'] == 'disetujui') $bg = 'bg-success text-white';
                                if($row['status'] == 'ditolak') $bg = 'bg-danger text-white';
                        ?>
                        <tr>
                            <td>
                                <span class="fw-bold text-dark"><?= $row['nama_barang'] ?? 'Pengadaan Baru' ?></span>
                                <div class="text-muted small"><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></div>
                            </td>
                            <td><span class="badge border bg-light text-dark"><?= ucfirst($row['jenis_pengajuan']) ?></span></td>
                            <td style="max-width: 200px;"><small class="text-muted"><?= htmlspecialchars($row['deskripsi']) ?></small></td>
                            <td><span class="badge badge-status <?= $bg ?>"><?= ucfirst($row['status']) ?></span></td>
                            <td><em class="small text-muted"><?= $row['catatan_admin'] ?: '-' ?></em></td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada data pengajuan yang Anda kirimkan.</td></tr>";
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold">Form Pengajuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="proses_pengajuan_user.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Barang</label>
                            <select name="id_barang" class="form-select">
                                <option value="">-- Hanya untuk Pengadaan Baru --</option>
                                <?php 
                                $brg_query = mysqli_query($koneksi, "SELECT * FROM barang WHERE stok > 0");
                                while($b = mysqli_fetch_assoc($brg_query)) {
                                    echo "<option value='".$b['id_barang']."'>".$b['nama_barang']." (".$b['kode_barang'].")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Keperluan</label>
                            <select name="jenis_pengajuan" class="form-select" required>
                                <option value="pinjam">Peminjaman</option>
                                <option value="lapor_kerusakan">Lapor Kerusakan</option>
                                <option value="pengadaan">Pengajuan Barang Baru</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan / Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan detail pengajuan Anda..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>