<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    /* Styling Sidebar Khusus */
    .sidebar {
        width: 280px;
        height: 100vh;
        background: #1e3c72; /* Warna Biru Profesional */
        background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
        font-family: 'Inter', sans-serif;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .brand-logo {
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        text-transform: uppercase;
    }

    .nav-pills .nav-link {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        padding: 12px 20px;
        margin: 8px 15px; /* Memberikan jarak antar menu */
        border-radius: 10px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    /* Efek Hover */
    .nav-pills .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
        transform: translateX(5px);
    }

    /* State Active */
    .nav-pills .nav-link.active {
        background-color: #00d2ff !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
    }

    .nav-link i {
        font-size: 1.2rem;
    }

    .logout-section {
        padding: 20px;
        margin-top: auto;
    }

    .btn-logout {
        background: rgba(255, 71, 87, 0.2);
        border: 1px solid rgba(255, 71, 87, 0.4);
        color: #ff4757;
        font-weight: 700;
        border-radius: 10px;
        padding: 12px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-logout:hover {
        background: #ff4757;
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 71, 87, 0.3);
    }
</style>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white">
    <a href="dashboard_admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none brand-logo">
        <i class="bi bi-cpu-fill me-2 fs-3"></i>
        <span>Sarpras Lab</span>
    </a>
    
    <hr class="mx-3 opacity-25">
    
    <ul class="nav nav-pills flex-column mb-auto mt-2">
        <?php 
            $current_page = basename($_SERVER['PHP_SELF']); 
        ?>
        <li class="nav-item">
            <a href="dashboard_admin.php" class="nav-link <?php echo ($current_page == 'dashboard_admin.php') ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="admin_pengajuan.php" class="nav-link <?php echo ($current_page == 'admin_pengajuan.php') ? 'active' : ''; ?>">
                <i class="bi bi-file-earmark-check-fill me-3"></i> Pengajuan
            </a>
        </li>
        <li>
            <a href="admin_inventori.php" class="nav-link <?php echo ($current_page == 'admin_inventori.php') ? 'active' : ''; ?>">
                <i class="bi bi-box-seam-fill me-3"></i> Inventori
            </a>
        </li>
        <li>
            <a href="admin_users.php" class="nav-link <?php echo ($current_page == 'admin_users.php') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill me-3"></i> Manage Users
            </a>
        </li>
    </ul>
    
    <hr class="mx-3 opacity-25">
    
    <div class="logout-section">
        <a href="logout.php" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <i class="bi bi-box-arrow-right me-2"></i> Keluar Sistem
        </a>
    </div>
</div>