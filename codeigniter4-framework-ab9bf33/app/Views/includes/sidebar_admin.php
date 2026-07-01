<?php
// ============================================================
// SIDEBAR ADMIN
// Menu navigasi khusus role admin.
// $active dikirim dari controller untuk menandai menu aktif.
// ============================================================
if (!isset($active)) { $active = ''; }
?>
<div class="col-12 col-md-2 bg-light sidebar py-3 px-3 px-md-2">
    <div class="nav flex-row flex-md-column gap-2 gap-md-0 overflow-auto sidebar-nav">
        <a class="nav-link <?php echo $active === 'dashboard' ? 'active' : ''; ?>" href="<?php echo site_url('admin/dashboard'); ?>">
            <i class="bi bi-speedometer2"></i> <span class="sidebar-text">Dashboard</span>
        </a>
        <a class="nav-link <?php echo $active === 'modul' ? 'active' : ''; ?>" href="<?php echo site_url('admin/modul'); ?>">
            <i class="bi bi-journal-bookmark"></i> <span class="sidebar-text">Modul pelatihan</span>
        </a>
        <a class="nav-link <?php echo $active === 'soal' ? 'active' : ''; ?>" href="<?php echo site_url('admin/soal'); ?>">
            <i class="bi bi-pencil-square"></i> <span class="sidebar-text">Soal Kuis</span>
        </a>
        <a class="nav-link <?php echo $active === 'progress' ? 'active' : ''; ?>" href="<?php echo site_url('admin/progress'); ?>">
            <i class="bi bi-bar-chart-line"></i> <span class="sidebar-text">Progress</span>
        </a>
        <a class="nav-link <?php echo $active === 'kuis' ? 'active' : ''; ?>" href="<?php echo site_url('admin/kuis'); ?>">
            <i class="bi bi-patch-question"></i> <span class="sidebar-text">Kuis</span>
        </a>
        <a class="nav-link <?php echo ($active === 'sertifikat' || $active === 'sertifikat-manage') ? 'active' : ''; ?>" href="<?php echo site_url('admin/sertifikat-manage'); ?>">
            <i class="bi bi-patch-check"></i> <span class="sidebar-text">Sertifikat</span>
        </a>
        <a class="nav-link <?php echo $active === 'users' ? 'active' : ''; ?>" href="<?php echo site_url('admin/users'); ?>">
            <i class="bi bi-people"></i> <span class="sidebar-text">Kelola user</span>
        </a>
        <a class="nav-link <?php echo $active === 'about' ? 'active' : ''; ?>" href="<?php echo site_url('admin/about'); ?>">
            <i class="bi bi-info-circle"></i> <span class="sidebar-text">About us</span>
        </a>
    </div>
</div>
<div class="col-12 col-md-10 py-4 px-3 px-md-4 main-content">
