<?php

use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\KonfigurasiController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware('RedirectIfAuth')->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginAdmin');
    })->name('loginAdmin');

    Route::post('/loginAdmin', [AuthController::class, 'loginAdmin']);

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

// Middleware untuk halaman dashboard setelah login
Route::middleware('auth:user')->group(function () {
    Route::get('/panel/dashboardAdmin', function () {
        return view('dashboard.admin');
    });
});

Route::middleware('auth:karyawan')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.karyawan');
    });
});

// admin
Route::middleware(['auth:user'])->group(function(){
    Route::get('/panel/dashboardAdmin', [DashboardController::class, 'dashboardAdmin']);
    Route::get('/panel/logout', [AuthController::class, 'logoutAdmin']);
    // Karyawan
    Route::get('/panel/karyawan', [KaryawanController::class, 'karyawan']);
    Route::post('/panel/karyawan/store', [KaryawanController::class, 'store']);

    Route::post('/panel/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/panel/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/panel/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    // Departement
    Route::get('/panel/departement', [DepartementController::class, 'index']);
    Route::post('/panel/departement/store', [DepartementController::class, 'store']);
    Route::post('panel/departement/edit', [DepartementController::class, 'edit']);
    Route::post('panel/departement/{kode_dept}/update', [DepartementController::class, 'update']);
    Route::post('panel/departement/{kode_dept}/delete', [DepartementController::class, 'delete']);

    // monitoring
    Route::get('/panel/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/panel/getPresensi', [PresensiController::class, 'getPresensi']);
    Route::post('/panel/showMaps', [PresensiController::class, 'showMaps']);
    // laporan
    Route::get('/panel/laporanPresensi', [PresensiController::class, 'report']);
    Route::post('/panel/cetakLaporan', [PresensiController::class, 'reportPrint']);
    // rekap
    Route::get('/panel/rekapPresensi', [PresensiController::class, 'rekap']);
    Route::post('/panel/cetakRekap', [PresensiController::class, 'rekapPrint']);
    // konfigurasi lokasi
    Route::get('/panel/konfigurasi', [KonfigurasiController::class, 'konfigurasiLokasi']);
    Route::post('/panel/updateLokasi', [KonfigurasiController::class, 'updateLokasi']);
    // perizinan
    Route::get('panel/perizinan', [PresensiController::class, 'perizinan']);
    Route::get('panel/perizinan/{pz_id}/status/{pz_status}', [PresensiController::class, 'perizinanStatus']);
});

// karyawan
Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/presensi', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    // profile
    Route::get('/editProfile', [PresensiController::class, "editProfile"])->name('editProfile');
    Route::post('/presensi/{nik}/updateProfile', [PresensiController::class, "updateProfile"]);
    // history
    Route::get('/presensi/history', [PresensiController::class, "history"]);
    Route::post('/getHistory', [PresensiController::class, "getHistory"]);
    // izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/createIzin', [PresensiController::class, 'createIzin']);
    Route::post('/presensi/storeIzin', [PresensiController::class, 'storeIzin']);
    Route::post('/presensi/isIzin', [PresensiController::class, 'isIzin']);
});

// Route::get('/test', function(){
//     return view('layouts.presensi');
// });