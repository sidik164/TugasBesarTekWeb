<?php
// ============================================================
// KUIS KOSONG — Modul tidak memiliki soal kuis
// ============================================================
$modul = $modul ?? [];
?>

<div class="card p-4 shadow-sm text-center">
    <div class="py-5">
        <i class="bi bi-journal-x display-1 text-muted"></i>
        <h4 class="mt-3">Belum Ada Soal Kuis</h4>
        <p class="text-muted">Modul <strong><?php echo esc($modul['judul'] ?? ''); ?></strong> belum memiliki soal kuis.</p>
        <p class="text-muted">Hubungi admin untuk menambahkan soal.</p>
        <a href="<?php echo site_url('karyawan/modul'); ?>" class="btn btn-outline-primary mt-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Modul
        </a>
    </div>
</div>
