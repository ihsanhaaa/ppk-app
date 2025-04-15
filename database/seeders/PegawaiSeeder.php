<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nipy' => '001', 'nama_pegawai' => 'Nugraha Jaya Pangestu'],
            ['nipy' => '002', 'nama_pegawai' => 'Ramlah'],
            ['nipy' => '003', 'nama_pegawai' => 'Riko'],
            ['nipy' => '004', 'nama_pegawai' => 'Ihsan Haryansyah'],
            ['nipy' => '005', 'nama_pegawai' => 'Dea Novi Ariyanti'],
            ['nipy' => '006', 'nama_pegawai' => 'Indra Setiawan'],
            ['nipy' => '007', 'nama_pegawai' => 'Neny Nurahmah'],
            ['nipy' => '008', 'nama_pegawai' => 'Septi Purnama Sari'],
            ['nipy' => '009', 'nama_pegawai' => 'Jane Arantika'],
        ];

        DB::table('pegawais')->insert($data);
    }
}
