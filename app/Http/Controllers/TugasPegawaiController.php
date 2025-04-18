<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TugasPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil semester aktif sebagai default
        $semesterAktif = Semester::where('is_active', true)->first();

        // Ambil ID semester dari request, jika tidak ada gunakan semester aktif
        $selectedSemester = $request->input('semester_id', $semesterAktif ? $semesterAktif->id : null);

        // Ambil semua semester untuk dropdown
        $semesters = Semester::all();

        // Ambil data tugas berdasarkan semester yang dipilih
        $pekerjaanSayas = TugasPegawai::with('buktiTugas')
            ->where('user_id', Auth::id())
            ->where('semester_id', $selectedSemester) // Filter berdasarkan semester
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pekerjaan-saya.index', compact('pekerjaanSayas', 'semesters', 'selectedSemester'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'deadline' => 'required|date|after_or_equal:today'
        ]);

        $pegawaiID = Auth::user()->pegawai_id;

        if (!$pegawaiID) {
            return redirect()->back()->with('alert', 'Anda tidak terdaftar didatabase pegawai');
        }

        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('alert', 'Tidak ada semester yang aktif');
        }

        TugasPegawai::create([
            'nama_tugas' => $request->nama_tugas,
            'keterangan' => $request->keterangan,
            'deadline' => $request->deadline,
            'progres' => 'todo',
            'semester_id' => $semesterAktif->id,
            'user_id' => Auth::user()->id,
            'pegawai_id' => Auth::user()->pegawai_id,
            'created_at' => now(),
        ]);

        return redirect()->back();
    }

    public function updateStatus(Request $request, $id)
    {
        // dd($request);

        $tugasPegawai = TugasPegawai::findOrFail($id);
        $tugasPegawai->progres = $request->progres;
        $tugasPegawai->reviewer = Auth::user()->name;
        $tugasPegawai->updated_at = now();
        $tugasPegawai->save();

        return response()->json([
            'success' => true,
            'updated_at' => $tugasPegawai->updated_at->format('Y-m-d')
        ]);
    }

    public function update(Request $request, TugasPegawai $tugasPegawai)
    {
        // dd($tugasPegawai);
        
        $request->validate([
            'nama_tugas' => 'string|max:255',
            'deadline' => 'date|after_or_equal:today',
            'prioritas' => 'required|in:penting,normal,rendah'
        ]);

        $tugasPegawai->update([
            'nama_tugas' => $request->nama_tugas,
            'deadline' => $request->deadline,
            'prioritas' => $request->prioritas
        ]);

        return response()->json(['success' => true]);
    }


    public function destroy(TugasPegawai $tugasPegawai)
    {
        // dd($tugasPegawai);

        $tugasPegawai->delete();

        return response()->json(['success' => true]);
    }

    public function updatePoints(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer|min:0'
        ]);

        $tugasPegawai = TugasPegawai::findOrFail($id);
        $tugasPegawai->update(['points' => $request->points]);

        return response()->json(['success' => true]);
    }

}
