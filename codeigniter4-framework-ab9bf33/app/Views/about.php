<?php
// ============================================================
// FILE about.php
// Halaman "About us" berisi daftar anggota kelompok + profil.
// Sesuai spek tugas: wajib ada halaman ini.
// Data anggota sekarang diambil dari database agar sinkron dengan halaman lain.
// ============================================================

$active = 'about';
?>

<style>
    .about-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .about-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }
    .about-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        z-index: 1;
    }
    .profile-img-container {
        position: relative;
        z-index: 2;
        margin-top: 50px;
        margin-bottom: 20px;
    }
    .profile-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 10px 25px rgba(78, 115, 223, 0.2);
        background-color: #fff;
    }
    .avatar-placeholder {
        width: 140px;
        height: 140px;
        line-height: 130px;
        font-size: 3rem;
        background: #fff;
        color: #4e73df;
        border: 5px solid #fff;
        box-shadow: 0 10px 25px rgba(78, 115, 223, 0.2);
    }
    .badge-soft {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
        font-weight: 600;
        padding: 0.5em 1em;
        border-radius: 50rem;
    }
    .btn-social {
        transition: all 0.2s ease;
    }
    .btn-social:hover {
        transform: scale(1.05);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold text-dark">Profil Pengembang</h4>
        <p class="text-muted mb-0">Di balik layar pengembangan aplikasi E-Learning Industri 4.0.</p>
    </div>
</div>

<div class="row justify-content-center g-4">
<?php foreach (($anggota ?? []) as $a): ?>
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card about-card text-center p-4">
            
            <div class="profile-img-container">
                <?php if (!empty($a['foto'])): ?>
                    <img src="<?php echo base_url(esc($a['foto'])); ?>" alt="<?php echo esc($a['nama']); ?>" class="rounded-circle profile-img">
                <?php else: ?>
                    <?php
                    $namaLengkap = trim((string) ($a['nama'] ?? ''));
                    $parts = preg_split('/\s+/', $namaLengkap) ?: [];
                    $initials = '';
                    foreach (array_slice($parts, 0, 2) as $part) {
                        $initials .= mb_substr($part, 0, 1);
                    }
                    ?>
                    <div class="rounded-circle mx-auto avatar-placeholder fw-bold"><?php echo esc($initials ?: 'U'); ?></div>
                <?php endif; ?>
            </div>
            
            <h4 class="fw-bolder text-dark mb-2" style="position: relative; z-index: 2;"><?php echo esc($a['nama']); ?></h4>
            <div class="d-flex justify-content-center gap-2 mb-3" style="position: relative; z-index: 2;">
                <span class="badge badge-soft border border-primary border-opacity-25">NIM: <?php echo esc($a['nim']); ?></span>
                <span class="badge bg-dark rounded-pill px-3 py-2 shadow-sm d-flex align-items-center"><?php echo esc($a['peran']); ?></span>
            </div>
            
            <hr class="w-75 mx-auto my-4 text-muted" style="opacity: 0.1;">
            
            <div class="text-secondary text-start px-md-4" style="line-height: 1.8; text-align: justify !important; font-size: 1.05rem;">
                <p>
                    Halo! Saya adalah mahasiswa program studi <strong>Teknik Informatika</strong> di <strong>Fakultas Sains dan Informatika, Universitas Jenderal Achmad Yani (UNJANI)</strong>. Lahir dan besar di Garut sebagai anak pertama dari tiga bersaudara, saya merupakan alumni kebanggaan <strong>SMAN 1 Garut (SMANSA)</strong>.
                </p>
                <p class="mb-0">
                    Saya memiliki ketertarikan dan <em>passion</em> yang kuat di dunia teknologi dan rekayasa perangkat lunak. Saat ini, saya memfokuskan diri dalam bidang <strong>Fullstack Web Development</strong> dan <strong>UI/UX Design</strong>, dengan tujuan menciptakan produk digital yang tidak hanya canggih secara fungsional, tetapi juga elegan, modern, dan memberikan pengalaman pengguna (<em>User Experience</em>) yang memukau.
                </p>
            </div>
            
            <div class="mt-5 pt-3 border-top d-flex justify-content-center gap-3">
                <a href="mailto:muhammadsidik2210@gmail.com" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-semibold btn-social d-flex align-items-center gap-2">
                    <i class="bi bi-envelope-fill fs-5"></i> Email
                </a>
                <a href="https://www.instagram.com/muhmmdsidiik_/" target="_blank" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold btn-social d-flex align-items-center gap-2">
                    <i class="bi bi-instagram fs-5"></i> Instagram
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>