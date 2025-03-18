<?php

namespace App\Providers;

use App\Models\PoinMahasiswa;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        // view()->composer('*', function ($view) {
        //     $countPengajuan = PoinMahasiswa::where('status', 'Pending')->count();
        //     $view->with('countPengajuan', $countPengajuan);
        // });
    }
}
