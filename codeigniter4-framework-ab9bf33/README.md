# E-Learning Pelatihan Karyawan Industri 4.0 🚀

Aplikasi Web **E-Learning Pelatihan Karyawan** ini adalah platform edukasi interaktif yang dikhususkan untuk pelatihan di era Industri 4.0. Dibangun menggunakan framework **CodeIgniter 4**, aplikasi ini memfasilitasi perusahaan dalam memberikan modul materi, menguji pemahaman lewat kuis, melacak progress belajar, serta memberikan sertifikat digital kelulusan secara otomatis.

---

## ✨ Fitur Utama

- **Role-based Access Control (RBAC)**
  - **Admin**: Akses penuh untuk manajemen pengguna, modul pelatihan, pembuatan dan pengelolaan bank soal kuis, melihat progress belajar karyawan, serta mengelola sertifikat kelulusan.
  - **Karyawan**: Membaca modul pelatihan, mengerjakan kuis, melihat hasil/nilai kuis, serta mencetak sertifikat digital jika mencapai passing grade (nilai ≥ 70).
- **Materi Modul Dinamis**: Admin dapat mengunggah file **PDF atau Gambar** secara langsung sebagai materi pelatihan, yang akan dirender secara interaktif (embed) di layar karyawan.
- **Manajemen Kuis Lanjutan**:
  - Karyawan dapat menjawab kuis pilihan ganda yang dinilai secara otomatis.
  - **Pengacakan Soal (Randomizer)**: Urutan soal dan opsi jawaban (A, B, C, D) diacak secara otomatis setiap kali kuis dimulai.
  - **Timer Kuis 10 Menit**: Kuis dibatasi oleh waktu. Jika waktu habis, form jawaban akan otomatis dikirim (Auto-Submit).
- **Dashboard Statistik & Chart**: Admin memiliki halaman dashboard interaktif yang menampilkan **Chart.js (Doughnut Chart)** untuk memonitor status belajar karyawan (Selesai, Sedang Belajar, Belum Mulai).
- **Sertifikat Digital**: Format sertifikat elegan siap cetak (Print/PDF) bagi karyawan yang lulus modul.
- **Export Laporan (CSV/Excel)**: Admin dapat mengunduh seluruh data riwayat nilai kuis dan daftar penerima sertifikat dalam format CSV yang bisa diolah di Microsoft Excel.
- **Interaktif UI/UX**: Menggunakan Bootstrap 5, dilengkapi sistem notifikasi _modern popup_ menggunakan SweetAlert2, serta fitur **Sidebar Collapse** yang responsif.
- **REST API Terintegrasi**: Menyediakan endpoint API untuk akses dan sinkronisasi data (CRUD) dari sistem eksternal.

---

## 👨‍💻 Tim Pengembang

Aplikasi ini dikembangkan dan dirancang oleh:

1. **Muhammad Sidik Permana** (NIM: 2350081027)
   _Fullstack Developer & UI/UX Designer_

---

## 🛠️ Persyaratan Sistem (Requirements)

Sebelum melakukan instalasi, pastikan sistem kamu memenuhi kriteria berikut:

- **PHP** versi 7.4 atau lebih baru (direkomendasikan PHP 8.x)
- **MySQL** / MariaDB
- Web Server (Apache/XAMPP, Nginx, dsb)
- **Composer** (opsional jika dependensi sudah terunduh)

---

## 🚀 Cara Instalasi (Local Development)

Berikut adalah langkah-langkah untuk menjalankan aplikasi ini di komputer/lokal:

### 1. Clone Repository

Clone atau unduh _source code_ dari repositori GitHub ini.

```bash
git clone https://github.com/username-kamu/elearning-ci4.git
cd elearning-ci4
```

### 2. Setup Database

1. Buka aplikasi XAMPP, pastikan modul **Apache** dan **MySQL** dalam keadaan _Start_.
2. Buka browser dan akses **phpMyAdmin** (`http://localhost/phpmyadmin`).
3. Buat database baru, misalnya dengan nama `ci4`.
4. Import file SQL yang berada di dalam folder proyek ini: `database/ci4.sql` ke dalam database yang baru dibuat.

### 3. Konfigurasi Sistem

1. Ubah nama file `env` (jika ada) menjadi `.env`.
2. Sesuaikan konfigurasi koneksi database, atau jika kamu tidak menggunakan `.env`, pastikan kamu mengatur koneksinya di `app/Config/Database.php`:
   ```php
   public $default = [
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'ci4',
       'DBDriver' => 'MySQLi',
       // ...
   ];
   ```

### 4. Jalankan Aplikasi

Buka terminal/CMD di dalam direktori proyek, lalu jalankan server bawaan CodeIgniter:

```bash
php spark serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat:
**[http://localhost:8080](http://localhost:8080)**

---

## 🔑 Akun Demo (Login)

Setelah instalasi selesai, kamu bisa mencoba aplikasi menggunakan akun demo berikut:

| Role     | Username | Password |
| -------- | -------- | -------- |
| Admin    | `sidik`  | `123456` |
| Karyawan | `yuda`   | `123456` |

---

## 📁 Struktur Direktori Penting

- `/app` : Berisi _Controller_, _Model_, dan _Views_ inti aplikasi.
- `/public` : Aset statis seperti CSS, gambar (`assets/img`), dan _entry point_ (`index.php`).
- `/database` : Menyimpan skema database mentah SQL (`ci4.sql`) untuk _deployment_.

---

_Made with ❤️ for Industry 4.0 Web Application Solutions._
