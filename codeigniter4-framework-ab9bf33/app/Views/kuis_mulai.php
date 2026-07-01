<?php
// ============================================================
// KUIS MULAI — Form isi kuis pilihan ganda
// Karyawan memilih jawaban A/B/C/D untuk setiap soal,
// lalu submit untuk dinilai otomatis.
// ============================================================
$modul = $modul ?? [];
$soalList = $soalList ?? [];
$totalSoal = count($soalList);
?>

<div class="card p-4 shadow-sm mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <h4 class="mb-1"><i class="bi bi-pencil-square text-primary"></i> Kuis: <?php echo esc($modul['judul'] ?? 'Modul'); ?></h4>
            <p class="text-muted mb-0">Jawab semua pertanyaan di bawah ini. Total: <strong><?php echo $totalSoal; ?> soal</strong>. Passing grade: <strong>70</strong>.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div id="quizTimer" class="badge bg-danger fs-6 px-3 py-2 shadow-sm">
                <i class="bi bi-clock"></i> <span id="timeDisplay">10:00</span>
            </div>
            <a href="<?php echo site_url('karyawan/modul'); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <form method="post" action="<?php echo site_url('karyawan/kuis/submit/' . ($modul['id'] ?? 0)); ?>" id="formKuis">
        <?php if (function_exists('csrf_field')): ?>
            <?php echo csrf_field(); ?>
        <?php endif; ?>

        <?php foreach ($soalList as $idx => $soal): ?>
            <div class="card mb-3 border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <span class="badge bg-primary rounded-pill me-2"><?php echo $idx + 1; ?></span>
                        <?php echo esc($soal['pertanyaan']); ?>
                    </h6>
                    <div class="row g-2">
                        <?php 
                        $opsiList = ['a', 'b', 'c', 'd'];
                        shuffle($opsiList);
                        foreach ($opsiList as $opsi): 
                        ?>
                            <div class="col-12 col-md-6">
                                <div class="form-check p-3 border rounded bg-white quiz-option">
                                    <input class="form-check-input" type="radio"
                                        name="jawaban_<?php echo $soal['id']; ?>"
                                        id="jawaban_<?php echo $soal['id']; ?>_<?php echo $opsi; ?>"
                                        value="<?php echo $opsi; ?>" required>
                                    <label class="form-check-label w-100 cursor-pointer"
                                        for="jawaban_<?php echo $soal['id']; ?>_<?php echo $opsi; ?>">
                                        <strong class="text-primary"><?php echo strtoupper($opsi); ?>.</strong>
                                        <?php echo esc($soal['opsi_' . $opsi]); ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
            <p class="text-muted mb-0 small">Pastikan semua soal sudah dijawab sebelum submit.</p>
            <button type="button" class="btn btn-primary btn-lg px-5 btn-submit-kuis" data-text="Yakin ingin submit jawaban? Jawaban tidak bisa diubah setelah submit.">
                <i class="bi bi-send"></i> Submit Jawaban
            </button>
        </div>
    </form>
</div>

<style>
.quiz-option { transition: all 0.2s ease; cursor: pointer; }
.quiz-option:hover { border-color: #0d6efd !important; background-color: #f0f7ff !important; }
.quiz-option:has(input:checked) { border-color: #0d6efd !important; background-color: #e7f1ff !important; box-shadow: 0 0 0 2px rgba(13,110,253,0.25); }
.cursor-pointer { cursor: pointer; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = 600; // 10 menit dalam detik
    const timeDisplay = document.getElementById('timeDisplay');
    const formKuis = document.getElementById('formKuis');

    const countdown = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(countdown);
            Swal.fire({
                title: 'Waktu Habis!',
                text: 'Kuis akan disubmit secara otomatis.',
                icon: 'warning',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                formKuis.submit();
            });
            return;
        }

        timeLeft--;
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        
        timeDisplay.textContent = minutes + ':' + seconds;

        // Visual warning kalau waktu sisa < 1 menit
        if (timeLeft < 60) {
            document.getElementById('quizTimer').classList.add('animate__animated', 'animate__flash', 'animate__infinite');
        }
    }, 1000);
});
</script>
