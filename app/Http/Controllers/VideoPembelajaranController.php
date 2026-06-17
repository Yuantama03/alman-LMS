<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\VideoSection;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Request;
use App\Models\VideoComment;
use App\Models\VideoView;
use App\Models\VideoSearch;
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


        public function guruShowDiskusi($id)
    {
        $video = VideoPembelajaran::with([
            'section.mapel',
            'comments.user',
            'comments.replies.user',
        ])->findOrFail($id);

        return view('pages.guru.video.diskusi', compact('video'));
    }
    // ==================== SISWA ====================

    /**
     * Halaman video pembelajaran siswa
     */
       public function siswaIndex(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));

        $sectionsQuery = VideoSection::with(['videos', 'mapel'])->orderBy('urutan');

        if ($keyword !== '') {
            $sectionsQuery->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhereHas('videos', fn ($v) => $v->where('judul', 'like', "%{$keyword}%"))
                    ->orWhereHas('mapel', fn ($m) => $m->where('nama_mapel', 'like', "%{$keyword}%"));
            });
        }

        $sections = $sectionsQuery->get();

        if ($keyword !== '') {
            $mapelId = optional($sections->first()?->mapel)->id;
            VideoSearch::create([
                'user_id'  => Auth::id(),
                'mapel_id' => $mapelId,
                'keyword'  => $keyword,
            ]);
        }

        $activeVideo = $sections->first()?->videos->first();
        $recommended = $this->buildRecommendations($activeVideo);

        return view('pages.siswa.video.index', compact('sections', 'activeVideo', 'recommended', 'keyword'));
    }

    public function siswaPlay($videoId)
    {
        $sections    = VideoSection::with(['videos', 'mapel'])->orderBy('urutan')->get();
        $activeVideo = VideoPembelajaran::with(['section.mapel', 'comments.replies.user', 'comments.user'])
            ->findOrFail($videoId);

        $view = VideoView::firstOrNew([
            'video_pembelajaran_id' => $activeVideo->id,
            'user_id'               => Auth::id(),
        ]);
        $view->jumlah_tonton = ($view->jumlah_tonton ?? 0) + 1;
        $view->save();

        $recommended = $this->buildRecommendations($activeVideo);

        return view('pages.siswa.video.index', compact('sections', 'activeVideo', 'recommended'));
    }

    private function buildRecommendations(?VideoPembelajaran $activeVideo)
    {
        $userId = Auth::id();

        $watchedMapelIds = VideoView::where('user_id', $userId)
            ->with('video.section')
            ->get()
            ->pluck('video.section.mapel_id')
            ->filter()
            ->values();

        $searchedMapelIds = VideoSearch::where('user_id', $userId)
            ->whereNotNull('mapel_id')
            ->pluck('mapel_id');

        $activeMapelId = optional(optional($activeVideo)->section)->mapel_id;

        $mapelIds = collect([$activeMapelId])
            ->merge($watchedMapelIds)
            ->merge($searchedMapelIds)
            ->filter()
            ->unique()
            ->values();

        if ($mapelIds->isEmpty()) {
            return collect();
        }

        return VideoPembelajaran::with('section.mapel')
            ->whereHas('section', fn ($s) => $s->whereIn('mapel_id', $mapelIds))
            ->when($activeVideo, fn ($q) => $q->where('id', '!=', $activeVideo->id))
            ->withCount('views')
            ->orderByDesc('views_count')
            ->take(6)
            ->get();
    }

    public function storeComment(Request $request, $videoId)
    {
        $request->validate([
            'isi'       => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:video_comments,id',
        ]);

        $video = VideoPembelajaran::findOrFail($videoId);

        VideoComment::create([
            'video_pembelajaran_id' => $video->id,
            'user_id'               => Auth::id(),
            'parent_id'             => $request->parent_id,
            'isi'                   => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim');
    }

    public function destroyComment($commentId)
    {
        $comment = VideoComment::findOrFail($commentId);
        $user    = Auth::user();

        $isGuru = $user->roles === 'guru';

        if (! $isGuru && $comment->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }
}