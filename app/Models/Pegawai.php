<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';

    protected $guarded = ['id'];

    public function user()
    { 
        return $this->hasMany(User::class); 
    }

    public function tugas()
    {
        return $this->hasMany(TugasPegawai::class, 'pegawai_id');
    }

    public function tugasPegawai()
    {
        return $this->hasMany(TugasPegawai::class, 'user_id', 'id');
    }

}
