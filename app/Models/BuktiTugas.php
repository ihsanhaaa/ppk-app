<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiTugas extends Model
{
    use HasFactory;

    protected $table = 'bukti_tugas';

    protected $guarded = ['id'];

    public function tugasPegawai()
    {
        return $this->belongsTo(TugasPegawai::class, 'tugas_pegawai_id');
    }
}
