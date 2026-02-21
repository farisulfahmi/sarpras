<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
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
    <title>Kelola Pengajuan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .main-content { flex-grow: 1; padding: 25px; min-height: 100vh; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .table thead { background-color: #f1f3f5; }
        .badge-status { padding: 6px 10px; border-radius: 6px; font-size: 0.8rem; }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 card-custom p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-muted"><i class="bi bi-file-earmark-check me-2"></i>Verifikasi Pengajuan User</span>
            </div>
        </nav>

        <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil_update'): ?>
            <div class="alert alert-success alert-dismissible fade show card-custom mb-4" role="alert">
                <strong>Berhasil!</strong> Status pengajuan telah diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tgl Pengajuan</th>
                            <th>Nama User</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th>Deskripsi User</th>
                            <th>Status</th>
                            <th class="text-center">Aksi & Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.*, u.nama_lengkap, b.nama_barang 
                                FROM pengajuan p
                                JOIN users u ON p.id_user = u.id_user
                                LEFT JOIN barang b ON p.id_barang = b.id_barang
                                ORDER BY p.tanggal_pengajuan DESC";
                        
                        $query = mysqli_query($koneksi, $sql);

                        while($row = mysqli_fetch_assoc($query)) {
                            $status_class = [
                                'pending' => 'bg-warning text-dark',
                                'disetujui' => 'bg-success text-white',
                                'ditolak' => 'bg-danger text-white'
                            ];
                        ?>
                        <tr>
                            <td><small><?= date('d/m/Y H:i', strtotime($row['tanggal_pengajuan'])) ?></small></td>
                            <td><strong><?= $row['nama_lengkap'] ?></strong></td>
                            <td><?= $row['nama_barang'] ?? '<span class="badge bg-secondary">Pengadaan Baru</span>' ?></td>
                            <td><span class="badge border text-dark bg-light"><?= ucfirst($row['jenis_pengajuan']) ?></span></td>
                            <td>
                                <small class="text-muted">
                                    <?= nl2br(htmlspecialchars($row['deskripsi'])) ?>
                                </small>
                            </td>
                            <td><span class="badge badge-status <?= $status_class[$row['status']] ?>"><?= ucfirst($row['status']) ?></span></td>
                            <td class="text-center">
                                <?php if($row['status'] == 'pending'): ?>
                                    <button class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#modalRespon<?= $row['id_pengajuan'] ?>">
                                        <i class="bi bi-chat-left-dots me-1"></i> Respon
                                    </button>

                                    <div class="modal fade" id="modalRespon<?= $row['id_pengajuan'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <form action="proses_status.php" method="POST">
                                                    <div class="modal-header bg-dark text-white">
                                                        <h5 class="modal-title">Berikan Keputusan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <input type="hidden" name="id" value="<?= $row['id_pengajuan'] ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Pilih Status</label>
                                                            <select name="aksi" class="form-select" required>
                                                                <option value="setuju">Setujui Pengajuan</option>
                                                                <option value="tolak">Tolak Pengajuan</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Catatan / Feedback Admin</label>
                                                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Silakan ambil di Lab A jam 10 pagi..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small italic">Selesai: <?= $row['catatan_admin'] ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>