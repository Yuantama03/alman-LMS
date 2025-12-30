<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    // Admin - View all presensi
    public function adminIndex(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $selectedKelas = $request->kelas_id;
        $selectedDate = $request->tanggal ?? Carbon::today()->format('Y-m-d');

        $query = Presensi::with(['siswa', 'kelas']);

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        if ($selectedDate) {
            $query->whereDate('tanggal', $selectedDate);
        }

        $presensi = $query->orderBy('tanggal', 'desc')->get();

        // Get statistics
        $stats = [
            'hadir' => $presensi->where('status', 'Hadir')->count(),
            'sakit' => $presensi->where('status', 'Sakit')->count(),
            'izin' => $presensi->where('status', 'Izin')->count(),
            'alpha' => $presensi->where('status', 'Alpha')->count(),
        ];

        return view('pages.admin.presensi.index', compact('presensi', 'kelas', 'selectedKelas', 'selectedDate', 'stats'));
    }

    // Admin - Form input presensi
    public function adminCreate(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $selectedKelas = $request->kelas_id;
        $tanggal = $request->tanggal ?? Carbon::today()->format('Y-m-d');

        $siswas = [];
        $existingPresensi = [];

        if ($selectedKelas) {
            $siswas = Siswa::where('kelas_id', $selectedKelas)->orderBy('nama', 'asc')->get();
            $existingPresensi = Presensi::where('kelas_id', $selectedKelas)
                ->whereDate('tanggal', $tanggal)
                ->pluck('status', 'siswa_id')
                ->toArray();
        }

        return view('pages.admin.presensi.create', compact('kelas', 'selectedKelas', 'tanggal', 'siswas', 'existingPresensi'));
    }

    // Admin - Store presensi
    public function adminStore(Request $request)
    {
        $this->validate($request, [
            'kelas_id' => 'required',
            'tanggal' => 'required|date',
            'presensi' => 'required|array',
        ]);

        foreach ($request->presensi as $siswa_id => $status) {
            Presensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'kelas_id' => $request->kelas_id,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null,
                    'created_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('admin.presensi.index', [
            'kelas_id' => $request->kelas_id,
            'tanggal' => $request->tanggal
        ])->with('success', 'Presensi berhasil disimpan');
    }

    // Guru - View presensi for their class
    public function guruIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = Kelas::where('guru_id', $guru->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas');
        }

        $selectedDate = $request->tanggal ?? Carbon::today()->format('Y-m-d');

        $presensi = Presensi::with(['siswa'])
            ->where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $selectedDate)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Get statistics
        $stats = [
            'hadir' => $presensi->where('status', 'Hadir')->count(),
            'sakit' => $presensi->where('status', 'Sakit')->count(),
            'izin' => $presensi->where('status', 'Izin')->count(),
            'alpha' => $presensi->where('status', 'Alpha')->count(),
        ];

        return view('pages.guru.presensi.index', compact('presensi', 'kelas', 'selectedDate', 'stats'));
    }

    // Guru - Form input presensi
    public function guruCreate(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = Kelas::where('guru_id', $guru->id)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas');
        }

        $tanggal = $request->tanggal ?? Carbon::today()->format('Y-m-d');
        $siswas = Siswa::where('kelas_id', $kelas->id)->orderBy('nama', 'asc')->get();
        $existingPresensi = Presensi::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggal)
            ->pluck('status', 'siswa_id')
            ->toArray();

        return view('pages.guru.presensi.create', compact('kelas', 'tanggal', 'siswas', 'existingPresensi'));
    }

    // Guru - Store presensi
    public function guruStore(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = Kelas::where('guru_id', $guru->id)->first();

        $this->validate($request, [
            'tanggal' => 'required|date',
            'presensi' => 'required|array',
        ]);

        foreach ($request->presensi as $siswa_id => $status) {
            Presensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'kelas_id' => $kelas->id,
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null,
                    'created_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('guru.presensi.index', [
            'tanggal' => $request->tanggal
        ])->with('success', 'Presensi berhasil disimpan');
    }

    // Siswa - View own attendance
    public function siswaIndex()
    {
        $siswa = Siswa::where('nis', Auth::user()->nis)->first();
        $presensi = Presensi::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        // Get statistics for current month
        $stats = [
            'hadir' => Presensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->where('status', 'Hadir')->count(),
            'sakit' => Presensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->where('status', 'Sakit')->count(),
            'izin' => Presensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->where('status', 'Izin')->count(),
            'alpha' => Presensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->where('status', 'Alpha')->count(),
        ];

        return view('pages.siswa.presensi.index', compact('presensi', 'siswa', 'stats'));
    }

    // Orangtua - View children attendance
    public function orangtuaIndex()
    {
        $orangtua = \App\Models\Orangtua::where('user_id', Auth::id())->first();
        $siswas = $orangtua->siswas;

        $presensiData = [];
        foreach ($siswas as $siswa) {
            $presensi = Presensi::where('siswa_id', $siswa->id)
                ->orderBy('tanggal', 'desc')
                ->limit(10)
                ->get();

            $stats = [
                'hadir' => Presensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', Carbon::now()->month)
                    ->where('status', 'Hadir')->count(),
                'sakit' => Presensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', Carbon::now()->month)
                    ->where('status', 'Sakit')->count(),
                'izin' => Presensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', Carbon::now()->month)
                    ->where('status', 'Izin')->count(),
                'alpha' => Presensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', Carbon::now()->month)
                    ->where('status', 'Alpha')->count(),
            ];

            $presensiData[] = [
                'siswa' => $siswa,
                'presensi' => $presensi,
                'stats' => $stats
            ];
        }

        return view('pages.orangtua.presensi', compact('presensiData'));
    }
}
