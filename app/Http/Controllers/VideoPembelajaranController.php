<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\VideoSection;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoPembelajaranController extends Controller
{
    // ==================== GURU ====================

    /**
     * Daftar semua section & video milik guru
     */
    public function guruIndex()
    {
        $sections = VideoSection::with(['videos', 'mapel'])
            ->where('created_by', Auth::id())
            ->orderBy('urutan')
            ->get();

        return view('pages.guru.video.index', compact('sections'));
    }

    /**
     * Form buat section baru
     */
    public function guruCreateSection()
    {
        $mapels = Mapel::all();
        return view('pages.guru.video.create-section', compact('mapels'));
    }

    /**
     * Simpan section baru
     */
    public function guruStoreSection(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mapel_id'  => 'nullable|exists:mapels,id',
        ]);

        $lastUrutan = VideoSection::where('created_by', Auth::id())->max('urutan') ?? 0;

        VideoSection::create([
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'mapel_id'   => $request->mapel_id,
            'created_by' => Auth::id(),
            'urutan'     => $lastUrutan + 1,
        ]);

        return redirect()->route('guru.video.index')
            ->with('success', 'Section berhasil dibuat');
    }

    /**
     * Form edit section
     */
    public function guruEditSection($id)
    {
        $section = VideoSection::where('created_by', Auth::id())->findOrFail($id);
        $mapels  = Mapel::all();
        return view('pages.guru.video.edit-section', compact('section', 'mapels'));
    }

    /**
     * Update section
     */
    public function guruUpdateSection(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mapel_id'  => 'nullable|exists:mapels,id',
        ]);

        $section = VideoSection::where('created_by', Auth::id())->findOrFail($id);
        $section->update([
            'judul'    => $request->judul,
            'deskripsi'=> $request->deskripsi,
            'mapel_id' => $request->mapel_id,
        ]);

        return redirect()->route('guru.video.index')
            ->with('success', 'Section berhasil diupdate');
    }

    /**
     * Hapus section (beserta semua videonya)
     */
    public function guruDestroySection($id)
    {
        $section = VideoSection::where('created_by', Auth::id())->findOrFail($id);
        $section->delete();

        return redirect()->route('guru.video.index')
            ->with('success', 'Section berhasil dihapus');
    }

    /**
     * Form tambah video ke section
     */
    public function guruCreateVideo($sectionId)
    {
        $section = VideoSection::where('created_by', Auth::id())->findOrFail($sectionId);
        return view('pages.guru.video.create-video', compact('section'));
    }

    /**
     * Simpan video baru
     */
    public function guruStoreVideo(Request $request, $sectionId)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'durasi'      => 'nullable|string|max:50',
        ]);

        $section    = VideoSection::where('created_by', Auth::id())->findOrFail($sectionId);
        $lastUrutan = VideoPembelajaran::where('video_section_id', $sectionId)->max('urutan') ?? 0;

        VideoPembelajaran::create([
            'video_section_id' => $sectionId,
            'judul'            => $request->judul,
            'youtube_url'      => $request->youtube_url,
            'durasi'           => $request->durasi,
            'urutan'           => $lastUrutan + 1,
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('guru.video.index')
            ->with('success', 'Video berhasil ditambahkan');
    }

    /**
     * Form edit video
     */
    public function guruEditVideo($id)
    {
        $video   = VideoPembelajaran::findOrFail($id);
        $section = VideoSection::where('created_by', Auth::id())->findOrFail($video->video_section_id);
        return view('pages.guru.video.edit-video', compact('video', 'section'));
    }

    /**
     * Update video
     */
    public function guruUpdateVideo(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'durasi'      => 'nullable|string|max:50',
        ]);

        $video = VideoPembelajaran::findOrFail($id);
        $video->update([
            'judul'       => $request->judul,
            'youtube_url' => $request->youtube_url,
            'durasi'      => $request->durasi,
        ]);

        return redirect()->route('guru.video.index')
            ->with('success', 'Video berhasil diupdate');
    }

    /**
     * Hapus video
     */
    public function guruDestroyVideo($id)
    {
        $video = VideoPembelajaran::findOrFail($id);
        $video->delete();

        return redirect()->route('guru.video.index')
            ->with('success', 'Video berhasil dihapus');
    }

    // ==================== SISWA ====================

    /**
     * Halaman video pembelajaran siswa
     */
    public function siswaIndex()
    {
        $sections = VideoSection::with(['videos', 'mapel'])
            ->orderBy('urutan')
            ->get();

        // Video pertama sebagai default
        $activeVideo = $sections->first()?->videos->first();

        return view('pages.siswa.video.index', compact('sections', 'activeVideo'));
    }

    /**
     * Play video tertentu
     */
    public function siswaPlay($videoId)
    {
        $sections    = VideoSection::with(['videos', 'mapel'])->orderBy('urutan')->get();
        $activeVideo = VideoPembelajaran::findOrFail($videoId);

        return view('pages.siswa.video.index', compact('sections', 'activeVideo'));
    }
}