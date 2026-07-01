<?php
// ============================================================
// FILE SIDEBAR
// Menu navigasi kiri. Menu yang muncul berbeda tergantung
// role user (admin melihat lebih banyak menu daripada karyawan).
// $active dikirim dari halaman pemanggil untuk menandai menu aktif.
// ============================================================
if (!isset($active)) { $active = ''; } // default kalau variabel $active belum di-set
$role = session()->get('role') ?? 'guest';
?>
<div class="col-12 col-md-2 bg-light sidebar py-3 px-3 px-md-2">
    <div class="nav flex-row flex-md-column gap-2 gap-md-0 overflow-auto sidebar-nav">
        <a class="nav-link <?php echo $active === 'dashboard' ? 'active' : ''; ?>" href="<?php echo site_url('dashboard'); ?>">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a class="nav-link <?php echo $active === 'modul' ? 'active' : ''; ?>" href="<?php echo site_url('modul'); ?>">
            <i class="bi bi-journal-bookmark"></i> Modul pelatihan
        </a>
        <?php
        // Menu Kuis dan Progress hanya relevan buat karyawan (yang mengerjakan)
        // tapi admin tetap bisa lihat untuk kelola soal
        ?>
        <a class="nav-link <?php echo $active === 'kuis' ? 'active' : ''; ?>" href="<?php echo site_url('kuis'); ?>">
            <i class="bi bi-patch-question"></i> Kuis
        </a>
        <a class="nav-link <?php echo $active === 'sertifikat' ? 'active' : ''; ?>" href="<?php echo site_url('sertifikat'); ?>">
            <i class="bi bi-patch-check"></i> Sertifikat
        </a>
        <?php
        // Menu khusus admin: kelola data user, hanya tampil kalau role === 'admin'
        if ($role === 'admin'): ?>
        <a class="nav-link <?php echo $active === 'users' ? 'active' : ''; ?>" href="<?php echo site_url('users'); ?>">
            <i class="bi bi-people"></i> Kelola user
        </a>
        <?php endif; ?>
        <a class="nav-link <?php echo $active === 'about' ? 'active' : ''; ?>" href="<?php echo site_url('about'); ?>">
            <i class="bi bi-info-circle"></i> About us
        </a>
    </div>
</div>
<div class="col-12 col-md-10 py-4 px-3 px-md-4 main-content">
