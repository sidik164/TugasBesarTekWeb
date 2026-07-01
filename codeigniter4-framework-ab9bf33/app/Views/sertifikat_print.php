<?php
// ============================================================
// SERTIFIKAT PRINT — Halaman sertifikat full-page, print-ready.
// Dibuka di tab baru, tanpa sidebar/navbar.
// Karyawan bisa Ctrl+P atau klik tombol Print.
// ============================================================
$sertifikat = $sertifikat ?? [];
$nilai = $nilai ?? '-';
$nama = $sertifikat['user_nama'] ?? 'Karyawan';
$modulJudul = $sertifikat['modul_judul'] ?? 'Modul Pelatihan';
$issuedAt = $sertifikat['issued_at'] ?? date('Y-m-d H:i:s');
$sertifikatId = $sertifikat['id'] ?? 0;

// Format tanggal Indonesia
$bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
];
$ts = strtotime($issuedAt);
$tglFormatted = date('d', $ts) . ' ' . ($bulan[(int) date('n', $ts)] ?? '') . ' ' . date('Y', $ts);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat — <?php echo esc($nama); ?> — <?php echo esc($modulJudul); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ========== RESET ========== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
            min-height: 100vh;
        }

        /* ========== PRINT BUTTON ========== */
        .print-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        .print-actions button,
        .print-actions a {
            padding: 10px 28px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-print {
            background: #0d6efd;
            color: #fff;
        }
        .btn-print:hover { background: #0b5ed7; }
        .btn-back {
            background: #e9ecef;
            color: #495057;
        }
        .btn-back:hover { background: #dee2e6; }

        /* ========== SERTIFIKAT ========== */
        .certificate {
            width: 900px;
            min-height: 640px;
            background: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,0.12);
        }

        /* Border dekoratif */
        .certificate::before {
            content: '';
            position: absolute;
            inset: 12px;
            border: 3px solid #c9a94e;
            pointer-events: none;
            z-index: 1;
        }
        .certificate::after {
            content: '';
            position: absolute;
            inset: 18px;
            border: 1px solid #e0cc85;
            pointer-events: none;
            z-index: 1;
        }

        .cert-inner {
            position: relative;
            z-index: 2;
            padding: 50px 60px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 640px;
        }

        /* Ornamen sudut */
        .corner-ornament {
            position: absolute;
            width: 80px;
            height: 80px;
            z-index: 3;
        }
        .corner-ornament.tl { top: 20px; left: 20px; }
        .corner-ornament.tr { top: 20px; right: 20px; transform: scaleX(-1); }
        .corner-ornament.bl { bottom: 20px; left: 20px; transform: scaleY(-1); }
        .corner-ornament.br { bottom: 20px; right: 20px; transform: scale(-1, -1); }
        .corner-ornament svg { width: 100%; height: 100%; fill: #c9a94e; opacity: 0.6; }

        /* Teks utama */
        .cert-icon { font-size: 48px; color: #c9a94e; margin-bottom: 8px; }
        .cert-pretitle {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 4px;
        }
        .cert-title {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 900;
            color: #1a1a2e;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .cert-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .cert-name {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #0d47a1;
            border-bottom: 2px solid #c9a94e;
            padding-bottom: 6px;
            margin-bottom: 16px;
            display: inline-block;
        }
        .cert-desc {
            font-size: 15px;
            color: #555;
            max-width: 600px;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        .cert-modul {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
        }
        .cert-nilai {
            font-size: 14px;
            color: #666;
            margin-top: 4px;
            margin-bottom: 24px;
        }
        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            max-width: 700px;
            margin-top: auto;
            padding-top: 20px;
        }
        .cert-footer-item {
            text-align: center;
        }
        .cert-footer-item .line {
            width: 180px;
            border-top: 1px solid #aaa;
            margin-bottom: 6px;
        }
        .cert-footer-item .label {
            font-size: 12px;
            color: #888;
        }
        .cert-footer-item .value {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }
        .stamp {
            position: absolute;
            top: -40px;
            right: 0px;
            width: 90px;
            height: 90px;
            border: 3px solid #b71c1c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b71c1c;
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 11px;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.2;
            transform: rotate(-15deg);
            opacity: 0.85;
            pointer-events: none;
        }
        .stamp::before {
            content: '';
            position: absolute;
            inset: 3px;
            border: 1px solid #b71c1c;
            border-radius: 50%;
        }
        .cert-id {
            font-size: 11px;
            color: #bbb;
            margin-top: 12px;
        }

        /* ========== PRINT STYLES ========== */
        @media print {
            body {
                background: #fff;
                padding: 0;
                margin: 0;
            }
            .print-actions { display: none !important; }
            .certificate {
                box-shadow: none;
                width: 100%;
                page-break-inside: avoid;
            }
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 960px) {
            .certificate {
                width: 100%;
                min-height: auto;
            }
            .cert-inner { padding: 30px 24px; }
            .cert-title { font-size: 28px; }
            .cert-name { font-size: 24px; }
        }
    </style>
</head>
<body>

<!-- Tombol Print & Kembali (hilang saat print) -->
<div class="print-actions">
    <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
    <a class="btn-back" href="<?php echo site_url('karyawan/sertifikat'); ?>">← Kembali</a>
</div>

<!-- SERTIFIKAT -->
<div class="certificate">
    <!-- Corner Ornaments -->
    <div class="corner-ornament tl">
        <svg viewBox="0 0 80 80"><path d="M0 0h80v4H4v76H0z"/><path d="M8 8h60v2H10v58H8z" opacity="0.5"/></svg>
    </div>
    <div class="corner-ornament tr">
        <svg viewBox="0 0 80 80"><path d="M0 0h80v4H4v76H0z"/><path d="M8 8h60v2H10v58H8z" opacity="0.5"/></svg>
    </div>
    <div class="corner-ornament bl">
        <svg viewBox="0 0 80 80"><path d="M0 0h80v4H4v76H0z"/><path d="M8 8h60v2H10v58H8z" opacity="0.5"/></svg>
    </div>
    <div class="corner-ornament br">
        <svg viewBox="0 0 80 80"><path d="M0 0h80v4H4v76H0z"/><path d="M8 8h60v2H10v58H8z" opacity="0.5"/></svg>
    </div>

    <div class="cert-inner">
        <div class="cert-icon">🏆</div>
        <div class="cert-pretitle">Elearning Corp</div>
        <div class="cert-title">SERTIFIKAT</div>
        <div class="cert-subtitle">Diberikan kepada:</div>
        <div class="cert-name"><?php echo esc($nama); ?></div>
        <div class="cert-desc">
            Atas keberhasilan menyelesaikan program pelatihan e-learning dan lulus kuis dengan hasil yang memuaskan pada modul:
        </div>
        <div class="cert-modul">"<?php echo esc($modulJudul); ?>"</div>
        <div class="cert-nilai">Nilai: <strong><?php echo esc($nilai); ?></strong> / 100</div>

        <div class="cert-footer">
            <div class="cert-footer-item">
                <div class="value"><?php echo esc($tglFormatted); ?></div>
                <div class="line"></div>
                <div class="label">Tanggal Terbit</div>
            </div>
            <div class="cert-footer-item" style="position: relative;">
                <div class="stamp">
                    Elearning<br>Corp<br>VERIFIED
                </div>
                <div class="value" style="font-family: 'Playfair Display', serif; font-size: 22px; color: #0d47a1; margin-bottom: 5px;">Elearning Corp</div>
                <div class="line"></div>
                <div class="label">Penyelenggara</div>
            </div>
        </div>

        <div class="cert-id">ID: CERT-<?php echo str_pad($sertifikatId, 6, '0', STR_PAD_LEFT); ?></div>
    </div>
</div>

</body>
</html>
