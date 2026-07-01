<?php
// ============================================================
// KUIS KARYAWAN
// Daftar progress kuis milik karyawan yang login.
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
            <h4 class="mb-1"><?php echo esc($title ?? 'Kuis Saya'); ?></h4>
            <p class="text-muted mb-0"><?php echo esc($message ?? ''); ?></p>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><?php echo count($records ?? []); ?> kuis</span>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Modul</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $row): ?>
                        <?php
                            $st = $row['status'] ?? 'belum_mulai';
                            [$label, $warna] = $statusLabel[$st] ?? $statusLabel['belum_mulai'];
                        ?>
                        <tr>
                            <td><?php echo esc($row['judul'] ?? '-'); ?></td>
                            <td><span class="badge bg-<?php echo $warna; ?>"><?php echo $label; ?></span></td>
                            <td>
                                <?php if ($row['nilai_kuis'] !== null): ?>
                                    <span class="fw-bold <?php echo ($row['nilai_kuis'] >= 70) ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo esc($row['nilai_kuis']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap">
                                <?php if ($row['nilai_kuis'] !== null): ?>
                                    <a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('karyawan/kuis/hasil/' . $row['modul_id']); ?>">
                                        <i class="bi bi-eye"></i> Lihat Hasil
                                    </a>
                                <?php endif; ?>
                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo site_url('karyawan/kuis/mulai/' . $row['modul_id']); ?>">
                                    <i class="bi bi-arrow-repeat"></i> <?php echo ($st === 'selesai') ? 'Ulangi' : 'Kerjakan'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-muted">Belum ada kuis yang dikerjakan. Mulai dari halaman <a href="<?php echo site_url('karyawan/modul'); ?>">Modul</a>.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
