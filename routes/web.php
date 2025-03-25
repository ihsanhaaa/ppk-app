<?php

use App\Http\Controllers\BuktiTugasController;
use App\Http\Controllers\DataKelasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanPoinController;
use App\Http\Controllers\PengantarPKMController;
use App\Http\Controllers\PengesahanKetuaController;
use App\Http\Controllers\PermohonanIzinPenelitianController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\TugasPegawaiController;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    

    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/task', PoinController::class);

    Route::post('/validate-nipy', [PegawaiController::class, 'validateNIPY'])->name('validate-nipy');

    Route::get('/data-pegawai', [PegawaiController::class, 'index'])->name('data-pegawai.index');

    Route::get('/pekerjaan-pegawai/{id}', [TugasController::class, 'show'])->name('pekerjaan-pegawai.show');

    Route::post('/update-profile', [HomeController::class, 'updateProfile'])->name('update.profile');

    Route::post('/update-password', [HomeController::class, 'updatePassword'])->name('update.password');

    Route::get('semesters', [SemesterController::class, 'index'])->name('semesters.index');
    Route::post('semesters/store', [SemesterController::class, 'store'])->name('semesters.store');
    Route::post('semesters/{id}/activate', [SemesterController::class, 'activate'])->name('semesters.activate');
    Route::post('semesters/{id}/deactivate', [SemesterController::class, 'deactivate'])->name('semesters.deactivate');


    Route::resource('/pekerjaan-saya', TugasPegawaiController::class);
    Route::post('/set-pekerjaan-pegawai', [TugasController::class, 'store']);
    Route::patch('/tugas-pegawai/{tugas_pegawai}/status', [TugasPegawaiController::class, 'updateStatus']);

    Route::patch('/tugas-pegawai/{tugas_pegawai}', [TugasPegawaiController::class, 'update']);
    Route::delete('/tugas-pegawai/{tugas_pegawai}', [TugasPegawaiController::class, 'destroy']);



    Route::post('/bukti-tugas', [BuktiTugasController::class, 'store']);


    Route::get('/tugas-pegawai/{taskId}/bukti-tugas', [BuktiTugasController::class, 'getBuktiTugas']);
    Route::delete('/tugas-pegawai/bukti/{buktiId}', [BuktiTugasController::class, 'hapusBukti']);

    Route::put('/tugas-pegawai/update-points/{id}', [TugasPegawaiController::class, 'updatePoints']);

    Route::put('/update-bukti-tugas/{id}', [BuktiTugasController::class, 'updateLink']);


});


// google
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');  
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');

Auth::routes();


