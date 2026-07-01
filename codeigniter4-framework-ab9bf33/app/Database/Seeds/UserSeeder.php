<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('progress_karyawan')->truncate();
        $this->db->table('sertifikat')->truncate();
        $this->db->table('anggota')->truncate();
        $this->db->table('modul_pelatihan')->truncate();
        $this->db->table('users')->truncate();

        $this->db->table('users')->insertBatch([
            [
                'nama' => 'Demo User',
                'email' => 'admin@elearning.local',
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Karyawan Demo',
                'email' => 'karyawan@elearning.local',
                'username' => 'karyawan',
                'password' => password_hash('karyawan123', PASSWORD_DEFAULT),
                'role' => 'karyawan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Admin HR',
                'email' => 'hr@elearning.local',
                'username' => 'hr',
                'password' => password_hash('hr123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Sidik',
                'email' => 'sidik@gmail.com',
                'username' => 'sidik',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'karyawan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->db->table('modul_pelatihan')->insertBatch([
            ['judul' => 'Keselamatan Kerja Industri 4.0', 'urutan' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['judul' => 'Dasar Digital Manufacturing', 'urutan' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['judul' => 'Pemanfaatan IoT di Pabrik', 'urutan' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('anggota')->insertBatch([
            ['nama' => 'Muhammad Sidik Permana', 'nim' => '2350081027', 'peran' => 'Frontend Developer, Database & UI/UX Designer', 'foto' => 'assets/img/Sidik.jpeg', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Nama Anggota 2', 'nim' => '23500810', 'peran' => 'Backend Developer & UI/UX Designer', 'foto' => 'assets/img/s.jpeg', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('progress_karyawan')->insertBatch([
            ['user_id' => 2, 'modul_id' => 1, 'status' => 'selesai', 'nilai_kuis' => 90, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'modul_id' => 2, 'status' => 'sedang_belajar', 'nilai_kuis' => 75, 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 2, 'modul_id' => 3, 'status' => 'belum_mulai', 'nilai_kuis' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('sertifikat')->insertBatch([
            ['user_id' => 2, 'modul_id' => 1, 'issued_at' => $now, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}