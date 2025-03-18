<?php

namespace App\Http\Controllers;

use App\Models\AlatMasuk;
use App\Models\BahanMasuk;
use App\Models\Obat;
use App\Models\PengajuanBahan;
use App\Models\PoinMahasiswa;
use App\Models\Semester;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Surat;
use App\Models\TugasPegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
    
        // Ambil total poin dengan status Approved
        $totalPoinSaya = TugasPegawai::where('pegawai_id', $user->pegawai_id)
            // ->where('status', 'Approved')
            ->sum('points');

        return view('home', compact('totalPoinSaya'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

}
