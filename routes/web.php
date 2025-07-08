<?php

use App\Livewire\Admin\PPDB\Detail;
use App\Livewire\Home;
use App\Livewire\Dashboard;
use App\Livewire\Admin\PPDB;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Raport;
use App\Livewire\Admin\Absensi;
use App\Livewire\Admin\InputNilai;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\MataPelajaran;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\JadwalPelajaran;
use App\Livewire\Admin\PPDB\Create;
use App\Livewire\Admin\PPDB\DaftarPPDB;
use App\Livewire\Admin\PPDB\Edit;

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

// Admin Routes - Accessible by Admin, Staff, Guru with permissions
Route::middleware(['role:admin|staff|guru'])->group(function () {

    Route::get('admin/dashboard', Dashboard::class)->name('dashboard');
    Route::get('dashboard/jadwal-pelajaran', JadwalPelajaran::class)->name('jadwalPelajaran');

    Route::prefix('dashboard/staff')->group(function () {
        Route::get('ppdb', DaftarPPDB::class)->name('ppdb');
        Route::get('tambah-ppdb', Create::class)->name('ppdb.create');
        Route::get('update-ppdb/{id}', Edit::class)->name('ppdb.update');
        Route::get('detail-ppdb/{id}', Detail::class)->name('ppdb.detail');
    });

    // Guru Routes - Specific Permissions
    Route::prefix('dashboard/guru')->group(function () {
        Route::middleware('permission:input.nilai')->get('input-nilai', InputNilai::class)->name('inputNilai');

        Route::middleware('permission:input.absensi')->get('absensi', Absensi::class)->name('absensi');


        Route::middleware('permission:lihat.mapel')->get('mata-pelajaran', MataPelajaran::class)->name('mataPelajaran');

        Route::middleware('permission:lihat.raport')->get('raport', Raport::class)->name('raport');
    });
});

Route::get('/', Home::class)->name('/');
Route::get('ppdb', \App\Livewire\PPDB::class)->name('pendaftaran.pdb');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
});

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
