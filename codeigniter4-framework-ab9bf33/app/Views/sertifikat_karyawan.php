<?php
// ============================================================
// SERTIFIKAT KARYAWAN
// Daftar sertifikat milik karyawan yang login + tombol print.
// ============================================================
?>

<div class="card p-4 shadow-sm">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
        <div>
            <h4 class="mb-1"><?php echo esc($title ?? 'Sertifikat Saya'); ?></h4>
            <p class="text-muted mb-0"><?php echo esc($message ?? ''); ?></p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle"><?php echo count($records ?? []); ?> sertifikat</span>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Modul</th>
                    <th>Tanggal Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td>
                                <i class="bi bi-award text-warning me-1"></i>
                                <?php echo esc($row['judul'] ?? '-'); ?>
                            </td>
                            <td><?php echo esc($row['issued_at'] ?? '-'); ?></td>
                            <td class="text-nowrap">
                                <a class="btn btn-sm btn-outline-success" href="<?php echo site_url('karyawan/sertifikat/print/' . $row['id']); ?>" target="_blank">
                                    <i class="bi bi-printer"></i> Print Sertifikat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-muted">Belum ada sertifikat. Selesaikan kuis dengan nilai ≥ 70 untuk mendapatkan sertifikat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
