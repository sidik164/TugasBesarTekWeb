<?php
// ============================================================
// FILE HEADER
// Berisi bagian <head> HTML + navbar atas yang tampil di
// SEMUA halaman setelah login. File ini di-include, bukan
// diakses langsung oleh browser.
// ============================================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Pelatihan Karyawan</title>
    <!-- Bootstrap 5 dipakai lewat CDN supaya tidak perlu install apa-apa (sesuai spek: boleh pakai template front-end) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans for Premium Aesthetic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark px-3 py-2">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-light btn-sm me-3" id="sidebarToggle" title="Toggle Sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="navbar-brand fw-semibold mb-0">
            <i class="bi bi-mortarboard-fill"></i> Elearning Corp
        </span>
    </div>
    <div class="ms-md-auto d-flex flex-wrap align-items-center justify-content-md-end gap-2 text-light mt-2 mt-md-0">
        <?php if (isLoggedIn()): ?>
            <div class="d-flex align-items-center bg-white bg-opacity-10 rounded-pill px-3 py-1 me-2 border border-light border-opacity-10 shadow-sm transition-all" style="cursor: default;">
                <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 32px; height: 32px; font-size: 0.9rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="d-flex flex-column justify-content-center lh-1 me-2">
                    <span class="fs-6 fw-semibold">Halo, <?php echo esc(explode(' ', session()->get('nama') ?? 'User')[0]); ?> 👋</span>
                    <small class="opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;"><?php echo esc(session()->get('role') ?? 'guest'); ?></small>
                </div>
            </div>
            <a href="<?php echo site_url('logout'); ?>" class="btn btn-sm btn-danger rounded-pill px-3 fw-medium shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        <?php endif; ?>
    </div>
</nav>
<div class="container-fluid animate-fade-in-up">
    <div class="row">
