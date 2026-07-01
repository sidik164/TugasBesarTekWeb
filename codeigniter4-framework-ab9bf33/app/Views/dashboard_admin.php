<?php
// ============================================================
// DASHBOARD ADMIN
// Tampilan statistik keseluruhan untuk role admin.
// Tanpa if-else role — khusus admin saja.
// ============================================================

$nama = $nama ?? 'Admin';
$totalKaryawan = $totalKaryawan ?? 0;
$totalModul = $totalModul ?? 0;
$completionRate = $completionRate ?? 0;
$totalSertifikat = $totalSertifikat ?? 0;
?>

<h4>Halo, <?php echo esc($nama); ?></h4>
<p class="text-muted">Ringkasan aktivitas pelatihan seluruh karyawan.</p>

<!-- ===================== STATISTIK ADMIN ===================== -->
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
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="<?php echo site_url('admin/modul'); ?>" class="btn btn-primary btn-sm">Kelola modul pelatihan</a>
    <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-outline-secondary btn-sm">Kelola user</a>
</div>

<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Statistik Progress Belajar</h5>
            <div style="position: relative; height:300px; width:100%;">
                <canvas id="progressChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('progressChart').getContext('2d');
    const dataProgress = <?php echo json_encode($chartData ?? [0,0,0]); ?>;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Sedang Belajar', 'Belum Mulai'],
            datasets: [{
                data: dataProgress,
                backgroundColor: [
                    '#198754', // success
                    '#0d6efd', // primary
                    '#6c757d'  // secondary
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
