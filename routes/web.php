<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThresholdPoinController;
use App\Http\Controllers\JadwalController;
// use App\Http\Controllers\JurusanController; // Removed for SMP
use App\Http\Controllers\KalenderAkademikController;
use App\Http\Controllers\ChatGroupController;
use App\Http\Controllers\VideoPembelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ThresholdPoinSiswaController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengumumanSekolahController;
use App\Http\Controllers\PoinSiswaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SilabusController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::put('/update-profile', [UserController::class, 'update'])->name('update.profile');
    Route::get('/edit-password', [UserController::class, 'editPassword'])->name('ubah-password');
    Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('update-password');

     // Chat Kelompok — semua role bisa akses
    Route::get('/chat/group', [ChatGroupController::class, 'index'])->name('chat.group.index');
    Route::get('/chat/group/create', [ChatGroupController::class, 'create'])->name('chat.group.create');
    Route::post('/chat/group', [ChatGroupController::class, 'store'])->name('chat.group.store');
    Route::get('/chat/group/{groupId}', [ChatGroupController::class, 'show'])->name('chat.group.show');
    Route::post('/chat/group/{groupId}/send', [ChatGroupController::class, 'send'])->name('chat.group.send');
    Route::post('/chat/group/{groupId}/add-member', [ChatGroupController::class, 'addMember'])->name('chat.group.addMember');
    Route::post('/chat/group/{groupId}/remove-member', [ChatGroupController::class, 'removeMember'])->name('chat.group.removeMember');
    Route::delete('/chat/group/{groupId}', [ChatGroupController::class, 'destroy'])->name('chat.group.destroy');
});

Route::group(['middleware' => ['auth', 'checkRole:guru']], function () {
    Route::get('/guru/dashboard', [HomeController::class, 'guru'])->name('guru.dashboard');
    Route::resource('materi', MateriController::class);
    Route::get('/chat/{mapelId}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{mapelId}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::resource('tugas', TugasController::class);
    Route::get('/jawaban-download/{id}', [TugasController::class, 'downloadJawaban'])->name('guru.jawaban.download');
    Route::put('/tugas/nilai/{id}', [TugasController::class, 'inputNilai'])->name('guru.tugas.nilai');
    Route::get('/guru/presensi', [PresensiController::class, 'guruIndex'])->name('guru.presensi.index');
    Route::get('/guru/presensi/create', [PresensiController::class, 'guruCreate'])->name('guru.presensi.create');
    Route::post('/guru/presensi/store', [PresensiController::class, 'guruStore'])->name('guru.presensi.store');
    Route::get('/guru/poin', [PoinSiswaController::class, 'guruIndex'])->name('guru.poin.index');
    Route::get('/guru/poin/create', [PoinSiswaController::class, 'guruCreate'])->name('guru.poin.create');
    Route::delete('/guru/poin/{id}', [PoinSiswaController::class, 'guruDestroy'])->name('guru.poin.destroy');
    // Threshold Per Siswa
Route::get('/guru/threshold-siswa', [ThresholdPoinSiswaController::class, 'index'])->name('guru.threshold.siswa.index');
Route::get('/guru/threshold-siswa/{siswaId}/edit', [ThresholdPoinSiswaController::class, 'edit'])->name('guru.threshold.siswa.edit');
Route::put('/guru/threshold-siswa/{siswaId}', [ThresholdPoinSiswaController::class, 'update'])->name('guru.threshold.siswa.update');
Route::delete('/guru/threshold-siswa/{siswaId}/reset', [ThresholdPoinSiswaController::class, 'reset'])->name('guru.threshold.siswa.reset');
    Route::post('/guru/poin/store', [PoinSiswaController::class, 'guruStore'])->name('guru.poin.store');
    Route::get('/guru/kalender', [KalenderAkademikController::class, 'index'])->name('guru.kalender.index');
    // Video Pembelajaran
    Route::get('/guru/video', [VideoPembelajaranController::class, 'guruIndex'])->name('guru.video.index');
    Route::get('/guru/video/section/create', [VideoPembelajaranController::class, 'guruCreateSection'])->name('guru.video.section.create');
    Route::post('/guru/video/section', [VideoPembelajaranController::class, 'guruStoreSection'])->name('guru.video.section.store');
    Route::get('/guru/video/section/{id}/edit', [VideoPembelajaranController::class, 'guruEditSection'])->name('guru.video.section.edit');
    Route::put('/guru/video/section/{id}', [VideoPembelajaranController::class, 'guruUpdateSection'])->name('guru.video.section.update');
    Route::delete('/guru/video/section/{id}', [VideoPembelajaranController::class, 'guruDestroySection'])->name('guru.video.section.destroy');
    Route::get('/guru/video/section/{sectionId}/video/create', [VideoPembelajaranController::class, 'guruCreateVideo'])->name('guru.video.create');
    Route::post('/guru/video/section/{sectionId}/video', [VideoPembelajaranController::class, 'guruStoreVideo'])->name('guru.video.store');
    Route::get('/guru/video/{id}/edit', [VideoPembelajaranController::class, 'guruEditVideo'])->name('guru.video.edit');
    Route::put('/guru/video/{id}', [VideoPembelajaranController::class, 'guruUpdateVideo'])->name('guru.video.update');
    Route::delete('/guru/video/{id}', [VideoPembelajaranController::class, 'guruDestroyVideo'])->name('guru.video.destroy');
});
Route::group(['middleware' => ['auth', 'checkRole:siswa']], function () {

    Route::get('/chat/{mapelId}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{mapelId}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/siswa/dashboard', [HomeController::class, 'siswa'])->name('siswa.dashboard');
    Route::get('/siswa/materi', [MateriController::class, 'siswa'])->name('siswa.materi');
    Route::get('/materi-download/{id}', [MateriController::class, 'download'])->name('siswa.materi.download');
    Route::get('/siswa/tugas', [TugasController::class, 'siswa'])->name('siswa.tugas');
    Route::get('/tugas-download/{id}', [TugasController::class, 'download'])->name('siswa.tugas.download');
    Route::post('/kirim-jawaban', [TugasController::class, 'kirimJawaban'])->name('kirim-jawaban');
    Route::get('/siswa/presensi', [PresensiController::class, 'siswaIndex'])->name('siswa.presensi.index');
    Route::get('/siswa/poin', [PoinSiswaController::class, 'siswaIndex'])->name('siswa.poin.index');
    Route::get('/siswa/kalender', [KalenderAkademikController::class, 'index'])->name('siswa.kalender.index');
Route::get('/siswa/video', [VideoPembelajaranController::class, 'siswaIndex'])->name('siswa.video.index');
Route::get('/siswa/video/{videoId}', [VideoPembelajaranController::class, 'siswaPlay'])->name('siswa.video.play');
});
Route::group(['middleware' => ['auth', 'checkRole:orangtua']], function () {
    Route::get('/orangtua/dashboard', [HomeController::class, 'orangtua'])->name('orangtua.dashboard');
    Route::get('/orangtua/tugas/siswa', [TugasController::class, 'orangtua'])->name('orangtua.tugas.siswa');
    Route::get('/orangtua/presensi', [PresensiController::class, 'orangtuaIndex'])->name('orangtua.presensi.index');
    Route::get('/orangtua/poin', [PoinSiswaController::class, 'orangtuaIndex'])->name('orangtua.poin.index');
    Route::get('/orangtua/kalender', [KalenderAkademikController::class, 'index'])->name('orangtua.kalender.index');
});
Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    // Route::resource('jurusan', JurusanController::class); // Removed for SMP
    Route::resource('mapel', MapelController::class);
    Route::resource('guru', GuruController::class);
    // Threshold Per Siswa
Route::get('/admin/threshold-siswa', [ThresholdPoinSiswaController::class, 'index'])->name('admin.threshold.siswa.index');
Route::get('/admin/threshold-siswa/{siswaId}/edit', [ThresholdPoinSiswaController::class, 'edit'])->name('admin.threshold.siswa.edit');
Route::put('/admin/threshold-siswa/{siswaId}', [ThresholdPoinSiswaController::class, 'update'])->name('admin.threshold.siswa.update');
Route::delete('/admin/threshold-siswa/{siswaId}/reset', [ThresholdPoinSiswaController::class, 'reset'])->name('admin.threshold.siswa.reset');
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('user', UserController::class);
    Route::resource('jadwal', JadwalController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('silabus', SilabusController::class);
    Route::resource('pengumuman-sekolah', PengumumanSekolahController::class);
    Route::resource('pengaturan', PengaturanController::class);
    Route::get('/admin/tugas', [TugasController::class, 'adminIndex'])->name('admin.tugas.index');
    Route::get('/admin/tugas/{id}', [TugasController::class, 'adminShow'])->name('admin.tugas.show');
    Route::get('/admin/presensi', [PresensiController::class, 'adminIndex'])->name('admin.presensi.index');
    Route::get('/admin/presensi/create', [PresensiController::class, 'adminCreate'])->name('admin.presensi.create');
    Route::post('/admin/presensi/store', [PresensiController::class, 'adminStore'])->name('admin.presensi.store');
    Route::get('/admin/poin', [PoinSiswaController::class, 'adminIndex'])->name('admin.poin.index');
    Route::get('/admin/poin/create', [PoinSiswaController::class, 'adminCreate'])->name('admin.poin.create');
    Route::post('/admin/poin/store', [PoinSiswaController::class, 'adminStore'])->name('admin.poin.store');
    Route::get('/admin/poin/{id}/edit', [PoinSiswaController::class, 'adminEdit'])->name('admin.poin.edit');
    Route::put('/admin/poin/{id}', [PoinSiswaController::class, 'adminUpdate'])->name('admin.poin.update');
    Route::delete('/admin/poin/{id}', [PoinSiswaController::class, 'adminDestroy'])->name('admin.poin.destroy');
    Route::get('/admin/kalender', [KalenderAkademikController::class, 'adminIndex'])->name('admin.kalender.index');
    Route::post('/admin/kalender', [KalenderAkademikController::class, 'adminStore'])->name('admin.kalender.store');
    Route::get('/admin/kalender/{id}/edit', [KalenderAkademikController::class, 'adminEdit'])->name('admin.kalender.edit');
    Route::put('/admin/kalender/{id}', [KalenderAkademikController::class, 'adminUpdate'])->name('admin.kalender.update');
    Route::delete('/admin/kalender/{id}', [KalenderAkademikController::class, 'adminDestroy'])->name('admin.kalender.destroy');

    // Threshold Poin
    Route::get('/admin/threshold', [ThresholdPoinController::class, 'index'])->name('admin.threshold.index');
    Route::get('/admin/threshold/{kelasId}/edit', [ThresholdPoinController::class, 'edit'])->name('admin.threshold.edit');
    Route::put('/admin/threshold/{kelasId}', [ThresholdPoinController::class, 'update'])->name('admin.threshold.update');
    
});
