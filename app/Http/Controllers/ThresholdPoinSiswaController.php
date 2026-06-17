<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\PoinSiswa;
use App\Models\ThresholdPoinSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThresholdPoinSiswaController extends Controller
{
    /**
     * Daftar semua siswa + status threshold
     * Diakses admin & guru
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->roles === 'guru') {
            $guru      = $user->guru;
            $kelasIds  = Kelas::where('guru_id', $guru->id)->pluck('id');
            $query     = Siswa::with(['kelas', 'thresholdPoin'])
                               ->whereIn('kelas_id', $kelasIds);
        } else {
            $query = Siswa::with(['kelas', 'thresholdPoin']);
        }

        // Filter kelas
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaList = $query->orderBy('nama')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // Hitung status per siswa (rule-based)
        $data = [];
        foreach ($siswaList as $siswa) {
            $totalPoin = PoinSiswa::where('siswa_id', $siswa->id)->sum('poin');
            $threshold = $siswa->thresholdPoin ?? ThresholdPoinSiswa::getDefault();
            $data[] = [
                'siswa'      => $siswa,
                'total_poin' => $totalPoin,
                'threshold'  => $threshold,
                'status'     => $threshold->getStatus($totalPoin),
            ];
        }

        return view('pages.threshold-siswa.index', compact('data', 'kelasList'));
    }

    /**
     * Form edit threshold per siswa
     */
    public function edit($siswaId)
    {
        $siswa     = Siswa::with('kelas')->findOrFail($siswaId);
        $threshold = ThresholdPoinSiswa::where('siswa_id', $siswaId)->first()
                     ?? ThresholdPoinSiswa::getDefault();

        return view('pages.threshold-siswa.edit', compact('siswa', 'threshold'));
    }

    /**
     * Update threshold siswa
     */
    public function update(Request $request, $siswaId)
    {
        $request->validate([
            'sangat_baik' => 'required|integer|min:1|max:500',
            'baik'        => 'required|integer|min:1|max:500',
            'cukup'       => 'required|integer|min:1|max:500',
            'kurang'      => 'required|integer|min:1|max:500',
        ]);

        if (
            $request->sangat_baik <= $request->baik ||
            $request->baik        <= $request->cukup ||
            $request->cukup       <= $request->kurang
        ) {
            return back()->withErrors([
                'urutan' => 'Nilai threshold harus berurutan: Sangat Baik > Baik > Cukup > Kurang'
            ])->withInput();
        }

        ThresholdPoinSiswa::updateOrCreate(
            ['siswa_id' => $siswaId],
            [
                'sangat_baik' => $request->sangat_baik,
                'baik'        => $request->baik,
                'cukup'       => $request->cukup,
                'kurang'      => $request->kurang,
                'set_by'      => Auth::id(),
            ]
        );

        // Redirect sesuai role
        if (Auth::user()->roles === 'guru') {
            return redirect()->route('guru.threshold.siswa.index')
                ->with('success', 'Threshold siswa berhasil diperbarui');
        }

        return redirect()->route('admin.threshold.siswa.index')
            ->with('success', 'Threshold siswa berhasil diperbarui');
    }

    /**
     * Reset threshold siswa ke default
     */
    public function reset($siswaId)
    {
        ThresholdPoinSiswa::where('siswa_id', $siswaId)->delete();

        if (Auth::user()->roles === 'guru') {
            return redirect()->route('guru.threshold.siswa.index')
                ->with('success', 'Threshold siswa direset ke default');
        }

        return redirect()->route('admin.threshold.siswa.index')
            ->with('success', 'Threshold siswa direset ke default');
    }
}