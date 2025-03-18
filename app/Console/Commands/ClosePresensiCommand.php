<?php

namespace App\Console\Commands;

use App\Models\PertemuanPresensi;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClosePresensiCommand extends Command
{
    protected $signature = 'presensi:close';
    protected $description = 'Tutup presensi otomatis setelah 100 menit';

    public function handle()
    {
        $expiredPresensis = PertemuanPresensi::where('status_presensi', 1)
            ->whereNotNull('presensi_started_at')
            ->where('presensi_started_at', '<', Carbon::now()->subMinutes(100))
            ->get();

        foreach ($expiredPresensis as $presensi) {
            $presensi->status_presensi = 0;
            $presensi->save();

            $this->info("Presensi untuk kelas ID {$presensi->data_kelas_id} ditutup otomatis.");
        }
    }
}