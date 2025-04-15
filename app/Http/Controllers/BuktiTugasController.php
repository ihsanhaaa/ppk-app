<?php

namespace App\Http\Controllers;

use App\Models\BuktiTugas;
use App\Models\TugasPegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            $path = 'bukti-pekerjaan/';
            $file = $request->file('berkas_path');
            $new_name = date('Ymd') . uniqid() . '.' . $file->getClientOriginalExtension(); // Ambil ekstensi asli
        
            // Pindahkan file ke folder public/bukti-pekerjaan
            $file->move(public_path($path), $new_name);
        
            // Simpan path ke database
            $buktiTugas->berkas_path = $path . $new_name;
        }        

        $buktiTugas->save();

        // Ambil data tugas dan user
        $tugas = TugasPegawai::find($request->tugas_pegawai_id);
        $user = User::find($tugas->user_id);

        // Format deadline
        $formattedDeadline = Carbon::parse($tugas->deadline)->locale('id')->isoFormat('D MMMM YYYY');

        // Pesan WA ke admin
        $pesan = "✅ Pengumpulan Tugas\n\nDosen/Pegawai *{$user->name}* telah menyelesaikan tugas:\n📌 *{$tugas->nama_tugas}*\n🗓 Deadline: {$formattedDeadline}\n\nCek detail di https://pegawai.kampusstikessambas.ac.id/\n\n-Don't Reply-";

        // Kirim WA ke admin
        $this->kirimWhatsappZenziva('089602461010', $pesan);

        return response()->json(['success' => true]);
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


    public function getBuktiTugas($taskId)
    {
        $buktiTugas = BuktiTugas::where('tugas_pegawai_id', $taskId)->get(['id', 'berkas_path', 'link_eksternal']);
        
        // dd($buktiTugas);

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


    public function update(Request $request, $id)
    {
        $request->validate([
            'link_eksternal' => 'required|url'
        ]);

        $bukti = BuktiTugas::findOrFail($id);
        $bukti->link_eksternal = $request->link_eksternal;
        $bukti->save();

        return response()->json(['success' => true, 'message' => 'Link eksternal berhasil diperbarui!']);
    }

    public function updateLink(Request $request, $id)
    {
        $request->validate([
            'link_eksternal' => 'required|url'
        ]);

        $bukti = BuktiTugas::findOrFail($id);
        $bukti->link_eksternal = $request->link_eksternal;
        $bukti->save();

        return response()->json(['success' => true, 'message' => 'Link eksternal berhasil diperbarui!']);
    }


}
