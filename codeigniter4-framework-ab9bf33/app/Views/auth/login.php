<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning Pelatihan Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans for Premium Aesthetic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css'); ?>">
</head>
<body>
<div class="login-shell d-flex align-items-center justify-content-center min-vh-100 px-3 py-4">
    <div class="login-card card shadow-lg border-0 overflow-hidden w-100 animate-fade-in-up">
        <div class="row g-0">
            <div class="col-lg-6 login-hero p-4 p-md-5 text-white">
                <div class="d-inline-flex align-items-center gap-2 badge rounded-pill login-badge mb-4 px-3 py-2">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                    E-Learning Industry 4.0
                </div>
                <h1 class="display-6 fw-bold mb-3" style="letter-spacing: -0.5px;">Tingkatkan Kompetensimu Bersama Kami</h1>
                <p class="mb-5 opacity-75" style="line-height: 1.6;">Platform cerdas untuk mengakses modul pelatihan interaktif, mengikuti evaluasi kuis, dan meraih sertifikat keahlian digital secara instan.</p>
                <div class="login-feature-list mt-3">
                    <div class="login-feature-item">
                        <i class="bi bi-book-half text-warning"></i>
                        <div>
                            <strong>Materi Terstruktur</strong><br>
                            <small class="opacity-75">Akses berbagai modul materi dari ahli.</small>
                        </div>
                    </div>
                    <div class="login-feature-item">
                        <i class="bi bi-stopwatch text-info"></i>
                        <div>
                            <strong>Evaluasi Dinamis</strong><br>
                            <small class="opacity-75">Uji pemahamanmu dengan kuis interaktif.</small>
                        </div>
                    </div>
                    <div class="login-feature-item">
                        <i class="bi bi-patch-check-fill text-success"></i>
                        <div>
                            <strong>Sertifikasi Otomatis</strong><br>
                            <small class="opacity-75">Dapatkan e-sertifikat langsung setelah lulus.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 p-4 p-md-5 bg-white d-flex flex-column">
                <div class="my-auto">
                    <div class="mb-5 text-center text-lg-start">
                        <h3 class="mb-2 fw-bold text-dark">Selamat Datang 👋</h3>
                        <p class="text-muted mb-0">Silakan masuk menggunakan akun karyawan atau admin.</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-4"><?php echo esc(session()->getFlashdata('error')); ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success mb-4"><?php echo esc(session()->getFlashdata('message')); ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo site_url('login'); ?>" class="vstack gap-4">
                        <?php if (function_exists('csrf_field')): ?>
                            <?php echo csrf_field(); ?>
                        <?php endif; ?>
                        <div>
                            <label class="form-label fw-bold text-dark" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-lg py-3 bg-light border-0" placeholder="admin / yuda" required>
                        </div>
                        <div>
                            <label class="form-label fw-bold text-dark" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg py-3 bg-light border-0" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg login-submit py-3 fw-bold mt-2 shadow-sm">Masuk Sekarang</button>
                    </form>
                </div>

                <div class="mt-auto pt-5 text-center text-muted">
                    <small>Butuh bantuan akses? <a href="#" class="text-decoration-none fw-semibold">Hubungi Administrator HR</a></small>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>