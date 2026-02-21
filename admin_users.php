<?php
session_start();
// Proteksi halaman: Hanya admin yang boleh masuk
if($_SESSION['role'] != "admin"){
    header("location:login.php?pesan=belum_login");
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { display: flex; overflow-x: hidden; background-color: #f8f9fa; }
        .main-content { flex-grow: 1; padding: 20px; }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 card-custom p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-muted">Manage Users</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Admin: <strong><?php echo $_SESSION['username']; ?></strong></span>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">Daftar Pengguna Sistem</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                     <i class="bi bi-person-plus me-2"></i>Tambah User
                    </button>
                </div>

                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == "hapus_berhasil"): ?>
    <div class="alert alert-danger alert-dismissible fade show card-custom" role="alert">
        <i class="bi bi-trash-fill me-2"></i> <strong>Berhasil!</strong> Data pengguna telah dihapus dari sistem.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(isset($_GET['pesan']) && $_GET['pesan'] == "tambah_berhasil"): ?>
    <div class="alert alert-success alert-dismissible fade show card-custom" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <strong>Berhasil!</strong> Pengguna baru telah ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role / Hak Akses</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY role ASC");
                            while($user = mysqli_fetch_assoc($query)){
                                // Warna badge berdasarkan role
                                $role_badge = ($user['role'] == 'admin') ? 'bg-danger' : 'bg-info text-dark';
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo $user['nama_lengkap']; ?>&background=random" class="rounded-circle" width="35">
                                </td>
                                <td class="fw-bold"><?php echo $user['nama_lengkap']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td>
                                    <span class="badge <?php echo $role_badge; ?>">
                                        <?php echo strtoupper($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    
                                    <?php if($user['username'] != $_SESSION['username']): ?>
                                        <a href="hapus_user.php?id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="mt-5 text-center text-muted small">
            Copyright &copy; <?php echo date('Y'); ?> Farisul Fahmi
        </footer>
        <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_user.php?aksi=tambah" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required placeholder="Masukkan nama asli">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required placeholder="Untuk login">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role / Hak Akses</label>
                        <select name="role" class="form-select">
                            <option value="user">User / Mahasiswa</option>
                            <option value="admin">Admin Lab</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>