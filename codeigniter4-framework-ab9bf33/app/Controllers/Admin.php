<?php

namespace App\Controllers;

use App\Models\ModulModel;
use App\Models\ProgressModel;
use App\Models\SertifikatModel;
use App\Models\SoalModel;
use App\Models\UserModel;

/**
 * Controller CRUD admin — kelola user, modul, soal kuis, progress, dan sertifikat.
 * Sudah dilindungi AdminFilter di routes, tidak perlu guard() manual.
 */
class Admin extends BaseController
{
    // ================================================================
    // CRUD USER
    // ================================================================

    public function users(int $editId = 0)
    {
        $model = new UserModel();
        $editing = $editId > 0 ? $model->find($editId) : null;

        return $this->renderCrud('Kelola User', 'users', $model, [
            'columns' => ['Nama', 'Email', 'Username', 'Role'],
            'records' => array_map(static fn(array $row): array => [
                'id' => $row['id'],
                'cells' => [$row['nama'], $row['email'] ?? '-', $row['username'], $row['role']],
            ], $model->orderBy('id', 'ASC')->findAll()),
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $editing['nama'] ?? ''],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $editing['email'] ?? ''],
                ['name' => 'username', 'label' => 'Username', 'type' => 'text', 'value' => $editing['username'] ?? ''],
                ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'value' => ''],
                ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'value' => $editing['role'] ?? 'karyawan', 'options' => ['admin' => 'admin', 'karyawan' => 'karyawan']],
            ],
            'action' => site_url('admin/users/save'),
            'editingId' => $editing['id'] ?? 0,
            'urlPrefix' => 'admin/users',
            'message' => 'Tambah, edit, atau hapus data user dari database.',
        ]);
    }

    public function saveUser()
    {
        $model = new UserModel();
        $id = (int) $this->request->getPost('id');
        $data = [
            'nama' => trim((string) $this->request->getPost('nama')),
            'email' => trim((string) $this->request->getPost('email')),
            'username' => trim((string) $this->request->getPost('username')),
            'role' => trim((string) $this->request->getPost('role')),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } elseif ($id === 0) {
            return redirect()->to(site_url('admin/users'))->with('error', 'Password wajib diisi untuk user baru.');
        }

        if ($id > 0) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to(site_url('admin/users'))->with('message', 'Data user berhasil disimpan.');
    }

    public function deleteUser(int $id)
    {
        if ($id === 1 || $id === (int) session()->get('user_id')) {
            return redirect()->to(site_url('admin/users'))->with('error', 'Tidak dapat menghapus user utama/diri sendiri.');
        }

        // Cascade delete data karyawan
        $db = \Config\Database::connect();
        $db->table('progress_karyawan')->where('user_id', $id)->delete();
        $db->table('sertifikat')->where('user_id', $id)->delete();

        (new UserModel())->delete($id);

        return redirect()->to(site_url('admin/users'))->with('message', 'Data user dan riwayat kuis berhasil dihapus.');
    }

    // ================================================================
    // CRUD MODUL
    // ================================================================

    public function modules(int $editId = 0)
    {
        $model = new ModulModel();
        $editing = $editId > 0 ? $model->find($editId) : null;

        return $this->renderCrud('Modul Pelatihan', 'modul', $model, [
            'columns' => ['Urutan', 'Judul'],
            'records' => array_map(static fn(array $row): array => [
                'id' => $row['id'],
                'cells' => [$row['urutan'], $row['judul']],
            ], $model->orderBy('urutan', 'ASC')->findAll()),
            'fields' => [
                ['name' => 'urutan', 'label' => 'Urutan', 'type' => 'number', 'value' => $editing['urutan'] ?? ''],
                ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'value' => $editing['judul'] ?? ''],
                ['name' => 'file_materi', 'label' => 'File Materi (PDF/IMG)', 'type' => 'file', 'value' => $editing['file_materi'] ?? ''],
            ],
            'action' => site_url('admin/modul/save'),
            'editingId' => $editing['id'] ?? 0,
            'urlPrefix' => 'admin/modul',
            'message' => 'Tambah, edit, atau hapus data modul dari database.',
        ]);
    }

    public function saveModule()
    {
        $model = new ModulModel();
        $id = (int) $this->request->getPost('id');
        $data = [
            'urutan' => (int) $this->request->getPost('urutan'),
            'judul' => trim((string) $this->request->getPost('judul')),
        ];

        // Proses upload file
        $file = $this->request->getFile('file_materi');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            // Folder tujuan
            $file->move(FCPATH . 'assets/uploads/materi', $newName);
            $data['file_materi'] = $newName;
        }

        if ($id > 0) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to(site_url('admin/modul'))->with('message', 'Data modul berhasil disimpan.');
    }

    public function deleteModule(int $id)
    {
        $modulModel = new ModulModel();
        $modul = $modulModel->find($id);

        if ($modul) {
            // Hapus file fisik PDF/Gambar materi jika ada
            if (!empty($modul['file_materi'])) {
                $filePath = FCPATH . 'assets/uploads/materi/' . $modul['file_materi'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data terkait (Cascade Delete)
            $db = \Config\Database::connect();
            $db->table('soal_kuis')->where('modul_id', $id)->delete();
            $db->table('progress_karyawan')->where('modul_id', $id)->delete();
            $db->table('sertifikat')->where('modul_id', $id)->delete();

            // Terakhir hapus modul itu sendiri
            $modulModel->delete($id);
        }

        return redirect()->to(site_url('admin/modul'))->with('message', 'Data modul dan semua data terkait berhasil dihapus.');
    }

    // ================================================================
    // CRUD SOAL KUIS
    // ================================================================

    public function soal(int $editId = 0)
    {
        $model = new SoalModel();
        $modulModel = new ModulModel();
        $editing = $editId > 0 ? $model->find($editId) : null;

        // Build options modul untuk dropdown
        $modulList = $modulModel->orderBy('urutan', 'ASC')->findAll();
        $modulOptions = [];
        foreach ($modulList as $m) {
            $modulOptions[$m['id']] = $m['judul'];
        }

        // Ambil filter modul dari URL (?filter_modul=1)
        $filterModul = $this->request->getGet('filter_modul');

        // Ambil daftar soal dengan join nama modul
        $query = $model
            ->select('soal_kuis.*, modul_pelatihan.judul AS modul_judul')
            ->join('modul_pelatihan', 'modul_pelatihan.id = soal_kuis.modul_id', 'left');
            
        if ($filterModul) {
            $query->where('soal_kuis.modul_id', $filterModul);
        }

        $rows = $query->orderBy('soal_kuis.modul_id', 'ASC')
            ->orderBy('soal_kuis.id', 'ASC')
            ->findAll();

        return $this->renderCrud('Soal Kuis', 'soal', $model, [
            'columns' => ['Modul', 'Pertanyaan', 'A', 'B', 'C', 'D', 'Jawaban'],
            'records' => array_map(static fn(array $row): array => [
                'id' => $row['id'],
                'cells' => [
                    $row['modul_judul'] ?? '-',
                    mb_strlen($row['pertanyaan']) > 50 ? mb_substr($row['pertanyaan'], 0, 50) . '…' : $row['pertanyaan'],
                    $row['opsi_a'],
                    $row['opsi_b'],
                    $row['opsi_c'],
                    $row['opsi_d'],
                    strtoupper($row['jawaban_benar']),
                ],
            ], $rows),
            'fields' => [
                ['name' => 'modul_id', 'label' => 'Modul', 'type' => 'select', 'value' => $editing['modul_id'] ?? ($filterModul ?: ''), 'options' => $modulOptions],
                ['name' => 'pertanyaan', 'label' => 'Pertanyaan', 'type' => 'text', 'value' => $editing['pertanyaan'] ?? ''],
                ['name' => 'opsi_a', 'label' => 'Opsi A', 'type' => 'text', 'value' => $editing['opsi_a'] ?? ''],
                ['name' => 'opsi_b', 'label' => 'Opsi B', 'type' => 'text', 'value' => $editing['opsi_b'] ?? ''],
                ['name' => 'opsi_c', 'label' => 'Opsi C', 'type' => 'text', 'value' => $editing['opsi_c'] ?? ''],
                ['name' => 'opsi_d', 'label' => 'Opsi D', 'type' => 'text', 'value' => $editing['opsi_d'] ?? ''],
                ['name' => 'jawaban_benar', 'label' => 'Jawaban Benar', 'type' => 'select', 'value' => $editing['jawaban_benar'] ?? 'a', 'options' => ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D']],
            ],
            'action' => site_url('admin/soal/save'),
            'editingId' => $editing['id'] ?? 0,
            'urlPrefix' => 'admin/soal',
            'message' => 'Tambah, edit, atau hapus soal kuis per modul.',
            'filterOptions' => [
                'name' => 'filter_modul',
                'options' => ['' => 'Semua Modul'] + $modulOptions,
                'selected' => $filterModul,
            ],
        ]);
    }

    public function saveSoal()
    {
        $model = new SoalModel();
        $id = (int) $this->request->getPost('id');
        $data = [
            'modul_id' => (int) $this->request->getPost('modul_id'),
            'pertanyaan' => trim((string) $this->request->getPost('pertanyaan')),
            'opsi_a' => trim((string) $this->request->getPost('opsi_a')),
            'opsi_b' => trim((string) $this->request->getPost('opsi_b')),
            'opsi_c' => trim((string) $this->request->getPost('opsi_c')),
            'opsi_d' => trim((string) $this->request->getPost('opsi_d')),
            'jawaban_benar' => strtolower(trim((string) $this->request->getPost('jawaban_benar'))),
        ];

        if ($id > 0) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to(site_url('admin/soal'))->with('message', 'Data soal berhasil disimpan.');
    }

    public function deleteSoal(int $id)
    {
        (new SoalModel())->delete($id);

        return redirect()->to(site_url('admin/soal'))->with('message', 'Data soal berhasil dihapus.');
    }

    // ================================================================
    // CRUD PROGRESS KARYAWAN
    // ================================================================

    public function progress(int $editId = 0)
    {
        $model = new ProgressModel();
        $userModel = new UserModel();
        $modulModel = new ModulModel();
        $editing = $editId > 0 ? $model->find($editId) : null;

        // Dropdown user (hanya karyawan)
        $userOptions = [];
        foreach ($userModel->where('role', 'karyawan')->orderBy('nama', 'ASC')->findAll() as $u) {
            $userOptions[$u['id']] = $u['nama'];
        }

        // Dropdown modul
        $modulOptions = [];
        foreach ($modulModel->orderBy('urutan', 'ASC')->findAll() as $m) {
            $modulOptions[$m['id']] = $m['judul'];
        }

        // Status options
        $statusOptions = [
            'belum_mulai' => 'Belum Mulai',
            'sedang_belajar' => 'Sedang Belajar',
            'selesai' => 'Selesai',
        ];

        $rows = $model
            ->select('progress_karyawan.*, users.nama AS user_nama, modul_pelatihan.judul AS modul_judul')
            ->join('users', 'users.id = progress_karyawan.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = progress_karyawan.modul_id', 'left')
            ->orderBy('progress_karyawan.id', 'ASC')
            ->findAll();

        return $this->renderCrud('Progress Karyawan', 'progress', $model, [
            'columns' => ['Karyawan', 'Modul', 'Status', 'Nilai Kuis'],
            'records' => array_map(static fn(array $row): array => [
                'id' => $row['id'],
                'cells' => [
                    $row['user_nama'] ?? '-',
                    $row['modul_judul'] ?? '-',
                    $statusOptions[$row['status']] ?? $row['status'],
                    $row['nilai_kuis'] ?? '-',
                ],
            ], $rows),
            'fields' => [
                ['name' => 'user_id', 'label' => 'Karyawan', 'type' => 'select', 'value' => $editing['user_id'] ?? '', 'options' => $userOptions],
                ['name' => 'modul_id', 'label' => 'Modul', 'type' => 'select', 'value' => $editing['modul_id'] ?? '', 'options' => $modulOptions],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'value' => $editing['status'] ?? 'belum_mulai', 'options' => $statusOptions],
                ['name' => 'nilai_kuis', 'label' => 'Nilai Kuis', 'type' => 'number', 'value' => $editing['nilai_kuis'] ?? ''],
            ],
            'action' => site_url('admin/progress/save'),
            'editingId' => $editing['id'] ?? 0,
            'urlPrefix' => 'admin/progress',
            'message' => 'Kelola progress belajar karyawan.',
        ]);
    }

    public function saveProgress()
    {
        $model = new ProgressModel();
        $id = (int) $this->request->getPost('id');
        $nilaiKuis = $this->request->getPost('nilai_kuis');
        $data = [
            'user_id' => (int) $this->request->getPost('user_id'),
            'modul_id' => (int) $this->request->getPost('modul_id'),
            'status' => trim((string) $this->request->getPost('status')),
            'nilai_kuis' => ($nilaiKuis !== '' && $nilaiKuis !== null) ? (int) $nilaiKuis : null,
        ];

        if ($id > 0) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to(site_url('admin/progress'))->with('message', 'Data progress berhasil disimpan.');
    }

    public function deleteProgress(int $id)
    {
        (new ProgressModel())->delete($id);

        return redirect()->to(site_url('admin/progress'))->with('message', 'Data progress berhasil dihapus.');
    }

    // ================================================================
    // CRUD SERTIFIKAT
    // ================================================================

    public function sertifikatAdmin(int $editId = 0)
    {
        $model = new SertifikatModel();
        $userModel = new UserModel();
        $modulModel = new ModulModel();
        $editing = $editId > 0 ? $model->find($editId) : null;

        // Dropdown user (hanya karyawan)
        $userOptions = [];
        foreach ($userModel->where('role', 'karyawan')->orderBy('nama', 'ASC')->findAll() as $u) {
            $userOptions[$u['id']] = $u['nama'];
        }

        // Dropdown modul
        $modulOptions = [];
        foreach ($modulModel->orderBy('urutan', 'ASC')->findAll() as $m) {
            $modulOptions[$m['id']] = $m['judul'];
        }

        $rows = $model
            ->select('sertifikat.*, users.nama AS user_nama, modul_pelatihan.judul AS modul_judul')
            ->join('users', 'users.id = sertifikat.user_id', 'left')
            ->join('modul_pelatihan', 'modul_pelatihan.id = sertifikat.modul_id', 'left')
            ->orderBy('sertifikat.id', 'ASC')
            ->findAll();

        return $this->renderCrud('Kelola Sertifikat', 'sertifikat-manage', $model, [
            'columns' => ['Karyawan', 'Modul', 'Tanggal Terbit'],
            'records' => array_map(static fn(array $row): array => [
                'id' => $row['id'],
                'cells' => [
                    $row['user_nama'] ?? '-',
                    $row['modul_judul'] ?? '-',
                    $row['issued_at'] ?? '-',
                ],
            ], $rows),
            'fields' => [
                ['name' => 'user_id', 'label' => 'Karyawan', 'type' => 'select', 'value' => $editing['user_id'] ?? '', 'options' => $userOptions],
                ['name' => 'modul_id', 'label' => 'Modul', 'type' => 'select', 'value' => $editing['modul_id'] ?? '', 'options' => $modulOptions],
                ['name' => 'issued_at', 'label' => 'Tanggal Terbit', 'type' => 'datetime-local', 'value' => $editing['issued_at'] ?? date('Y-m-d\TH:i')],
            ],
            'action' => site_url('admin/sertifikat-manage/save'),
            'editingId' => $editing['id'] ?? 0,
            'urlPrefix' => 'admin/sertifikat-manage',
            'message' => 'Kelola sertifikat yang diterbitkan untuk karyawan.',
        ]);
    }

    public function saveSertifikat()
    {
        $model = new SertifikatModel();
        $id = (int) $this->request->getPost('id');
        $issuedAt = $this->request->getPost('issued_at');
        // Convert datetime-local format (Y-m-d\TH:i) to DB format
        $issuedAt = str_replace('T', ' ', $issuedAt);
        if (strlen($issuedAt) === 16) {
            $issuedAt .= ':00'; // add seconds
        }

        $data = [
            'user_id' => (int) $this->request->getPost('user_id'),
            'modul_id' => (int) $this->request->getPost('modul_id'),
            'issued_at' => $issuedAt,
        ];

        if ($id > 0) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to(site_url('admin/sertifikat-manage'))->with('message', 'Data sertifikat berhasil disimpan.');
    }

    public function deleteSertifikat(int $id)
    {
        (new SertifikatModel())->delete($id);

        return redirect()->to(site_url('admin/sertifikat-manage'))->with('message', 'Data sertifikat berhasil dihapus.');
    }

    // ================================================================
    // HELPER: Render layout CRUD
    // ================================================================

    private function renderCrud(string $title, string $active, $model, array $data)
    {
        echo view('includes/header');
        echo view('includes/sidebar_admin', ['active' => $active]);
        echo view('crud_manager', array_merge($data, [
            'title' => $title,
            'message' => $data['message'] ?? '',
        ]));
        echo view('includes/footer');
    }
}