<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Semester;
use App\Models\Tugas;
use App\Models\TugasPegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'user_id' => 'required',
            'pegawai_id' => 'required',
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
            'user_id' => $request->user_id,
            'pegawai_id' => $request->pegawai_id,
            'created_at' => now(),
        ]);

        $user = User::find($request->user_id);

        // ✅ Pastikan user dan no_hp tersedia
        if ($user && $user->no_hp) {
            $formattedDeadline = \Carbon\Carbon::parse($request->deadline)->locale('id')->isoFormat('D MMMM YYYY');
        
            // Menambahkan link dan teks Don't Reply di bagian bawah
            $pesan = "📢 Hai {$user->name},\n\nAnda punya tugas baru:\n📌 *{$request->nama_tugas}*\n🗓 Deadline: {$formattedDeadline}\n\nSilakan cek di https://pegawai.kampusstikessambas.ac.id/\n\n-Don't Reply-!";
        
            $this->kirimWhatsappZenziva($user->no_hp, $pesan);
        }
        

        return redirect()->back();
    }

    protected function kirimWhatsappZenziva($nomor, $pesan)
    {
        $userkey = env('ZENZIVA_USERKEY');
        $passkey = env('ZENZIVA_PASSKEY');

        $response = Http::asForm()->post('https://console.zenziva.net/wareguler/api/sendWA/', [
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to'      => preg_replace('/[^0-9]/', '', $nomor),
            'message' => $pesan,
        ]);

        return $response->body();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = User::where('pegawai_id', $pegawai->id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna belum terverifikasi.');
        }
    
        // Ambil semester aktif sebagai default
        $semesterAktif = Semester::where('is_active', true)->first();
        $semesterId = request('semester_id', $semesterAktif ? $semesterAktif->id : null);
    
        // Ambil semua tugas berdasarkan pegawai yang dipilih dan semester yang dipilih
        $pekerjaanPegawais = TugasPegawai::with('buktiTugas')
            ->where('user_id', $user->id)
            ->when($semesterId, function ($query) use ($semesterId) {
                return $query->where('semester_id', $semesterId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Ambil semua semester untuk opsi filter
        $semesters = Semester::all();
    
        return view('pegawai.show', compact('pekerjaanPegawais', 'pegawai', 'user', 'semesters', 'semesterId'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        //
    }
}
