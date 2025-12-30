<?php

namespace App\Http\Controllers;

use App\Models\PoinSiswa;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoinSiswaController extends Controller
{
    // Admin Methods
    public function adminIndex(Request $request)
    {
        $query = PoinSiswa::with(['siswa.kelas', 'creator']);
        
        // Filter by kelas
        if ($request->kelas_id) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        // Filter by jenis
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        
        // Filter by date range
        if ($request->tanggal_dari) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->tanggal_sampai) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }
        
        $poin = $query->orderBy('tanggal', 'desc')->get();
        $kelas = Kelas::all();
        
        // Statistics
        $totalPrestasi = PoinSiswa::where('jenis', 'Prestasi')->sum('poin');
        $totalPelanggaran = PoinSiswa::where('jenis', 'Pelanggaran')->sum('poin');
        
        return view('pages.admin.poin.index', compact('poin', 'kelas', 'totalPrestasi', 'totalPelanggaran'));
    }

    public function adminCreate()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama', 'asc')->get();
        return view('pages.admin.poin.create', compact('siswa'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis' => 'required|in:Prestasi,Pelanggaran',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        // Set poin negatif untuk pelanggaran
        if ($validated['jenis'] == 'Pelanggaran') {
            $validated['poin'] = -abs($validated['poin']);
        }

        $validated['created_by'] = Auth::id();

        PoinSiswa::create($validated);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Poin siswa berhasil ditambahkan');
    }

    public function adminEdit($id)
    {
        $poin = PoinSiswa::findOrFail($id);
        $siswa = Siswa::with('kelas')->orderBy('nama', 'asc')->get();
        return view('pages.admin.poin.edit', compact('poin', 'siswa'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis' => 'required|in:Prestasi,Pelanggaran',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        // Set poin negatif untuk pelanggaran
        if ($validated['jenis'] == 'Pelanggaran') {
            $validated['poin'] = -abs($validated['poin']);
        }

        $poin = PoinSiswa::findOrFail($id);
        $poin->update($validated);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Poin siswa berhasil diperbarui');
    }

    public function adminDestroy($id)
    {
        $poin = PoinSiswa::findOrFail($id);
        $poin->delete();

        return redirect()->route('admin.poin.index')
            ->with('success', 'Poin siswa berhasil dihapus');
    }

    // Guru Methods
    public function guruIndex(Request $request)
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelas;
        
        $query = PoinSiswa::with(['siswa', 'creator'])
            ->whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            });
        
        // Filter by jenis
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        
        $poin = $query->orderBy('tanggal', 'desc')->get();
        
        // Statistics for this class
        $totalPrestasi = PoinSiswa::whereHas('siswa', function($q) use ($kelas) {
            $q->where('kelas_id', $kelas->id);
        })->where('jenis', 'Prestasi')->sum('poin');
        
        $totalPelanggaran = PoinSiswa::whereHas('siswa', function($q) use ($kelas) {
            $q->where('kelas_id', $kelas->id);
        })->where('jenis', 'Pelanggaran')->sum('poin');
        
        return view('pages.guru.poin.index', compact('poin', 'kelas', 'totalPrestasi', 'totalPelanggaran'));
    }

    public function guruCreate()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelas;
        $siswa = Siswa::where('kelas_id', $kelas->id)->orderBy('nama', 'asc')->get();
        
        return view('pages.guru.poin.create', compact('siswa', 'kelas'));
    }

    public function guruStore(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis' => 'required|in:Prestasi,Pelanggaran',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'poin' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        // Set poin negatif untuk pelanggaran
        if ($validated['jenis'] == 'Pelanggaran') {
            $validated['poin'] = -abs($validated['poin']);
        }

        $validated['created_by'] = Auth::id();

        PoinSiswa::create($validated);

        return redirect()->route('guru.poin.index')
            ->with('success', 'Poin siswa berhasil ditambahkan');
    }

    // Siswa Methods
    public function siswaIndex()
    {
        $siswa = Auth::user()->siswa;
        
        $poin = PoinSiswa::with('creator')
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Calculate total poin
        $totalPoin = $poin->sum('poin');
        $totalPrestasi = $poin->where('jenis', 'Prestasi')->sum('poin');
        $totalPelanggaran = $poin->where('jenis', 'Pelanggaran')->sum('poin');
        
        return view('pages.siswa.poin.index', compact('poin', 'totalPoin', 'totalPrestasi', 'totalPelanggaran'));
    }

    // Orangtua Methods
    public function orangtuaIndex()
    {
        $orangtua = Auth::user()->orangtua;
        $siswa = $orangtua->siswas;
        
        // Get poin for all children
        $poin = PoinSiswa::with(['siswa', 'creator'])
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Calculate totals per child
        $totals = [];
        foreach ($siswa as $s) {
            $totals[$s->id] = [
                'nama' => $s->nama,
                'total' => $poin->where('siswa_id', $s->id)->sum('poin'),
                'prestasi' => $poin->where('siswa_id', $s->id)->where('jenis', 'Prestasi')->sum('poin'),
                'pelanggaran' => $poin->where('siswa_id', $s->id)->where('jenis', 'Pelanggaran')->sum('poin'),
            ];
        }
        
        return view('pages.orangtua.poin.index', compact('poin', 'siswa', 'totals'));
    }
}
