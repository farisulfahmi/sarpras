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
    <title>Manage Inventori - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { display: flex; background-color: #f8f9fa; }
        .main-content { flex-grow: 1; padding: 20px; min-height: 100vh; }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 card-custom p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-muted">Manage Inventori Lab</span>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Barang
                </button>
            </div>
        </nav>

        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC");
                        while($row = mysqli_fetch_assoc($query)) {
                            $kondisi_class = ($row['kondisi'] == 'baik') ? 'bg-success' : (($row['kondisi'] == 'rusak') ? 'bg-danger' : 'bg-warning text-dark');
                        ?>
                        <tr>
                            <td><span class="badge bg-dark"><?= $row['kode_barang'] ?></span></td>
                            <td><strong><?= $row['nama_barang'] ?></strong></td>
                            <td><?= $row['kategori'] ?></td>
                            <td><?= $row['stok'] ?> Unit</td>
                            <td><span class="badge <?= $kondisi_class ?>"><?= ucfirst($row['kondisi']) ?></span></td>
                            <td class="text-center">
                                <a href="edit_barang.php?id=<?= $row['id_barang'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <a href="proses_barang.php?aksi=hapus&id=<?= $row['id_barang'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus barang ini?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="proses_barang.php?aksi=tambah" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: PC-001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Hardware / Kursi">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi</label>
                                <select name="kondisi" class="form-select">
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="perbaikan">Perbaikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>