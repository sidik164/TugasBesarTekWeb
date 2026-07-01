<?php
// ============================================================
// SIDEBAR KARYAWAN
// Menu navigasi khusus role karyawan.
// Tidak ada menu "Kelola user" — hanya fitur belajar.
// $active dikirim dari controller untuk menandai menu aktif.
// ============================================================
if (!isset($active)) { $active = ''; }
?>
<div class="col-12 col-md-2 bg-light sidebar py-3 px-3 px-md-2">
    <div class="nav flex-row flex-md-column gap-2 gap-md-0 overflow-auto sidebar-nav">
        <a class="nav-link <?php echo $active === 'dashboard' ? 'active' : ''; ?>" href="<?php echo site_url('karyawan/dashboard'); ?>">
            <i class="bi bi-speedometer2"></i> <span class="sidebar-text">Dashboard</span>
        </a>
        <a class="nav-link <?php echo $active === 'modul' ? 'active' : ''; ?>" href="<?php echo site_url('karyawan/modul'); ?>">
            <i class="bi bi-journal-bookmark"></i> <span class="sidebar-text">Modul pelatihan</span>
        </a>
        <a class="nav-link <?php echo $active === 'kuis' ? 'active' : ''; ?>" href="<?php echo site_url('karyawan/kuis'); ?>">
            <i class="bi bi-patch-question"></i> <span class="sidebar-text">Kuis Saya</span>
        </a>
        <a class="nav-link <?php echo $active === 'sertifikat' ? 'active' : ''; ?>" href="<?php echo site_url('karyawan/sertifikat'); ?>">
            <i class="bi bi-patch-check"></i> <span class="sidebar-text">Sertifikat Saya</span>
        </a>
        <a class="nav-link <?php echo $active === 'about' ? 'active' : ''; ?>" href="<?php echo site_url('karyawan/about'); ?>">
            <i class="bi bi-info-circle"></i> <span class="sidebar-text">About us</span>
        </a>
    </div>
</div>
<div class="col-12 col-md-10 py-4 px-3 px-md-4 main-content">
