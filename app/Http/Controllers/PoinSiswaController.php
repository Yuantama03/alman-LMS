<?php

namespace App\Http\Controllers;

use App\Models\PoinSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\ThresholdPoin;
use App\Models\ThresholdPoinSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoinSiswaController extends Controller
{
    // ==================== ADMIN ====================

    public function adminIndex(Request $request)
    {
        $query = PoinSiswa::with(['siswa.kelas', 'creator']);

        // Filter by kelas
        if ($request->kelas_id) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter by jenis
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $poin  = $query->orderBy('tanggal', 'desc')->get();
        $kelas = Kelas::all();

        // Statistics
        $totalPrestasi    = PoinSiswa::where('jenis', 'Prestasi')->sum('poin');
        $totalPelanggaran = PoinSiswa::where('jenis', 'Pelanggaran')->sum('poin');

        // Rule-based: hitung status per siswa
        $siswaList   = Siswa::with('kelas')->get();
        $statusSiswa = [];
        foreach ($siswaList as $s) {
            $totalPoin = PoinSiswa::where('siswa_id', $s->id)->sum('poin');
            $threshold = ThresholdPoin::where('kelas_id', $s->kelas_id)->first()
                         ?? ThresholdPoin::getDefault();
            $statusSiswa[$s->id] = [
                'nama'       => $s->nama,
                'kelas'      => $s->kelas->nama_kelas ?? '-',
                'total_poin' => $totalPoin,
                'status'     => $threshold->getStatus($totalPoin),
            ];
        }

        return view('pages.admin.poin.index', compact(
            'poin', 'kelas', 'totalPrestasi', 'totalPelanggaran', 'statusSiswa'
        ));
    }

    public function adminCreate()
    {
        $siswa = Siswa::with('kelas')->get();
        return view('pages.admin.poin.create', compact('siswa'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'siswa_id'  => 'required|exists:siswas,id',
            'jenis'     => 'required|in:Prestasi,Pelanggaran',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poin'      => 'required|integer',
            'tanggal'   => 'required|date',
        ]);

            PoinSiswa::create([
    'siswa_id'   => $request->siswa_id,
    'jenis'      => $request->jenis,
    'kategori'   => $request->kategori,
    'deskripsi'  => $request->deskripsi,
    'poin'       => $request->jenis === 'Pelanggaran' ? -abs($request->poin) : abs($request->poin),
    'tanggal'    => $request->tanggal,
    'created_by' => Auth::id(),
]);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Data poin berhasil ditambahkan');
    }

    public function guruDestroy($id)
{
    $poin = PoinSiswa::findOrFail($id);
    $poin->delete();

    return redirect()->route('guru.poin.index')
        ->with('success', 'Data poin berhasil dihapus');
}

    public function adminEdit($id)
    {
        $poin  = PoinSiswa::findOrFail($id);
        $siswa = Siswa::with('kelas')->get();
        return view('pages.admin.poin.edit', compact('poin', 'siswa'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'siswa_id'  => 'required|exists:siswas,id',
            'jenis'     => 'required|in:Prestasi,Pelanggaran',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poin'      => 'required|integer',
            'tanggal'   => 'required|date',
        ]);

        $poin = PoinSiswa::findOrFail($id);
        $poin->update([
            'siswa_id'  => $request->siswa_id,
            'jenis'     => $request->jenis,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'poin'      => $request->poin,
            'tanggal'   => $request->tanggal,
        ]);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Data poin berhasil diperbarui');
    }

    public function adminDestroy($id)
    {
        $poin = PoinSiswa::findOrFail($id);
        $poin->delete();

        return redirect()->route('admin.poin.index')
            ->with('success', 'Data poin berhasil dihapus');
    }

    // ==================== GURU ====================

    public function guruIndex(Request $request)
    {
        $guru  = Auth::user()->guru;
        $kelas = Kelas::where('guru_id', $guru->id)->get();

        $query = PoinSiswa::with(['siswa.kelas', 'creator'])
            ->whereHas('siswa', function ($q) use ($kelas) {
                $q->whereIn('kelas_id', $kelas->pluck('id'));
            });

        if ($request->kelas_id) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $poin             = $query->orderBy('tanggal', 'desc')->get();
        $totalPrestasi    = $poin->where('jenis', 'Prestasi')->sum('poin');
        $totalPelanggaran = $poin->where('jenis', 'Pelanggaran')->sum('poin');

        return view('pages.guru.poin.index', compact(
            'poin', 'kelas', 'totalPrestasi', 'totalPelanggaran'
        ));
    }

    public function guruCreate()
    {
        $guru  = Auth::user()->guru;
        $kelas = Kelas::where('guru_id', $guru->id)->get();
        $siswa = Siswa::whereIn('kelas_id', $kelas->pluck('id'))->with('kelas')->get();
        return view('pages.guru.poin.create', compact('siswa', 'kelas'));
    }

    public function guruStore(Request $request)
    {
        $request->validate([
            'siswa_id'  => 'required|exists:siswas,id',
            'jenis'     => 'required|in:Prestasi,Pelanggaran',
            'kategori'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'poin'      => 'required|integer',
            'tanggal'   => 'required|date',
        ]);

       PoinSiswa::create([
    'siswa_id'   => $request->siswa_id,
    'jenis'      => $request->jenis,
    'kategori'   => $request->kategori,
    'deskripsi'  => $request->deskripsi,
    'poin'       => $request->jenis === 'Pelanggaran' ? -abs($request->poin) : abs($request->poin),
    'tanggal'    => $request->tanggal,
    'created_by' => Auth::id(),
]);

        return redirect()->route('guru.poin.index')
            ->with('success', 'Data poin berhasil ditambahkan');
    }

    // ==================== SISWA ====================

   public function siswaIndex()
{
    $siswa = Auth::user()->siswa;

    $poin = PoinSiswa::with('creator')
        ->where('siswa_id', $siswa->id)
        ->orderBy('tanggal', 'desc')
        ->get();

    $totalPoin        = $poin->sum('poin');
    $totalPrestasi    = $poin->where('jenis', 'Prestasi')->sum('poin');
    $totalPelanggaran = $poin->where('jenis', 'Pelanggaran')->sum('poin');

    // Rule-based: ambil threshold PER SISWA
    $threshold = ThresholdPoinSiswa::where('siswa_id', $siswa->id)->first()
                 ?? ThresholdPoinSiswa::getDefault();
    $status = $threshold->getStatus($totalPoin);

    // Persentase progress bar (skala ke sangat_baik)
    $maxPoin    = $threshold->sangat_baik > 0 ? $threshold->sangat_baik : 1;
    $persenPoin = max(0, min(100, round(($totalPoin / $maxPoin) * 100)));

            // ========== EARLY WARNING UNTUK POIN PELANGGARAN ==========
        $totalPoinPelanggaran = abs($totalPelanggaran); // Konversi ke positif
        $earlyWarningStatus = \App\Helpers\EarlyWarningHelper::getStatus($totalPoinPelanggaran);

    // ========== EARLY WARNING UNTUK POIN PELANGGARAN ==========
    $totalPoinPelanggaran = abs($totalPelanggaran); // Konversi ke positif
    $earlyWarningStatus = \App\Helpers\EarlyWarningHelper::getStatus($totalPoinPelanggaran);

    return view('pages.siswa.poin.index', compact(
        'poin', 'totalPoin', 'totalPrestasi', 'totalPelanggaran', 'status', 'threshold', 'persenPoin', 
        'totalPoinPelanggaran', 'earlyWarningStatus'
    ));
}

    // ==================== ORANGTUA ====================

    public function orangtuaIndex()
    {
        $orangtua = Auth::user()->orangtua;
        $siswa    = $orangtua->siswas;

        $poin = PoinSiswa::with(['siswa', 'creator'])
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->orderBy('tanggal', 'desc')
            ->get();

        // Rule-based: hitung status per anak
        $totals = [];
        foreach ($siswa as $s) {
            $totalPoin = $poin->where('siswa_id', $s->id)->sum('poin');
            $threshold = ThresholdPoin::where('kelas_id', $s->kelas_id)->first()
                         ?? ThresholdPoin::getDefault();

            $totals[$s->id] = [
                'nama'        => $s->nama,
                'total'       => $totalPoin,
                'prestasi'    => $poin->where('siswa_id', $s->id)->where('jenis', 'Prestasi')->sum('poin'),
                'pelanggaran' => $poin->where('siswa_id', $s->id)->where('jenis', 'Pelanggaran')->sum('poin'),
                'status'      => $threshold->getStatus($totalPoin),
            ];
        }

        return view('pages.orangtua.poin.index', compact('poin', 'siswa', 'totals'));
    }
}