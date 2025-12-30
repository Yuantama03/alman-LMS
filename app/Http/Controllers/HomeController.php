<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Orangtua;
use App\Models\PengumumanSekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        // Basic counts
        $siswa = Siswa::count();
        $guru = Guru::count();
        $kelas = Kelas::count();
        $mapel = Mapel::count();
        $siswaBaru = Siswa::latest()->first();

        // Presensi statistics (today)
        $today = now()->format('Y-m-d');
        $presensiToday = \App\Models\Presensi::whereDate('tanggal', $today)->get();
        $presensiHadir = $presensiToday->where('status', 'Hadir')->count();
        $presensiSakit = $presensiToday->where('status', 'Sakit')->count();
        $presensiIzin = $presensiToday->where('status', 'Izin')->count();
        $presensiAlpha = $presensiToday->where('status', 'Alpha')->count();

        // Poin Siswa statistics
        $totalPoin = \App\Models\PoinSiswa::sum('poin');
        $totalPrestasi = \App\Models\PoinSiswa::where('jenis', 'Prestasi')->sum('poin');
        $totalPelanggaran = abs(\App\Models\PoinSiswa::where('jenis', 'Pelanggaran')->sum('poin'));
        
        // Top 5 students by poin
        $topSiswa = \App\Models\Siswa::withSum('poinSiswa', 'poin')
            ->orderByDesc('poin_siswa_sum_poin')
            ->limit(5)
            ->get();

        // Tugas statistics
        $totalTugas = \App\Models\Tugas::count();
        $totalJawaban = \App\Models\Jawaban::count();
        $tugasAktif = \App\Models\Tugas::whereDate('created_at', '>=', now()->subDays(30))->count();
        
        // Calculate submission rate
        $expectedSubmissions = $totalTugas * $siswa;
        $submissionRate = $expectedSubmissions > 0 ? round(($totalJawaban / $expectedSubmissions) * 100, 2) : 0;

        // Recent activities (last 10 poin entries)
        $recentActivities = \App\Models\PoinSiswa::with(['siswa', 'creator'])
            ->latest()
            ->limit(10)
            ->get();

        // Chart data - Monthly enrollment (last 6 months)
        $monthlyEnrollment = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Siswa::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $monthlyEnrollment[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }

        // Chart data - Attendance trend (last 7 days)
        $attendanceTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $presensi = \App\Models\Presensi::whereDate('tanggal', $date->format('Y-m-d'))->get();
            $attendanceTrend[] = [
                'date' => $date->format('d M'),
                'hadir' => $presensi->where('status', 'Hadir')->count(),
                'sakit' => $presensi->where('status', 'Sakit')->count(),
                'izin' => $presensi->where('status', 'Izin')->count(),
                'alpha' => $presensi->where('status', 'Alpha')->count()
            ];
        }

        return view('pages.admin.dashboard', compact(
            'siswa', 'guru', 'kelas', 'mapel', 'siswaBaru',
            'presensiHadir', 'presensiSakit', 'presensiIzin', 'presensiAlpha',
            'totalPoin', 'totalPrestasi', 'totalPelanggaran', 'topSiswa',
            'totalTugas', 'totalJawaban', 'tugasAktif', 'submissionRate',
            'recentActivities', 'monthlyEnrollment', 'attendanceTrend'
        ));
    }

    public function guru()
    {
        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $materi = Materi::where('guru_id', $guru->id)->count();
        $jadwal = Jadwal::where('mapel_id', $guru->mapel_id)->get();
        $tugas = Tugas::where('guru_id', $guru->id)->count();
        $hari = Carbon::now()->locale('id')->isoFormat('dddd');

        // Get wali kelas data if guru is wali kelas
        $kelas = Kelas::where('guru_id', $guru->id)->first();
        
        if ($kelas) {
            // Class statistics
            $totalSiswa = Siswa::where('kelas_id', $kelas->id)->count();
            
            // Attendance statistics (today)
            $today = now()->format('Y-m-d');
            $presensiToday = \App\Models\Presensi::where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $today)
                ->get();
            
            $presensiHadir = $presensiToday->where('status', 'Hadir')->count();
            $presensiSakit = $presensiToday->where('status', 'Sakit')->count();
            $presensiIzin = $presensiToday->where('status', 'Izin')->count();
            $presensiAlpha = $presensiToday->where('status', 'Alpha')->count();
            
            // Attendance percentage (last 7 days)
            $attendancePercentage = 0;
            if ($totalSiswa > 0) {
                $weekAgo = now()->subDays(7)->format('Y-m-d');
                $totalExpected = $totalSiswa * 7;
                $totalHadir = \App\Models\Presensi::where('kelas_id', $kelas->id)
                    ->whereDate('tanggal', '>=', $weekAgo)
                    ->where('status', 'Hadir')
                    ->count();
                $attendancePercentage = $totalExpected > 0 ? round(($totalHadir / $totalExpected) * 100, 2) : 0;
            }

            // Poin statistics for class
            $siswaIds = Siswa::where('kelas_id', $kelas->id)->pluck('id');
            $totalPrestasi = \App\Models\PoinSiswa::whereIn('siswa_id', $siswaIds)
                ->where('jenis', 'Prestasi')
                ->sum('poin');
            $totalPelanggaran = abs(\App\Models\PoinSiswa::whereIn('siswa_id', $siswaIds)
                ->where('jenis', 'Pelanggaran')
                ->sum('poin'));
            
            // Top 5 students by poin
            $topSiswa = Siswa::whereIn('id', $siswaIds)
                ->withSum('poinSiswa', 'poin')
                ->orderByDesc('poin_siswa_sum_poin')
                ->limit(5)
                ->get();

            // Tugas statistics for class
            $tugasKelas = \App\Models\Tugas::where('kelas_id', $kelas->id)->count();
            $totalJawaban = \App\Models\Jawaban::whereHas('tugas', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            })->count();
            
            $expectedSubmissions = $tugasKelas * $totalSiswa;
            $submissionRate = $expectedSubmissions > 0 ? round(($totalJawaban / $expectedSubmissions) * 100, 2) : 0;

            // Students needing attention (low attendance or negative poin)
            $studentsNeedingAttention = Siswa::whereIn('id', $siswaIds)
                ->withSum('poinSiswa', 'poin')
                ->get()
                ->filter(function($siswa) use ($kelas) {
                    // Check attendance (last 7 days)
                    $weekAgo = now()->subDays(7)->format('Y-m-d');
                    $hadirCount = \App\Models\Presensi::where('siswa_id', $siswa->id)
                        ->where('kelas_id', $kelas->id)
                        ->whereDate('tanggal', '>=', $weekAgo)
                        ->where('status', 'Hadir')
                        ->count();
                    
                    $attendanceRate = ($hadirCount / 7) * 100;
                    $poin = $siswa->poin_siswa_sum_poin ?? 0;
                    
                    return $attendanceRate < 70 || $poin < 0;
                })
                ->take(5);

            // Chart data - Attendance trend for class (last 7 days)
            $attendanceTrend = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $presensi = \App\Models\Presensi::where('kelas_id', $kelas->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->get();
                $attendanceTrend[] = [
                    'date' => $date->format('d M'),
                    'hadir' => $presensi->where('status', 'Hadir')->count(),
                    'sakit' => $presensi->where('status', 'Sakit')->count(),
                    'izin' => $presensi->where('status', 'Izin')->count(),
                    'alpha' => $presensi->where('status', 'Alpha')->count()
                ];
            }
        } else {
            // No class assigned
            $totalSiswa = 0;
            $presensiHadir = 0;
            $presensiSakit = 0;
            $presensiIzin = 0;
            $presensiAlpha = 0;
            $attendancePercentage = 0;
            $totalPrestasi = 0;
            $totalPelanggaran = 0;
            $topSiswa = collect();
            $tugasKelas = 0;
            $submissionRate = 0;
            $studentsNeedingAttention = collect();
            $attendanceTrend = [];
        }

        return view('pages.guru.dashboard', compact(
            'guru', 'materi', 'jadwal', 'hari', 'tugas', 'kelas',
            'totalSiswa', 'presensiHadir', 'presensiSakit', 'presensiIzin', 'presensiAlpha',
            'attendancePercentage', 'totalPrestasi', 'totalPelanggaran', 'topSiswa',
            'tugasKelas', 'submissionRate', 'studentsNeedingAttention', 'attendanceTrend'
        ));
    }

    public function siswa()
    {
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $kelas = Kelas::findOrFail($siswa->kelas_id);
        $materi = Materi::where('kelas_id', $kelas->id)->limit(3)->get();
        $tugas = Tugas::where('kelas_id', $kelas->id)->limit(3)->get();
        $jadwal = Jadwal::where('kelas_id', $kelas->id)->get();
        $hari = Carbon::now()->locale('id')->isoFormat('dddd');
        $pengumumans = PengumumanSekolah::active()->get();
        return view('pages.siswa.dashboard', compact('materi', 'siswa', 'kelas', 'tugas', 'jadwal', 'hari', 'pengumumans'));
    }

    public function orangtua()
    {
        $orangtua = Orangtua::with('siswas.kelas')
            ->where('user_id', Auth::user()->id)
            ->first();
        $pengumumans = PengumumanSekolah::active()->get();

        // dd($orangtua->toArray());
        return view('pages.orangtua.dashboard', compact('orangtua', 'pengumumans'));
    }
}
