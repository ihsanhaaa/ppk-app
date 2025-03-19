<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Tugas;
use App\Models\TugasPegawai;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Ambil semua tugas berdasarkan pegawai yang dipilih ($pegawai)
        $pekerjaanPegawais = TugasPegawai::with('buktiTugas')
            ->where('user_id', $id) // Mengambil tugas sesuai pegawai
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.show', compact('pekerjaanPegawais', 'pegawai'));
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
