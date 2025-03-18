<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasPegawai extends Model
{
    use HasFactory;

    protected $table = 'tugas_pegawais';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDeadlineAttribute()
    {
        return $this->deadline ? Carbon::parse($this->deadline)->translatedFormat('d F Y') : '-';
    }

    public function buktiTugas()
    {
        return $this->hasMany(BuktiTugas::class, 'tugas_pegawai_id');
    }
}
