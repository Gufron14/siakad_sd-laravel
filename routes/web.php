<?php

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

Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('ppdb', PPDB::class)->name('ppdb');
    });

Route::middleware('guru')
    ->prefix('guru')
    ->group(function () {
        Route::get('input-nilai', InputNilai::class)->name('inputNilai');
        Route::get('absensi', Absensi::class)->name('absensi');
        Route::get('jadwal-pelajaran', JadwalPelajaran::class)->name('jadwalPelajaran');
        Route::get('mata-pelajaran', MataPelajaran::class)->name('mataPelajaran');
        Route::get('raport', Raport::class)->name('raport');
});

Route::get('/', Home::class)->name('/');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
});

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
