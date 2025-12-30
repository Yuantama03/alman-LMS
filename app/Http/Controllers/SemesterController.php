<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->orderBy('nama_semester', 'asc')->get();
        return view('pages.admin.semester.index', compact('semesters'));
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
            'nama_semester' => 'required',
            'tahun_ajaran' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ], [
            'nama_semester.required' => 'Nama semester wajib diisi',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai'
        ]);

        // If status_aktif is checked, deactivate all other semesters
        if ($request->has('status_aktif') && $request->status_aktif == '1') {
            Semester::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        Semester::create([
            'nama_semester' => $request->nama_semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_aktif' => $request->has('status_aktif') ? true : false
        ]);

        return redirect()->route('semester.index')->with('success', 'Data semester berhasil disimpan');
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
        $semester = Semester::findOrFail($id);
        return view('pages.admin.semester.edit', compact('semester'));
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
            'nama_semester' => 'required',
            'tahun_ajaran' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ], [
            'nama_semester.required' => 'Nama semester wajib diisi',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai'
        ]);

        // If status_aktif is checked, deactivate all other semesters
        if ($request->has('status_aktif') && $request->status_aktif == '1') {
            Semester::where('id', '!=', $id)->where('status_aktif', true)->update(['status_aktif' => false]);
        }

        $semester = Semester::findOrFail($id);
        $semester->update([
            'nama_semester' => $request->nama_semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_aktif' => $request->has('status_aktif') ? true : false
        ]);

        return redirect()->route('semester.index')->with('success', 'Data semester berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Semester::find($id)->delete();
        return back()->with('success', 'Data semester berhasil dihapus!');
    }
}
