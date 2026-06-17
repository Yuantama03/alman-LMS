<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\ThresholdPoin;
use Illuminate\Http\Request;

class ThresholdPoinController extends Controller
{
    public function index()
    {
        $kelasList = Kelas::with('thresholdPoin')->orderBy('nama_kelas', 'asc')->get();

        foreach ($kelasList as $kelas) {
            if (!$kelas->thresholdPoin) {
                ThresholdPoin::create([
                    'kelas_id'    => $kelas->id,
                    'sangat_baik' => 90,
                    'baik'        => 75,
                    'cukup'       => 60,
                    'kurang'      => 40,
                ]);
            }
        }

        $kelasList = Kelas::with('thresholdPoin')->orderBy('nama_kelas', 'asc')->get();

        return view('pages.admin.threshold.index', compact('kelasList'));
    }

    public function edit($kelasId)
    {
        $kelas     = Kelas::findOrFail($kelasId);
        $threshold = ThresholdPoin::where('kelas_id', $kelasId)->first()
                     ?? ThresholdPoin::getDefault();

        return view('pages.admin.threshold.edit', compact('kelas', 'threshold'));
    }

    public function update(Request $request, $kelasId)
    {
        $request->validate([
            'sangat_baik' => 'required|integer|min:1|max:200',
            'baik'        => 'required|integer|min:1|max:200',
            'cukup'       => 'required|integer|min:1|max:200',
            'kurang'      => 'required|integer|min:1|max:200',
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

        ThresholdPoin::updateOrCreate(
            ['kelas_id' => $kelasId],
            [
                'sangat_baik' => $request->sangat_baik,
                'baik'        => $request->baik,
                'cukup'       => $request->cukup,
                'kurang'      => $request->kurang,
            ]
        );

        return redirect()->route('admin.threshold.index')
            ->with('success', 'Threshold poin kelas berhasil diperbarui');
    }
}