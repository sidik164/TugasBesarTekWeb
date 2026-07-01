<?php

namespace App\Controllers;

use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\SertifikatModel;

/**
 * Controller dashboard khusus karyawan.
 * Menampilkan progress belajar pribadi karyawan.
 * Dilindungi oleh KaryawanFilter di routes.
 */
class KaryawanDashboard extends BaseController
{
    public function index()
    {
        $nama = session()->get('nama') ?? 'Karyawan';
        $userId = (int) (session()->get('user_id') ?? 0);

        $modulModel = new ModulModel();
        $progressModel = new ProgressModel();
        $sertifikatModel = new SertifikatModel();
        $db = db_connect();

        // Ambil daftar modul beserta progress karyawan ini
        $daftarModul = $db->table('modul_pelatihan m')
            ->select('m.id, m.judul, m.urutan, p.status, p.nilai_kuis')
            ->join('progress_karyawan p', 'p.modul_id = m.id AND p.user_id = ' . $userId, 'left')
            ->orderBy('m.urutan', 'ASC')
            ->get()
            ->getResultArray();

        $totalModulKaryawan = count($daftarModul);
        $modulSelesai = count(array_filter($daftarModul, static fn(array $modul): bool => ($modul['status'] ?? '') === 'selesai'));

        $nilai = array_values(array_filter(array_map(static fn(array $modul) => $modul['nilai_kuis'] ?? null, $daftarModul), static fn($nilai) => $nilai !== null));
        $rataNilai = count($nilai) > 0 ? (int) round(array_sum($nilai) / count($nilai)) : 0;

        $data = [
            'nama'                    => $nama,
            'totalModulKaryawan'      => $totalModulKaryawan,
            'modulSelesai'            => $modulSelesai,
            'rataNilai'               => $rataNilai,
            'totalSertifikatKaryawan' => $sertifikatModel->where('user_id', $userId)->countAllResults(),
            'daftarModul'             => $daftarModul,
        ];

        echo view('includes/header');
        echo view('includes/sidebar_karyawan', ['active' => 'dashboard']);
        echo view('dashboard_karyawan', $data);
        echo view('includes/footer');
    }
}
