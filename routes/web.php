<?php

use App\Livewire\Admin\Absensi;
use App\Livewire\Admin\InputNilai;
use App\Livewire\Admin\JadwalPelajaran;
use App\Livewire\Admin\MataPelajaran;
use App\Livewire\Admin\PPDB;
use App\Livewire\Admin\Raport;
use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Dashboard;
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


Route::prefix('admin')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('inputNilai', InputNilai::class)->name('inputNilai');
        Route::get('absensi', Absensi::class)->name('absensi');
        Route::get('jadwal-pelajaran', JadwalPelajaran::class)->name('jadwalPelajaran');
        Route::get('mata-pelajaran', MataPelajaran::class)->name('mataPelajaran');
        Route::get('raport', Raport::class)->name('raport');
        Route::get('ppdb', PPDB::class)->name('ppdb');
    });

Route::get('/', Home::class)->name('/');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
});