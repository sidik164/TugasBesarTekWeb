<?php

namespace App\Controllers;

use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\SertifikatModel;
use App\Models\UserModel;

/**
 * Controller dashboard khusus admin.
 * Menampilkan statistik keseluruhan pelatihan.
 * Dilindungi oleh AdminFilter di routes.
 */
class AdminDashboard extends BaseController
{
    public function index()
    {
        $nama = session()->get('nama') ?? 'Admin';

        $userModel = new UserModel();
        $modulModel = new ModulModel();
        $progressModel = new ProgressModel();
        $sertifikatModel = new SertifikatModel();

        $totalProgress = $progressModel->countAllResults();
        $selesaiProgress = $progressModel->where('status', 'selesai')->countAllResults();
        $completionRate = $totalProgress > 0 ? (int) round(($selesaiProgress / $totalProgress) * 100) : 0;

        $belumMulai = $progressModel->where('status', 'belum_mulai')->countAllResults();
        $sedangBelajar = $progressModel->where('status', 'sedang_belajar')->countAllResults();

        $data = [
            'nama'           => $nama,
            'totalKaryawan'  => $userModel->where('role', 'karyawan')->countAllResults(),
            'totalModul'     => $modulModel->countAllResults(),
            'completionRate' => $completionRate,
            'totalSertifikat'=> $sertifikatModel->countAllResults(),
            'chartData'      => [$selesaiProgress, $sedangBelajar, $belumMulai]
        ];

        echo view('includes/header');
        echo view('includes/sidebar_admin', ['active' => 'dashboard']);
        echo view('dashboard_admin', $data);
        echo view('includes/footer');
    }
}
