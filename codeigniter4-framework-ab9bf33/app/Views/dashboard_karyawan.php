<?php
// ============================================================
// DASHBOARD KARYAWAN
// Tampilan progress belajar pribadi untuk role karyawan.
// Tanpa if-else role — khusus karyawan saja.
// ============================================================

$nama = $nama ?? 'Karyawan';
$totalModulKaryawan = $totalModulKaryawan ?? 0;
$modulSelesai = $modulSelesai ?? 0;
$rataNilai = $rataNilai ?? 0;
$totalSertifikatKaryawan = $totalSertifikatKaryawan ?? 0;
$daftarModul = $daftarModul ?? [];
?>

<h4>Halo, <?php echo esc($nama); ?></h4>
<p class="text-muted">Lanjutkan pelatihan kamu hari ini.</p>

<!-- ===================== STATISTIK KARYAWAN ===================== -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-3">
        <div class="card p-3">
            <small class="text-muted">Modul selesai</small>
            <h3><?php echo esc($modulSelesai); ?> / <?php echo esc($totalModulKaryawan); ?></h3>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card p-3">
            <small class="text-muted">Rata-rata nilai kuis</small>
            <h3><?php echo esc($rataNilai); ?></h3>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card p-3">
            <small class="text-muted">Sertifikat diperoleh</small>
            <h3><?php echo esc($totalSertifikatKaryawan); ?></h3>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card p-3">
            <small class="text-muted">Aksi Cepat</small>
            <div class="d-flex flex-wrap gap-1 mt-1">
                <a href="<?php echo site_url('karyawan/modul'); ?>" class="btn btn-sm btn-primary"><i class="bi bi-play-circle"></i> Mulai Kuis</a>
                <a href="<?php echo site_url('karyawan/sertifikat'); ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-award"></i> Sertifikat</a>
            </div>
        </div>
    </div>
</div>

<h6>Progress modul pelatihan</h6>
<?php
// Peta warna & label per status
$labelStatus = [
    'belum_mulai'   => ['Belum mulai', 'secondary'],
    'sedang_belajar'=> ['Sedang belajar', 'primary'],
    'selesai'       => ['Selesai', 'success'],
];
foreach ($daftarModul as $m):
    $status = $m['status'] ?? 'belum_mulai';
    [$label, $warna] = $labelStatus[$status] ?? $labelStatus['belum_mulai'];
    $persen = $status === 'selesai' ? 100 : ($status === 'sedang_belajar' ? 50 : 0);
?>
<div class="card p-3 mb-2">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <span><?php echo esc($m['judul'] ?? 'Modul'); ?></span>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-<?php echo $warna; ?>"><?php echo $label; ?></span>
            <?php if ($status === 'selesai'): ?>
                <a href="<?php echo site_url('karyawan/kuis/hasil/' . $m['id']); ?>" class="btn btn-sm btn-outline-success py-0 px-2" title="Lihat hasil kuis">
                    <i class="bi bi-eye"></i>
                </a>
            <?php elseif ($status !== 'selesai'): ?>
                <a href="<?php echo site_url('karyawan/kuis/mulai/' . $m['id']); ?>" class="btn btn-sm btn-primary py-0 px-2" title="Mulai kuis">
                    <i class="bi bi-play-fill"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="progress progress-thin">
        <div class="progress-bar" style="width: <?php echo $persen; ?>%"></div>
    </div>
    <?php if (($m['nilai_kuis'] ?? null) !== null): ?>
        <small class="text-muted mt-1">Nilai: <?php echo esc($m['nilai_kuis']); ?></small>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<?php if (empty($daftarModul)): ?>
    <p class="text-muted">Belum ada modul pelatihan yang tersedia.</p>
<?php endif; ?>
