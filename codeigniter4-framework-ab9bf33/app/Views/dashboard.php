<?php
// ============================================================
// FILE dashboard.php
// Halaman utama setelah login. Isinya BEDA tergantung role:
// - admin  : lihat statistik keseluruhan (total user, total modul, dst)
// - karyawan : lihat progress belajarnya sendiri
// ============================================================

$active = 'dashboard'; // dipakai sidebar.php untuk menandai menu yang aktif
$role = session()->get('role') ?? 'admin';
$userId = session()->get('user_id') ?? 1;
$nama = session()->get('nama') ?? 'Demo User';

$totalKaryawan = $totalKaryawan ?? 0;
$totalModul = $totalModul ?? 0;
$completionRate = $completionRate ?? 0;
$totalSertifikat = $totalSertifikat ?? 0;
$totalModulKaryawan = $totalModulKaryawan ?? 0;
$modulSelesai = $modulSelesai ?? 0;
$rataNilai = $rataNilai ?? 0;
$totalSertifikatKaryawan = $totalSertifikatKaryawan ?? 0;
$daftarModul = $daftarModul ?? [];

// ------------------------------------------------------------
// Blok if-else ini menyiapkan data statistik yang berbeda
// tergantung role user yang sedang login
// ------------------------------------------------------------

?>

<h4>Halo, <?php echo esc($nama); ?></h4>
<p class="text-muted">
    <?php echo $role === 'admin' ? 'Ringkasan aktivitas pelatihan seluruh karyawan.' : 'Lanjutkan pelatihan kamu hari ini.'; ?>
</p>

<?php if ($role === 'admin'): ?>
    <!-- ===================== TAMPILAN DASHBOARD ADMIN ===================== -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card p-3">
                <small class="text-muted">Total karyawan</small>
                <h3><?php echo $totalKaryawan; ?></h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card p-3">
                <small class="text-muted">Total modul</small>
                <h3><?php echo $totalModul; ?></h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card p-3">
                <small class="text-muted">Completion rate</small>
                <h3><?php echo $completionRate; ?>%</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card p-3">
                <small class="text-muted">Sertifikat terbit</small>
                <h3><?php echo $totalSertifikat; ?></h3>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?php echo site_url('modul'); ?>" class="btn btn-primary btn-sm">Kelola modul pelatihan</a>
        <a href="<?php echo site_url('users'); ?>" class="btn btn-outline-secondary btn-sm">Kelola user</a>
    </div>

<?php else: ?>
    <!-- ===================== TAMPILAN DASHBOARD KARYAWAN ===================== -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <small class="text-muted">Modul selesai</small>
                <h3><?php echo esc($modulSelesai); ?> / <?php echo esc($totalModulKaryawan); ?></h3>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <small class="text-muted">Rata-rata nilai kuis</small>
                <h3><?php echo esc($rataNilai); ?></h3>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <small class="text-muted">Sertifikat diperoleh</small>
                <h3><?php echo esc($totalSertifikatKaryawan); ?></h3>
            </div>
        </div>
    </div>

    <h6>Progress modul pelatihan</h6>
    <?php
    // Peta warna & label per status, supaya tidak nulis if-else berulang di dalam loop
    $labelStatus = [
        'belum_mulai'   => ['Belum mulai', 'secondary'],
        'sedang_belajar'=> ['Sedang belajar', 'primary'],
        'selesai'       => ['Selesai', 'success'],
    ];
    // foreach di sini me-loop setiap modul untuk ditampilkan sebagai satu baris progress
    foreach ($daftarModul as $m):
        // Kalau karyawan belum punya data progress, anggap belum mulai.
        $status = $m['status'] ?? 'belum_mulai';
        [$label, $warna] = $labelStatus[$status] ?? $labelStatus['belum_mulai'];
        $persen = $status === 'selesai' ? 100 : ($status === 'sedang_belajar' ? 50 : 0);
    ?>
    <div class="card p-3 mb-2">
        <div class="d-flex justify-content-between mb-1">
            <span><?php echo esc($m['judul'] ?? 'Modul'); ?></span>
            <span class="badge bg-<?php echo $warna; ?>"><?php echo $label; ?></span>
        </div>
        <div class="progress progress-thin">
            <div class="progress-bar" style="width: <?php echo $persen; ?>%"></div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if (empty($daftarModul)): ?>
        <p class="text-muted">Belum ada modul pelatihan yang tersedia.</p>
    <?php endif; ?>
<?php endif; ?>

