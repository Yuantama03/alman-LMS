# Use Case Diagram - SIAK (Sistem Informasi Akademik)

## Deskripsi Sistem
Sistem Informasi Akademik untuk sekolah yang mengelola data akademik siswa, guru, dan administrasi sekolah.

---

## ACTORS (Pengguna Sistem)

### 1. **Admin** (Administrator Sekolah)
   - Memiliki hak akses penuh untuk mengelola seluruh sistem
   - Bertanggung jawab atas data master dan konfigurasi sistem

### 2. **Guru** (Pengajar)
   - Dapat mengelola materi pembelajaran dan tugas
   - Melakukan penilaian dan presensi siswa

### 3. **Siswa** (Pelajar)
   - Dapat mengakses materi pembelajaran dan tugas
   - Mengumpulkan jawaban tugas dan melihat nilai

---


## KETERANGAN WARNA DIAGRAM

- **Kuning** (`#fff2cc`) - Use Case utama yang shared (Login, Profile, Password)
- **Biru** (`#dae8fc`) - Use Case khusus Admin
- **Hijau** (`#d5e8d4`) - Use Case khusus Guru  
- **Orange** (`#ffe6cc`) - Use Case khusus Siswa
- **Ungu Muda** (`#e1d5e7`) - Supporting Use Case (Include/Extend) dengan border dashed

---

## DETAIL USE CASE DENGAN RELATIONSHIP

### 📝 Authentication & Profile (Shared)

#### 1. **Login** (Main)
- **Actor:** Semua (Admin, Guru, Siswa)
- **<<include>>** Validasi Kredensial - Cek username & password di database
- **<<extend>>** Lupa Password - Reset password via email (opsional)

#### 2. **Kelola Profile** (Main)
- **Actor:** Semua (Admin, Guru, Siswa)
- **<<extend>>** Upload Foto Profile - Update foto profil (opsional)

#### 3. **Ubah Password** (Main)
- **Actor:** Semua (Admin, Guru, Siswa)
- **<<include>>** Validasi Password Lama - Harus input password lama yang benar

---

### 🔵 ADMIN Use Cases

#### Data Master
4. **Kelola Data Guru** - **<<include>>** Validasi Hak Akses
5. **Kelola Data Siswa** - **<<include>>** Validasi Hak Akses
6. **Kelola Kelas**
7. **Kelola Mata Pelajaran** - **<<extend>>** Export Data (ke Excel/PDF)
8. **Kelola Jadwal** - **<<extend>>** Export Data
9. **Kelola Semester**
10. **Kelola Silabus**
11. **Kelola User** - **<<extend>>** Import Data (import dari Excel)
12. **Kelola Pengumuman**
13. **Kelola Pengaturan**

#### Monitoring
14. **Lihat Presensi** - Monitoring kehadiran semua siswa
15. **Lihat Poin Siswa** - Monitoring poin pelanggaran/prestasi
16. **Lihat Tugas** - Monitoring tugas semua guru

---

### 🟢 GURU Use Cases

#### Pembelajaran
17. **Kelola Materi**
    - **<<include>>** Upload File - Upload materi PDF/PPT/Video
    - Upload File **<<include>>** Validasi File - Cek ukuran max 50MB, tipe file

18. **Kelola Tugas**
    - **<<include>>** Upload File - Upload soal tugas
    - **<<extend>>** Kirim Notifikasi ke Siswa - Push notification (opsional)

19. **Input Nilai Tugas** - Beri nilai pada jawaban siswa

20. **Download Jawaban** - Download file jawaban dari siswa

#### Monitoring
21. **Kelola Presensi**
    - Input presensi harian
    - **<<extend>>** Cetak Laporan Presensi - Export ke PDF

22. **Kelola Poin Siswa** - Input poin pelanggaran atau prestasi

23. **Lihat Kalender Akademik** - Lihat jadwal kegiatan sekolah

---

### 🟠 SISWA Use Cases

#### Pembelajaran
24. **Lihat Materi** - Browse materi yang di-upload guru

25. **Download Materi**
    - **<<include>>** Cek Akses File - Validasi apakah siswa boleh akses

26. **Lihat Tugas**
    - **<<extend>>** Cek Deadline Tugas - Lihat waktu tersisa

27. **Download Tugas**
    - **<<include>>** Cek Akses File - Validasi akses

28. **Kirim Jawaban Tugas**
    - **<<include>>** Upload File Jawaban
    - Upload Jawaban **<<include>>** Validasi File - Cek format & ukuran

29. **Lihat Nilai Tugas** - Lihat nilai yang sudah di-input guru

#### Monitoring
30. **Lihat Presensi** - Lihat riwayat kehadiran sendiri

31. **Lihat Poin** - Lihat poin pelanggaran/prestasi sendiri

32. **Lihat Kalender Akademik** - Lihat jadwal kegiatan sekolah

---

## USE CASES PER ROLE (Sebelumnya)

### 🔵 ROLE: ADMIN

#### A. Fungsi Umum (Shared)
1. **Login** - Masuk ke sistem
2. **Kelola Profile** - Mengubah data profil pribadi
3. **Ubah Password** - Mengganti password akun

#### B. Fungsi Khusus Admin
4. **Dashboard Admin** - Melihat ringkasan data sistem
5. **Kelola Data Guru** - CRUD (Create, Read, Update, Delete) data guru
6. **Kelola Data Siswa** - CRUD data siswa
7. **Kelola Kelas** - CRUD data kelas
8. **Kelola Mata Pelajaran** - CRUD data mata pelajaran
9. **Kelola Jadwal** - CRUD jadwal pelajaran
10. **Kelola Semester** - CRUD data semester akademik
11. **Kelola Silabus** - CRUD silabus pembelajaran
12. **Kelola User** - CRUD akun pengguna sistem
13. **Kelola Pengumuman** - CRUD pengumuman sekolah
14. **Kelola Pengaturan** - Mengatur konfigurasi sistem
15. **Lihat Presensi** - Monitoring presensi siswa
16. **Lihat Poin Siswa** - Monitoring poin pelanggaran/prestasi siswa
17. **Lihat Tugas** - Monitoring tugas yang diberikan guru

#### Flow Admin:
```
Login → Dashboard Admin → Pilih Menu Manajemen
├── Data Master (Guru, Siswa, Kelas, Mapel)
├── Akademik (Jadwal, Semester, Silabus)
├── User & Pengaturan
└── Monitoring (Presensi, Poin, Tugas)
```

---

### 🟢 ROLE: GURU

#### A. Fungsi Umum (Shared)
1. **Login** - Masuk ke sistem
2. **Kelola Profile** - Mengubah data profil pribadi
3. **Ubah Password** - Mengganti password akun

#### B. Fungsi Khusus Guru
4. **Dashboard Guru** - Melihat ringkasan kegiatan mengajar
5. **Kelola Materi** - CRUD materi pembelajaran (upload/delete file)
6. **Kelola Tugas** - CRUD tugas untuk siswa
7. **Input Nilai Tugas** - Memberikan nilai pada jawaban siswa
8. **Download Jawaban** - Mengunduh file jawaban siswa
9. **Kelola Presensi** - Input dan kelola data presensi siswa
10. **Kelola Poin Siswa** - Input poin pelanggaran/prestasi siswa
11. **Lihat Kalender Akademik** - Melihat jadwal akademik sekolah

#### Flow Guru:
```
Login → Dashboard Guru → Pilih Aktivitas
├── Pembelajaran
│   ├── Upload Materi
│   ├── Buat Tugas
│   └── Lihat Kalender Akademik
├── Penilaian
│   ├── Download Jawaban Siswa
│   └── Input Nilai Tugas
└── Monitoring
    ├── Input Presensi
    └── Input Poin Siswa
```

---

### 🟠 ROLE: SISWA

#### A. Fungsi Umum (Shared)
1. **Login** - Masuk ke sistem
2. **Kelola Profile** - Mengubah data profil pribadi
3. **Ubah Password** - Mengganti password akun

#### B. Fungsi Khusus Siswa
4. **Dashboard Siswa** - Melihat ringkasan aktivitas belajar
5. **Lihat Materi** - Melihat materi pembelajaran dari guru
6. **Download Materi** - Mengunduh file materi pembelajaran
7. **Lihat Tugas** - Melihat daftar tugas yang diberikan
8. **Download Tugas** - Mengunduh file tugas
9. **Kirim Jawaban Tugas** - Upload file jawaban tugas
10. **Lihat Presensi** - Melihat riwayat kehadiran
11. **Lihat Poin** - Melihat poin pelanggaran/prestasi
12. **Lihat Kalender Akademik** - Melihat jadwal akademik sekolah

#### Flow Siswa:
```
Login → Dashboard Siswa → Pilih Aktivitas
├── Pembelajaran
│   ├── Lihat & Download Materi
│   ├── Lihat & Download Tugas
│   ├── Kirim Jawaban Tugas
│   └── Lihat Kalender Akademik
└── Monitoring Diri
    ├── Lihat Presensi
    └── Lihat Poin
```

---

## ALUR INTERAKSI ANTAR ROLE

### 📚 Skenario 1: Pembelajaran Online
```
1. Admin → Membuat Data Guru & Siswa → Membuat Kelas & Jadwal
2. Guru → Upload Materi & Buat Tugas
3. Siswa → Download Materi → Kerjakan Tugas → Upload Jawaban
4. Guru → Download Jawaban → Beri Nilai
5. Admin → Monitoring seluruh aktivitas
```

### 📊 Skenario 2: Presensi & Poin
```
1. Admin → Setup Semester & Kelas
2. Guru → Input Presensi Harian → Input Poin Siswa
3. Siswa → Lihat Presensi & Poin sendiri
4. Admin → Monitoring Presensi & Poin semua siswa
```

### 📢 Skenario 3: Pengumuman
```
1. Admin → Buat Pengumuman Sekolah
2. Guru & Siswa → Lihat Pengumuman di Dashboard
```

---

## KETERANGAN WARNA DIAGRAM (Sebelumnya)

- **Kuning** (`#fff2cc`) - Use Case umum (Login, Profile, Password)
- **Biru** (`#dae8fc`) - Use Case khusus Admin
- **Hijau** (`#d5e8d4`) - Use Case khusus Guru  
- **Orange** (`#ffe6cc`) - Use Case khusus Siswa

---

## CARA MEMBUKA DIAGRAM

1. Buka file `Use-Case-Diagram-SIAK.drawio`
2. Import ke:
   - **draw.io** (https://app.diagrams.net/)
   - **VS Code** dengan extension "Draw.io Integration"
   - **Desktop App** draw.io

3. Diagram akan menampilkan visualisasi lengkap use case dengan:
   - 3 Actor (Admin di kiri atas, Guru di kanan tengah, Siswa di kiri bawah)
   - Semua use case terorganisir per role dengan warna berbeda
   - **Relationship <<include>>** untuk use case wajib (garis putus-putus)
   - **Relationship <<extend>>** untuk use case opsional (garis putus-putus)
   - **Association** antara actor dengan use case (garis solid)
   - System boundary untuk SIAK

---

## KEUNGGULAN DIAGRAM INI

✅ **Mengikuti Standar UML** - Include, Extend, Association sesuai aturan
✅ **Layout Profesional** - Actor tersebar, tidak menumpuk di satu sisi
✅ **Supporting Use Cases** - Menampilkan validasi, upload, download, dll
✅ **Mudah Dipahami** - Warna berbeda per role, grouping yang jelas
✅ **Lengkap** - Mencakup semua fitur sistem SIAK
✅ **Scalable** - Mudah ditambahkan use case baru

---

## CATATAN TEKNIS

File diagram menggunakan format XML draw.io standar yang dapat:
- Diedit secara visual
- Diekspor ke PNG, JPG, PDF, SVG
- Diintegrasikan dengan dokumentasi proyek
- Digunakan untuk presentasi stakeholder

**Dibuat:** 30 Desember 2025  
**Sistem:** SIAK - Sistem Informasi Akademik  
**Teknologi:** Laravel Framework
