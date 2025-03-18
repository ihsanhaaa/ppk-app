<?php

namespace App\Http\Controllers;

use App\Models\BuktiTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuktiTugasController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'tugas_pegawai_id' => 'required|exists:tugas_pegawais,id',
            'link_eksternal' => 'nullable|url',
            'berkas_path' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Cek apakah salah satu diisi
        if (!$request->link_eksternal && !$request->hasFile('berkas_path')) {
            return response()->json(['error' => 'Harap masukkan link atau unggah berkas.'], 422);
        }

        $buktiTugas = new BuktiTugas();
        $buktiTugas->tugas_pegawai_id = $request->tugas_pegawai_id;
        $buktiTugas->link_eksternal = $request->link_eksternal;

        if ($request->hasFile('berkas_path')) {
            $buktiTugas->berkas_path = $request->file('berkas_path')->store('bukti_tugas', 'public');
        }

        $buktiTugas->save();

        return response()->json(['success' => true]);
    }


    public function getBuktiTugas($taskId)
    {
        $buktiTugas = BuktiTugas::where('tugas_id', $taskId)->get(['id', 'berkas_path', 'link_eksternal']);
        return response()->json($buktiTugas);
    }

    // Hapus Bukti Tugas
    public function hapusBukti($buktiId)
    {
        $bukti = BuktiTugas::findOrFail($buktiId);

        // Hapus file jika ada
        if ($bukti->berkas_path) {
            Storage::delete($bukti->berkas_path);
        }

        $bukti->delete();

        return response()->json(['success' => true]);
    }


}
