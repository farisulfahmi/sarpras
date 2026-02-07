<?php 
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 280px; height: 100vh; background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);">
    <a href="dashboard_user.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none brand-logo" style="font-weight:700; padding:1.5rem 1rem;">
        <i class="bi bi-cpu-fill me-2 fs-3"></i>
        <span>SARPRAS LAB</span>
    </a>
    <hr class="opacity-25">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard_user.php" class="nav-link text-white <?php echo ($current_page == 'dashboard_user.php') ? 'active' : ''; ?>" style="padding:12px 20px; margin:8px 0; border-radius:10px;">
                <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="panduan_lab.php" class="nav-link text-white opacity-50" style="padding:12px 20px;">
                <i class="bi bi-info-circle me-3"></i> Panduan Lab
            </a>
        </li>
    </ul>
    <hr class="opacity-25">
    <div style="padding: 20px;">
        <a href="logout.php" class="btn btn-outline-danger w-100 fw-bold" style="border-radius:10px;">
            <i class="bi bi-box-arrow-right me-2"></i> Keluar
        </a>
    </div>
</div>

<style>
    /* Tambahan agar sidebar user konsisten dengan admin */
    .nav-link:hover { background-color: rgba(255,255,255,0.1); }
    .nav-link.active { background-color: #00d2ff !important; box-shadow: 0 4px 15px rgba(0,210,255,0.3); }
</style>