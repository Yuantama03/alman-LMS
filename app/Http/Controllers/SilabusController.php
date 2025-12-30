<?php

namespace App\Http\Controllers;

use App\Models\Silabus;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;

class SilabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $silabus = Silabus::with(['mapel', 'kelas', 'semester'])->orderBy('created_at', 'desc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->get();
        return view('pages.admin.silabus.index', compact('silabus', 'mapels', 'kelas', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'semester_id' => 'required',
            'deskripsi' => 'nullable',
            'kompetensi_dasar' => 'nullable',
            'tujuan_pembelajaran' => 'nullable',
            'materi_pokok' => 'nullable',
            'metode_pembelajaran' => 'nullable',
            'alokasi_waktu' => 'nullable|numeric'
        ], [
            'mapel_id.required' => 'Mata pelajaran wajib dipilih',
            'kelas_id.required' => 'Kelas wajib dipilih',
            'semester_id.required' => 'Semester wajib dipilih',
            'alokasi_waktu.numeric' => 'Alokasi waktu harus berupa angka'
        ]);

        Silabus::create($request->all());

        return redirect()->route('silabus.index')->with('success', 'Data silabus berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $silabus = Silabus::findOrFail($id);
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->get();
        return view('pages.admin.silabus.edit', compact('silabus', 'mapels', 'kelas', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'semester_id' => 'required',
            'deskripsi' => 'nullable',
            'kompetensi_dasar' => 'nullable',
            'tujuan_pembelajaran' => 'nullable',
            'materi_pokok' => 'nullable',
            'metode_pembelajaran' => 'nullable',
            'alokasi_waktu' => 'nullable|numeric'
        ], [
            'mapel_id.required' => 'Mata pelajaran wajib dipilih',
            'kelas_id.required' => 'Kelas wajib dipilih',
            'semester_id.required' => 'Semester wajib dipilih',
            'alokasi_waktu.numeric' => 'Alokasi waktu harus berupa angka'
        ]);

        $silabus = Silabus::findOrFail($id);
        $silabus->update($request->all());

        return redirect()->route('silabus.index')->with('success', 'Data silabus berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Silabus::find($id)->delete();
        return back()->with('success', 'Data silabus berhasil dihapus!');
    }
}
