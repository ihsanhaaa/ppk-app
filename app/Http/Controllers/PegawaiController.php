<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::withCount('tugasPegawai')->get();
        // $mahasiswas = Mahasiswa::with('user')->get();

        // dd($mahasiswas);

        return view('pegawai.index', compact('pegawais'));
    }

    public function validateNIPY(Request $request)
    {
        $request->validate([
            'nipy' => 'required|string',
        ]);

        
        $nipy = $request->input('nipy');
        $pegawai = Pegawai::where('nipy', $nipy)->first();
        
        if (!$pegawai) {
            return back()->withErrors(['nipy' => 'NIPY anda tidak terdaftar.']);
        }
    
        // Cek apakah pegawai_id sudah digunakan oleh akun lain
        $existingUser = User::where('pegawai_id', $pegawai->id)->first();
        if ($existingUser && $existingUser->id !== auth()->id()) {
            return back()->withErrors(['nipy' => 'NIPY ini sudah terhubung dengan akun lain.']);
        }
    
        // Simpan pegawai_id ke akun user saat ini
        $user = auth()->user();
        $user->update(['pegawai_id' => $pegawai->id]);

        return redirect()->route('home')->with('success', 'NIPY terdaftar, berhasil melakukan verifikasi!');
    }
}
