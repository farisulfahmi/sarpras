<?php
session_start();

// Proteksi Halaman: Cek apakah user sudah login dan memiliki role admin
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
    <title>Admin Dashboard - Inventori Lab</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body { display: flex; overflow-x: hidden; background-color: #f8f9fa; }
        .main-content { flex-grow: 1; padding: 20px; min-height: 100vh; }
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .navbar { border-radius: 10px; }
    </style>
</head>

<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 card-custom p-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 text-muted">Dashboard Overview</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong></span>
                    <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['username']; ?>&background=0D6EFD&color=fff" class="rounded-circle" width="40" alt="Avatar">
                </div>
            </div>
        </nav>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white border-start border-primary border-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Total Barang</h6>
                    <h2 class="fw-bold mb-0">
                        <?php 
                        $q_barang = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang");
                        echo mysqli_fetch_assoc($q_barang)['total'];
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white border-start border-warning border-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Pending Pengajuan</h6>
                    <h2 class="fw-bold mb-0">
                        <?php 
                        $q_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengajuan WHERE status='pending'");
                        echo mysqli_fetch_assoc($q_pending)['total'];
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white border-start border-warning border-4">
                    <h6 class="text-muted text-uppercase small fw-bold">Data Users</h6>
                    <h2 class="fw-bold mb-0">
                        <?php 
                        $q_users = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users");
                        echo mysqli_fetch_assoc($q_users)['total'];
                        ?>
                    </h2>
                </div>
            </div>
            <!-- <div class="col-md-4 d-flex align-items-center justify-content-end">
                <button class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-download me-2"></i>Generate Report
                </button>
            </div> -->
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0 text-primary">Pengajuan Terbaru</h5>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query JOIN untuk mengambil Nama Lengkap User dari tabel Users
                                $query_pengajuan = mysqli_query($koneksi, "SELECT pengajuan.*, users.nama_lengkap 
                                                                          FROM pengajuan 
                                                                          JOIN users ON pengajuan.id_user = users.id_user 
                                                                          ORDER BY tanggal_pengajuan DESC LIMIT 5");

                                if (mysqli_num_rows($query_pengajuan) > 0) {
                                    while ($data = mysqli_fetch_assoc($query_pengajuan)) {
                                        // Logika Pewarnaan Badge Status
                                        $badge_color = 'bg-secondary';
                                        if ($data['status'] == 'disetujui') $badge_color = 'bg-success';
                                        if ($data['status'] == 'ditolak') $badge_color = 'bg-danger';
                                        if ($data['status'] == 'pending') $badge_color = 'bg-warning text-dark';
                                ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name=<?php echo $data['nama_lengkap']; ?>&background=random" class="rounded-circle me-3" width="32">
                                                    <span class="fw-semibold"><?php echo $data['nama_lengkap']; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge border text-dark bg-light px-3 py-2">
                                                    <?php echo ucfirst(str_replace('_', ' ', $data['jenis_pengajuan'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($data['tanggal_pengajuan'])); ?></td>
                                            <td>
                                                <span class="badge <?php echo $badge_color; ?> px-3 py-2">
                                                    <?php echo ucfirst($data['status']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="proses_status.php?id=<?php echo $data['id_pengajuan']; ?>&aksi=setuju" 
                                                       class="btn btn-sm btn-outline-success" 
                                                       onclick="return confirm('Setujui pengajuan ini?')"
                                                       title="Setujui">
                                                        <i class="bi bi-check-lg"></i>
                                                    </a>
                                                    <a href="proses_status.php?id=<?php echo $data['id_pengajuan']; ?>&aksi=tolak" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Tolak pengajuan ini?')"
                                                       title="Tolak">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data pengajuan yang masuk.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-auto pt-5 pb-3 text-center text-muted small">
            <hr class="mb-4">
            Copyright &copy; <?php echo date('Y'); ?> <strong>Farisul Fahmi</strong> • Inventori Lab Komputer
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>