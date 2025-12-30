<?php

namespace App\Http\Controllers;

use App\Models\KalenderAkademik;
use App\Models\Semester;
use Illuminate\Http\Request;

class KalenderAkademikController extends Controller
{
    // Admin Methods
    public function adminIndex()
    {
        $kalender = KalenderAkademik::with('semester')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        
        return view('pages.admin.kalender.index', compact('kalender'));
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_kegiatan' => 'required|in:Libur,Ujian,Acara,Pendaftaran,Pembelajaran,Lainnya',
            'warna' => 'required|string|max:7',
            'semester_id' => 'nullable|exists:semesters,id'
        ]);

        KalenderAkademik::create($validated);

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Kegiatan akademik berhasil ditambahkan');
    }

    public function adminEdit($id)
    {
        $kalender = KalenderAkademik::findOrFail($id);
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->get();
        
        return view('pages.admin.kalender.edit', compact('kalender', 'semesters'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_kegiatan' => 'required|in:Libur,Ujian,Acara,Pendaftaran,Pembelajaran,Lainnya',
            'warna' => 'required|string|max:7',
            'semester_id' => 'nullable|exists:semesters,id'
        ]);

        $kalender = KalenderAkademik::findOrFail($id);
        $kalender->update($validated);

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Kegiatan akademik berhasil diperbarui');
    }

    public function adminDestroy($id)
    {
        $kalender = KalenderAkademik::findOrFail($id);
        $kalender->delete();

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Kegiatan akademik berhasil dihapus');
    }

    // Public Methods for all roles
    public function index()
    {
        $kalender = KalenderAkademik::with('semester')
            ->orderBy('tanggal_mulai', 'asc')
            ->get();
        
        // Format for calendar display
        $events = $kalender->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->judul,
                'start' => $item->tanggal_mulai->format('Y-m-d'),
                'end' => $item->tanggal_selesai ? $item->tanggal_selesai->addDay()->format('Y-m-d') : null,
                'color' => $item->warna,
                'description' => $item->deskripsi,
                'jenis' => $item->jenis_kegiatan,
            ];
        });

        return view('pages.kalender.index', compact('kalender', 'events'));
    }
}
