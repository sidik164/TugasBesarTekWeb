<?php
// ============================================================
// MODUL MATERI
// Halaman untuk membaca konten materi sebelum kuis.
// ============================================================
?>

<div class="card p-4 shadow-sm mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 pb-3 border-bottom">
        <div>
            <h4 class="mb-1 text-primary"><i class="bi bi-book"></i> <?php echo esc($title ?? 'Materi'); ?></h4>
            <p class="text-muted mb-0">Baca dan pahami materi di bawah ini sebelum melanjutkan ke kuis.</p>
        </div>
        <a href="<?php echo site_url('karyawan/modul'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="materi-content mb-5 text-center">
        <?php if (!empty($modul['file_materi'])): ?>
            <?php 
                $fileUrl = base_url('assets/uploads/materi/' . $modul['file_materi']);
                $ext = strtolower(pathinfo($modul['file_materi'], PATHINFO_EXTENSION));
            ?>
            <?php if ($ext === 'pdf'): ?>
                <embed src="<?php echo esc($fileUrl); ?>" type="application/pdf" width="100%" height="700px" class="border rounded shadow-sm">
            <?php elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                <img src="<?php echo esc($fileUrl); ?>" alt="Materi Modul" class="img-fluid rounded shadow-sm" style="max-height: 800px;">
            <?php else: ?>
                <div class="alert alert-warning">
                    Format file tidak didukung untuk ditampilkan langsung. <a href="<?php echo esc($fileUrl); ?>" target="_blank">Download File</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis text-start">
                <i class="bi bi-info-circle me-2"></i> Belum ada file materi yang diunggah untuk modul ini. Silakan langsung menuju kuis.
            </div>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-end border-top pt-4">
        <a href="<?php echo site_url('karyawan/kuis/mulai/' . ($modul['id'] ?? 0)); ?>" class="btn btn-primary btn-lg px-5 shadow">
            <i class="bi bi-play-circle"></i> Mulai Kuis Sekarang
        </a>
    </div>
</div>
