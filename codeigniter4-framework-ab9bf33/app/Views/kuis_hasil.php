<?php
// ============================================================
// KUIS HASIL — Tampilkan hasil kuis (nilai, jawaban per soal)
// ============================================================
$modul = $modul ?? [];
$hasil = $hasil ?? [];
$sertifikat = $sertifikat ?? null;
$nilai = $hasil['nilai'] ?? 0;
$lulus = $hasil['lulus'] ?? false;
$benar = $hasil['benar'] ?? null;
$total = $hasil['total'] ?? null;
$jawaban = $hasil['jawaban'] ?? null;
$soalList = $hasil['soalList'] ?? null;
?>

<div class="card p-4 shadow-sm mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h4 class="mb-1"><i class="bi bi-clipboard-check text-<?php echo $lulus ? 'success' : 'danger'; ?>"></i> Hasil Kuis: <?php echo esc($modul['judul'] ?? 'Modul'); ?></h4>
        </div>
        <a href="<?php echo site_url('karyawan/kuis'); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- SCORE CARD -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card p-3 text-center border-0 <?php echo $lulus ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'; ?>">
                <small class="text-muted">Nilai</small>
                <h1 class="mb-0 <?php echo $lulus ? 'text-success' : 'text-danger'; ?>"><?php echo $nilai; ?></h1>
                <small class="text-muted">dari 100</small>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 text-center border-0 bg-light">
                <small class="text-muted">Status</small>
                <h4 class="mb-0">
                    <?php if ($lulus): ?>
                        <span class="badge bg-success fs-6"><i class="bi bi-check-circle"></i> LULUS</span>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6"><i class="bi bi-x-circle"></i> BELUM LULUS</span>
                    <?php endif; ?>
                </h4>
                <small class="text-muted">Passing grade: 70</small>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3 text-center border-0 bg-light">
                <small class="text-muted">Jawaban Benar</small>
                <h2 class="mb-0"><?php echo $benar !== null ? $benar . '/' . $total : '-'; ?></h2>
                <small class="text-muted">soal</small>
            </div>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <?php if ($lulus && $sertifikat): ?>
            <a href="<?php echo site_url('karyawan/sertifikat/print/' . $sertifikat['id']); ?>" class="btn btn-success" target="_blank">
                <i class="bi bi-printer"></i> Print Sertifikat
            </a>
        <?php elseif ($lulus && !$sertifikat): ?>
            <span class="btn btn-outline-success disabled"><i class="bi bi-award"></i> Sertifikat sedang diproses</span>
        <?php endif; ?>
        <a href="<?php echo site_url('karyawan/kuis/mulai/' . ($modul['id'] ?? 0)); ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-repeat"></i> Ulangi Kuis
        </a>
    </div>

    <!-- DETAIL JAWABAN (jika tersedia dari submit) -->
    <?php if ($jawaban !== null && $soalList !== null): ?>
        <h5 class="mb-3">Detail Jawaban</h5>
        <?php foreach ($soalList as $idx => $soal): ?>
            <?php
                $jw = $jawaban[$idx] ?? [];
                $isBenar = $jw['is_benar'] ?? false;
                $jawabanUser = strtoupper($jw['jawaban_user'] ?? '-');
                $jawabanBenar = strtoupper($jw['jawaban_benar'] ?? '-');
            ?>
            <div class="card mb-2 border-0 <?php echo $isBenar ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'; ?>">
                <div class="card-body py-3">
                    <div class="d-flex align-items-start gap-2">
                        <span class="badge rounded-pill <?php echo $isBenar ? 'bg-success' : 'bg-danger'; ?> mt-1">
                            <?php echo $idx + 1; ?>
                        </span>
                        <div class="flex-grow-1">
                            <p class="mb-1 fw-medium"><?php echo esc($soal['pertanyaan']); ?></p>
                            <div class="small">
                                <span class="me-3">
                                    Jawaban kamu: <strong class="<?php echo $isBenar ? 'text-success' : 'text-danger'; ?>"><?php echo $jawabanUser ?: '-'; ?></strong>
                                    <?php if (!empty($jw['jawaban_user'])): ?>
                                        (<?php echo esc($soal['opsi_' . strtolower($jw['jawaban_user'])] ?? ''); ?>)
                                    <?php endif; ?>
                                </span>
                                <?php if (!$isBenar): ?>
                                    <span>
                                        Jawaban benar: <strong class="text-success"><?php echo $jawabanBenar; ?></strong>
                                        (<?php echo esc($soal['opsi_' . strtolower($jw['jawaban_benar'])] ?? ''); ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="text-success"><i class="bi bi-check-circle-fill"></i> Benar!</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
