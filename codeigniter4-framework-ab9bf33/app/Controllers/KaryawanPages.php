<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\SertifikatModel;
use App\Models\SoalModel;
use App\Models\UserModel;

/**
 * Controller halaman-halaman untuk role karyawan.
 * Karyawan hanya bisa melihat data milik sendiri (filter by user_id).
 * Dilindungi oleh KaryawanFilter di routes.
 */
class KaryawanPages extends BaseController
{
    private function render(string $view, array $data = []): void
    {
        echo view('includes/header');
        echo view('includes/sidebar_karyawan', ['active' => $data['active'] ?? '']);
        echo view($view, $data);
        echo view('includes/footer');
    }

    /**
     * Lihat daftar modul (read-only, tanpa CRUD).
     */
    public function modul(): void
    {
        $modulModel = new ModulModel();
        $soalModel = new SoalModel();
        $progressModel = new ProgressModel();
        $userId = (int) session()->get('user_id');

        $modulList = $modulModel->orderBy('urutan', 'ASC')->findAll();

        // Ambil jumlah soal per modul dan progress user
        $records = [];
        foreach ($modulList as $m) {
            $jumlahSoal = $soalModel->where('modul_id', $m['id'])->countAllResults();
            $progress = $progressModel->where('user_id', $userId)->where('modul_id', $m['id'])->first();
            $status = $progress['status'] ?? 'belum_mulai';
            $nilai = $progress['nilai_kuis'] ?? '-';

            $records[] = [
                'modul_id' => $m['id'],
                'urutan' => $m['urutan'],
                'judul' => $m['judul'],
                'jumlah_soal' => $jumlahSoal,
                'status' => $status,
                'nilai' => $nilai,
            ];
        }

        $this->render('modul_karyawan', [
            'active'  => 'modul',
            'title'   => 'Modul Pelatihan',
            'message' => 'Daftar modul pelatihan yang tersedia. Klik "Mulai Kuis" untuk mengerjakan kuis.',
            'records' => $records,
        ]);
    }

    /**
     * Tampilkan halaman materi modul.
     */
    public function materi(int $modulId): void
    {
        $modulModel = new ModulModel();
        $modul = $modulModel->find($modulId);

        if (!$modul) {
            return;
        }

        $this->render('modul_materi', [
            'active' => 'modul',
            'title' => 'Materi: ' . $modul['judul'],
            'modul' => $modul,
        ]);
    }

    /**
     * Lihat progress kuis milik karyawan yang sedang login saja.
     */
    public function kuis(): void
    {
        $userId = (int) session()->get('user_id');
        $progressModel = new ProgressModel();

        $rows = $progressModel
            ->select('progress_karyawan.id, progress_karyawan.modul_id, modul_pelatihan.judul, progress_karyawan.status, progress_karyawan.nilai_kuis')
            ->join('modul_pelatihan', 'modul_pelatihan.id = progress_karyawan.modul_id', 'left')
            ->where('progress_karyawan.user_id', $userId)
            ->orderBy('progress_karyawan.id', 'ASC')
            ->findAll();

        $this->render('kuis_karyawan', [
            'active'  => 'kuis',
            'title'   => 'Kuis Saya',
            'message' => 'Progress kuis pelatihan kamu. Klik "Lihat Hasil" untuk detail.',
            'records' => $rows,
        ]);
    }

    /**
     * Tampilkan soal kuis untuk modul tertentu — form isi kuis.
     */
    public function isiKuis(int $modulId): void
    {
        $userId = (int) session()->get('user_id');
        $modulModel = new ModulModel();
        $soalModel = new SoalModel();

        $modul = $modulModel->find($modulId);
        if (!$modul) {
            return;
        }

        $soalList = $soalModel->where('modul_id', $modulId)->orderBy('id', 'ASC')->findAll();
        shuffle($soalList); // Acak urutan soal
        
        if (empty($soalList)) {
            $this->render('kuis_kosong', [
                'active' => 'kuis',
                'modul' => $modul,
            ]);
            return;
        }

        $this->render('kuis_mulai', [
            'active' => 'kuis',
            'modul' => $modul,
            'soalList' => $soalList,
        ]);
    }

    /**
     * Proses jawaban kuis, hitung nilai, simpan ke progress_karyawan.
     */
    public function submitKuis(int $modulId)
    {
        $userId = (int) session()->get('user_id');
        $soalModel = new SoalModel();
        $progressModel = new ProgressModel();
        $sertifikatModel = new SertifikatModel();

        $soalList = $soalModel->where('modul_id', $modulId)->orderBy('id', 'ASC')->findAll();
        if (empty($soalList)) {
            return redirect()->to(site_url('karyawan/modul'));
        }

        // Hitung nilai
        $benar = 0;
        $jawaban = [];
        foreach ($soalList as $soal) {
            $jawabanUser = strtolower(trim((string) $this->request->getPost('jawaban_' . $soal['id'])));
            $isBenar = $jawabanUser === $soal['jawaban_benar'];
            if ($isBenar) {
                $benar++;
            }
            $jawaban[] = [
                'soal_id' => $soal['id'],
                'jawaban_user' => $jawabanUser,
                'jawaban_benar' => $soal['jawaban_benar'],
                'is_benar' => $isBenar,
            ];
        }

        $totalSoal = count($soalList);
        $nilai = (int) round(($benar / $totalSoal) * 100);
        $lulus = $nilai >= 70;

        // Update atau insert progress
        $existingProgress = $progressModel
            ->where('user_id', $userId)
            ->where('modul_id', $modulId)
            ->first();

        $progressData = [
            'user_id' => $userId,
            'modul_id' => $modulId,
            'status' => $lulus ? 'selesai' : 'sedang_belajar',
            'nilai_kuis' => $nilai,
        ];

        if ($existingProgress) {
            $progressModel->update($existingProgress['id'], $progressData);
        } else {
            $progressModel->insert($progressData);
        }

        // Jika lulus dan belum punya sertifikat, buat sertifikat otomatis
        if ($lulus) {
            $existingSertifikat = $sertifikatModel
                ->where('user_id', $userId)
                ->where('modul_id', $modulId)
                ->first();

            if (!$existingSertifikat) {
                $sertifikatModel->insert([
                    'user_id' => $userId,
                    'modul_id' => $modulId,
                    'issued_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // Simpan jawaban di session untuk ditampilkan di hasil
        session()->setFlashdata('kuis_hasil', [
            'modul_id' => $modulId,
            'nilai' => $nilai,
            'benar' => $benar,
            'total' => $totalSoal,
            'lulus' => $lulus,
            'jawaban' => $jawaban,
            'soalList' => $soalList,
        ]);

        return redirect()->to(site_url('karyawan/kuis/hasil/' . $modulId));
    }

    /**
     * Tampilkan hasil kuis (nilai, jawaban benar/salah).
     */
    public function hasilKuis(int $modulId): void
    {
        $modulModel = new ModulModel();
        $progressModel = new ProgressModel();
        $soalModel = new SoalModel();
        $sertifikatModel = new SertifikatModel();
        $userId = (int) session()->get('user_id');

        $modul = $modulModel->find($modulId);
        if (!$modul) {
            return;
        }

        // Cek apakah ada flashdata dari submit
        $hasilFlash = session()->getFlashdata('kuis_hasil');

        if ($hasilFlash && (int) $hasilFlash['modul_id'] === $modulId) {
            // Tampilkan hasil dari submit terbaru
            $data = $hasilFlash;
        } else {
            // Tampilkan dari database (hasil terakhir)
            $progress = $progressModel
                ->where('user_id', $userId)
                ->where('modul_id', $modulId)
                ->first();

            $data = [
                'modul_id' => $modulId,
                'nilai' => $progress['nilai_kuis'] ?? 0,
                'benar' => null,
                'total' => null,
                'lulus' => ($progress['nilai_kuis'] ?? 0) >= 70,
                'jawaban' => null,
                'soalList' => null,
            ];
        }

        // Cek sertifikat
        $sertifikat = $sertifikatModel
            ->where('user_id', $userId)
            ->where('modul_id', $modulId)
            ->first();

        $this->render('kuis_hasil', [
            'active' => 'kuis',
            'modul' => $modul,
            'hasil' => $data,
            'sertifikat' => $sertifikat,
        ]);
    }

    /**
     * Lihat sertifikat milik karyawan yang sedang login saja.
     */
    public function sertifikat(): void
    {
        $userId = (int) session()->get('user_id');
        $sertifikatModel = new SertifikatModel();

        $rows = $sertifikatModel
            ->select('sertifikat.id, sertifikat.modul_id, modul_pelatihan.judul, sertifikat.issued_at')
            ->join('modul_pelatihan', 'modul_pelatihan.id = sertifikat.modul_id', 'left')
            ->where('sertifikat.user_id', $userId)
            ->orderBy('sertifikat.id', 'ASC')
            ->findAll();

        $this->render('sertifikat_karyawan', [
            'active'  => 'sertifikat',
            'title'   => 'Sertifikat Saya',
            'message' => 'Sertifikat yang sudah kamu peroleh. Klik "Print" untuk mencetak.',
            'records' => $rows,
        ]);
    }

    /**
     * Halaman sertifikat print-ready (full page, tanpa sidebar).
     */
    public function printSertifikat(int $sertifikatId): void
    {
        $userId = (int) session()->get('user_id');
        $sertifikatModel = new SertifikatModel();

        $sertifikat = $sertifikatModel
            ->select('sertifikat.*, modul_pelatihan.judul AS modul_judul, users.nama AS user_nama')
            ->join('modul_pelatihan', 'modul_pelatihan.id = sertifikat.modul_id', 'left')
            ->join('users', 'users.id = sertifikat.user_id', 'left')
            ->where('sertifikat.id', $sertifikatId)
            ->where('sertifikat.user_id', $userId)
            ->first();

        if (!$sertifikat) {
            return;
        }

        // Ambil nilai kuis dari progress
        $progressModel = new ProgressModel();
        $progress = $progressModel
            ->where('user_id', $userId)
            ->where('modul_id', $sertifikat['modul_id'])
            ->first();

        // Render tanpa sidebar — halaman khusus print
        echo view('sertifikat_print', [
            'sertifikat' => $sertifikat,
            'nilai' => $progress['nilai_kuis'] ?? '-',
        ]);
    }

    /**
     * Halaman About Us.
     */
    public function about(): void
    {
        $anggotaModel = new AnggotaModel();

        $this->render('about', [
            'active'  => 'about',
            'anggota' => $anggotaModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }
}
