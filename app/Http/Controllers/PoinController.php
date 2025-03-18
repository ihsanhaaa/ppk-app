<?php

namespace App\Http\Controllers;

use App\Models\Poin;
use Illuminate\Http\Request;

class PoinController extends Controller
{
    public function index()
    {
        $poins = Poin::all();

        return view('poins.index', compact('poins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_poin' => 'required|string|max:100',
            'nilai' => 'required|integer',
        ]);
    
        $poin = new Poin();
        $poin->nama_poin = $request->nama_poin;
        $poin->nilai = $request->nilai;
        $poin->save();
    
        return redirect()->route('data-poin.index')->with('success', 'Data Poin berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_poin' => 'required|string|max:255',
            'nilai' => 'required|numeric',
        ]);

        $poin = Poin::findOrFail($id);
        $poin->update([
            'nama_poin' => $request->nama_poin,
            'nilai' => $request->nilai,
        ]);

        return redirect()->back()->with('success', 'Data poin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $poin = Poin::findOrFail($id);

        // Hapus data
        $poin->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('data-poin.index')->with('success', 'Data poin berhasil dihapus!');
    }
}
