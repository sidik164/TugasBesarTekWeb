<?php
// ============================================================
// MODUL KARYAWAN
// Daftar modul pelatihan dengan info soal, status, dan tombol aksi.
// ============================================================
$statusLabel = [
    'belum_mulai'    => ['Belum mulai', 'secondary'],
    'sedang_belajar' => ['Sedang belajar', 'primary'],
    'selesai'        => ['Selesai', 'success'],
];
?>

<div class="card p-4 shadow-sm">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <div>
            <h4 class="mb-1"><?php echo esc($title ?? 'Modul Pelatihan'); ?></h4>
            <p class="text-muted mb-0"><?php echo esc($message ?? ''); ?></p>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?php echo count($records ?? []); ?> modul</span>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Judul Modul</th>
                    <th>Jumlah Soal</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $r): ?>
                        <?php
                            $st = $r['status'] ?? 'belum_mulai';
                            [$label, $warna] = $statusLabel[$st] ?? $statusLabel['belum_mulai'];
                        ?>
                        <tr>
                            <td><?php echo esc($r['urutan']); ?></td>
                            <td><?php echo esc($r['judul']); ?></td>
                            <td><?php echo esc($r['jumlah_soal']); ?> soal</td>
                            <td><span class="badge bg-<?php echo $warna; ?>"><?php echo $label; ?></span></td>
                            <td><?php echo esc($r['nilai']); ?></td>
                            <td class="text-nowrap">
                                <?php if ($r['jumlah_soal'] > 0): ?>
                                    <?php if ($st === 'selesai'): ?>
                                        <a class="btn btn-sm btn-outline-success" href="<?php echo site_url('karyawan/kuis/hasil/' . $r['modul_id']); ?>">
                                            <i class="bi bi-eye"></i> Lihat Hasil
                                        </a>
                                        <a class="btn btn-sm btn-outline-warning" href="<?php echo site_url('karyawan/modul/materi/' . $r['modul_id']); ?>">
                                            <i class="bi bi-book"></i> Baca Materi Lagi
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('karyawan/modul/materi/' . $r['modul_id']); ?>">
                                            <i class="bi bi-book"></i> Baca Materi & Kuis
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted small">Belum ada soal</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-muted">Belum ada modul pelatihan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
