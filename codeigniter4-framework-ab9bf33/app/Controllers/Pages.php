<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\SertifikatModel;
use App\Models\UserModel;

/**
 * Controller halaman-halaman untuk role admin.
 * Menampilkan data SEMUA user (bukan per user_id).
 * Dilindungi oleh AdminFilter di routes.
 */
class Pages extends BaseController
{
    private function render(string $view, array $data = []): void
    {
        echo view('includes/header');
        echo view('includes/sidebar_admin', ['active' => $data['active'] ?? '']);
        echo view($view, $data);
        echo view('includes/footer');
    }

    public function about(): void
    {
        $anggotaModel = new AnggotaModel();

        $this->render('about', [
            'active' => 'about',
            'anggota' => $anggotaModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function kuis(): void
    {
        $progressModel = new ProgressModel();

        $rows = $progressModel
            ->select('progress_karyawan.id, users.nama, modul_pelatihan.judul, progress_karyawan.status, progress_karyawan.nilai_kuis')
            ->join('users', 'users.id = progress_karyawan.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = progress_karyawan.modul_id', 'left')
            ->orderBy('progress_karyawan.id', 'ASC')
            ->findAll();

        $this->render('database_table', [
            'active' => 'kuis',
            'title' => 'Kuis (Semua Karyawan)',
            'message' => 'Data progress kuis seluruh karyawan.',
            'columns' => ['Nama', 'Modul', 'Status', 'Nilai'],
            'records' => array_map(static fn(array $row): array => [
                $row['nama'] ?? '-',
                $row['judul'] ?? '-',
                $row['status'] ?? '-',
                $row['nilai_kuis'] ?? '-',
            ], $rows),
            'exportUrl' => site_url('admin/kuis/export')
        ]);
    }

    public function sertifikat(): void
    {
        $sertifikatModel = new SertifikatModel();

        $rows = $sertifikatModel
            ->select('sertifikat.id, users.nama, modul_pelatihan.judul, sertifikat.issued_at')
            ->join('users', 'users.id = sertifikat.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = sertifikat.modul_id', 'left')
            ->orderBy('sertifikat.id', 'ASC')
            ->findAll();

        $this->render('database_table', [
            'active' => 'sertifikat',
            'title' => 'Sertifikat (Semua Karyawan)',
            'message' => 'Data sertifikat seluruh karyawan.',
            'columns' => ['Nama', 'Modul', 'Tanggal Terbit'],
            'records' => array_map(static fn(array $row): array => [
                $row['nama'] ?? '-',
                $row['judul'] ?? '-',
                $row['issued_at'] ?? '-',
            ], $rows),
            'exportUrl' => site_url('admin/sertifikat/export')
        ]);
    }

    public function apiDocs(): void
    {
        $this->render('api_docs', [
            'active' => 'api-docs',
        ]);
    }

    public function exportKuis(): void
    {
        $progressModel = new ProgressModel();
        $rows = $progressModel
            ->select('progress_karyawan.id, users.nama, modul_pelatihan.judul, progress_karyawan.status, progress_karyawan.nilai_kuis')
            ->join('users', 'users.id = progress_karyawan.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = progress_karyawan.modul_id', 'left')
            ->orderBy('progress_karyawan.id', 'ASC')
            ->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Laporan_Nilai_Kuis.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nama Karyawan', 'Modul', 'Status', 'Nilai Kuis']);
        
        foreach ($rows as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nama'] ?? '-',
                $row['judul'] ?? '-',
                $row['status'] ?? '-',
                $row['nilai_kuis'] ?? '-'
            ]);
        }
        fclose($output);
        exit;
    }

    public function exportSertifikat(): void
    {
        $sertifikatModel = new SertifikatModel();
        $rows = $sertifikatModel
            ->select('sertifikat.id, users.nama, modul_pelatihan.judul, sertifikat.issued_at')
            ->join('users', 'users.id = sertifikat.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = sertifikat.modul_id', 'left')
            ->orderBy('sertifikat.id', 'ASC')
            ->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Laporan_Sertifikat.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Nama Karyawan', 'Modul', 'Tanggal Terbit']);
        
        foreach ($rows as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nama'] ?? '-',
                $row['judul'] ?? '-',
                $row['issued_at'] ?? '-'
            ]);
        }
        fclose($output);
        exit;
    }
}