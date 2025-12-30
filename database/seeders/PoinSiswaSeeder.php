<?php

namespace Database\Seeders;

use App\Models\PoinSiswa;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PoinSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswa = Siswa::all();
        $adminUser = User::where('roles', 'admin')->first();
        $guruUser = User::where('roles', 'guru')->first();
        
        if ($siswa->isEmpty() || !$adminUser) {
            $this->command->info('Tidak ada data siswa atau admin untuk membuat poin. Jalankan seeder siswa terlebih dahulu.');
            return;
        }

        $creator = $guruUser ?? $adminUser;
        
        $prestasi = [
            ['kategori' => 'Juara 1 Olimpiade Matematika', 'poin' => 100, 'deskripsi' => 'Meraih juara 1 Olimpiade Matematika tingkat kabupaten'],
            ['kategori' => 'Juara 2 Lomba Bahasa Inggris', 'poin' => 80, 'deskripsi' => 'Meraih juara 2 lomba pidato Bahasa Inggris'],
            ['kategori' => 'Juara 3 Lomba Puisi', 'poin' => 60, 'deskripsi' => 'Meraih juara 3 lomba baca puisi tingkat sekolah'],
            ['kategori' => 'Siswa Teladan', 'poin' => 50, 'deskripsi' => 'Terpilih sebagai siswa teladan bulan ini'],
            ['kategori' => 'Prestasi Olahraga', 'poin' => 70, 'deskripsi' => 'Juara 1 lomba lari 100m antar sekolah'],
            ['kategori' => 'Piket Terbaik', 'poin' => 20, 'deskripsi' => 'Melakukan piket dengan sangat baik dan bersih'],
            ['kategori' => 'Bantuan Kegiatan Sekolah', 'poin' => 30, 'deskripsi' => 'Membantu kelancaran acara sekolah'],
            ['kategori' => 'Peningkatan Nilai', 'poin' => 40, 'deskripsi' => 'Meningkatkan nilai rata-rata kelas secara signifikan'],
        ];

        $pelanggaran = [
            ['kategori' => 'Terlambat', 'poin' => 10, 'deskripsi' => 'Datang terlambat ke sekolah tanpa keterangan'],
            ['kategori' => 'Tidak Mengerjakan PR', 'poin' => 15, 'deskripsi' => 'Tidak mengerjakan pekerjaan rumah yang diberikan'],
            ['kategori' => 'Tidak Memakai Seragam Lengkap', 'poin' => 20, 'deskripsi' => 'Tidak memakai atribut seragam lengkap'],
            ['kategori' => 'Ribut di Kelas', 'poin' => 25, 'deskripsi' => 'Membuat kegaduhan saat pembelajaran berlangsung'],
            ['kategori' => 'Membolos', 'poin' => 50, 'deskripsi' => 'Tidak masuk tanpa keterangan yang jelas'],
            ['kategori' => 'Tidak Mengikuti Upacara', 'poin' => 30, 'deskripsi' => 'Tidak mengikuti upacara bendera tanpa izin'],
            ['kategori' => 'Merokok', 'poin' => 100, 'deskripsi' => 'Ketahuan merokok di area sekolah'],
        ];

        // Buat poin untuk beberapa siswa secara random
        foreach ($siswa->take(10) as $s) {
            // Buat 2-4 prestasi random
            $jumlahPrestasi = rand(2, 4);
            for ($i = 0; $i < $jumlahPrestasi; $i++) {
                $prestasiData = $prestasi[array_rand($prestasi)];
                PoinSiswa::create([
                    'siswa_id' => $s->id,
                    'jenis' => 'Prestasi',
                    'kategori' => $prestasiData['kategori'],
                    'deskripsi' => $prestasiData['deskripsi'],
                    'poin' => $prestasiData['poin'],
                    'tanggal' => Carbon::now()->subDays(rand(1, 60)),
                    'created_by' => $creator->id,
                ]);
            }

            // Buat 1-3 pelanggaran random
            $jumlahPelanggaran = rand(1, 3);
            for ($i = 0; $i < $jumlahPelanggaran; $i++) {
                $pelanggaranData = $pelanggaran[array_rand($pelanggaran)];
                PoinSiswa::create([
                    'siswa_id' => $s->id,
                    'jenis' => 'Pelanggaran',
                    'kategori' => $pelanggaranData['kategori'],
                    'deskripsi' => $pelanggaranData['deskripsi'],
                    'poin' => -$pelanggaranData['poin'], // Negatif untuk pelanggaran
                    'tanggal' => Carbon::now()->subDays(rand(1, 60)),
                    'created_by' => $creator->id,
                ]);
            }
        }

        $this->command->info('Poin siswa berhasil ditambahkan!');
    }
}
