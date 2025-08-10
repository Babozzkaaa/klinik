<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\KunjunganTindakanController;
use App\Http\Controllers\KunjunganObatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});
// Route::middleware(['auth'])->get('/dashboard', function () {
//     $user = auth()->user();
//     if ($user->hasRole('admin')) {
//         return view('dashboard.admin');
//     } elseif ($user->hasRole('petugas')) {
//         return view('dashboard.petugas');
//     } elseif ($user->hasRole('dokter')) {
//         return view('dashboard.dokter');
//     } elseif ($user->hasRole('kasir')) {
//         return view('dashboard.kasir');
//     }
//     abort(403);
// })->name('dashboard');
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
    
    Route::prefix('obat')->group(function () {
        Route::get('/', [ObatController::class, 'index'])
            ->middleware('permission:obat.read')
            ->name('obat.index');
            
        Route::get('/create', [ObatController::class, 'create'])
            ->middleware('permission:obat.create')
            ->name('obat.create');
            
        Route::post('/', [ObatController::class, 'store'])
            ->middleware('permission:obat.create')
            ->name('obat.store');
            
        Route::get('/{obat}', [ObatController::class, 'show'])
            ->middleware('permission:obat.read')
            ->name('obat.show');
            
        Route::get('/{obat}/edit', [ObatController::class, 'edit'])
            ->middleware('permission:obat.update')
            ->name('obat.edit');
            
        Route::put('/{obat}', [ObatController::class, 'update'])
            ->middleware('permission:obat.update')
            ->name('obat.update');
            
        Route::delete('/{obat}', [ObatController::class, 'destroy'])
            ->middleware('permission:obat.delete')
            ->name('obat.destroy');
    });
    
    Route::prefix('provinsi')->group(function () {
        Route::get('/', [ProvinsiController::class, 'index'])
            ->middleware('permission:provinsi.read')
            ->name('provinsi.index');
            
        Route::get('/create', [ProvinsiController::class, 'create'])
            ->middleware('permission:provinsi.create')
            ->name('provinsi.create');
            
        Route::post('/', [ProvinsiController::class, 'store'])
            ->middleware('permission:provinsi.create')
            ->name('provinsi.store');
            
        Route::get('/{provinsi}', [ProvinsiController::class, 'show'])
            ->middleware('permission:provinsi.read')
            ->name('provinsi.show');
            
        Route::get('/{provinsi}/edit', [ProvinsiController::class, 'edit'])
            ->middleware('permission:provinsi.update')
            ->name('provinsi.edit');
            
        Route::put('/{provinsi}', [ProvinsiController::class, 'update'])
            ->middleware('permission:provinsi.update')
            ->name('provinsi.update');
            
        Route::delete('/{provinsi}', [ProvinsiController::class, 'destroy'])
            ->middleware('permission:provinsi.delete')
            ->name('provinsi.destroy');
    });
    
    Route::prefix('kabupaten')->group(function () {
        Route::get('/', [KabupatenController::class, 'index'])
            ->middleware('permission:kabupaten.read')
            ->name('kabupaten.index');
            
        Route::get('/create', [KabupatenController::class, 'create'])
            ->middleware('permission:kabupaten.create')
            ->name('kabupaten.create');
            
        Route::post('/', [KabupatenController::class, 'store'])
            ->middleware('permission:kabupaten.create')
            ->name('kabupaten.store');
            
        Route::get('/{kabupaten}', [KabupatenController::class, 'show'])
            ->middleware('permission:kabupaten.read')
            ->name('kabupaten.show');
            
        Route::get('/{kabupaten}/edit', [KabupatenController::class, 'edit'])
            ->middleware('permission:kabupaten.update')
            ->name('kabupaten.edit');
            
        Route::put('/{kabupaten}', [KabupatenController::class, 'update'])
            ->middleware('permission:kabupaten.update')
            ->name('kabupaten.update');
            
        Route::delete('/{kabupaten}', [KabupatenController::class, 'destroy'])
            ->middleware('permission:kabupaten.delete')
            ->name('kabupaten.destroy');
    });
    
    Route::prefix('pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])
            ->middleware('permission:pegawai.read')
            ->name('pegawai.index');
            
        Route::get('/create', [PegawaiController::class, 'create'])
            ->middleware('permission:pegawai.create')
            ->name('pegawai.create');
            
        Route::post('/', [PegawaiController::class, 'store'])
            ->middleware('permission:pegawai.create')
            ->name('pegawai.store');
            
        Route::get('/{pegawai}', [PegawaiController::class, 'show'])
            ->middleware('permission:pegawai.read')
            ->name('pegawai.show');
            
        Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])
            ->middleware('permission:pegawai.update')
            ->name('pegawai.edit');
            
        Route::put('/{pegawai}', [PegawaiController::class, 'update'])
            ->middleware('permission:pegawai.update')
            ->name('pegawai.update');
            
        Route::delete('/{pegawai}', [PegawaiController::class, 'destroy'])
            ->middleware('permission:pegawai.delete')
            ->name('pegawai.destroy');
    });
    
    Route::prefix('tindakan')->group(function () {
        Route::get('/', [TindakanController::class, 'index'])
            ->middleware('permission:tindakan.read')
            ->name('tindakan.index');
            
        Route::get('/create', [TindakanController::class, 'create'])
            ->middleware('permission:tindakan.create')
            ->name('tindakan.create');
            
        Route::post('/', [TindakanController::class, 'store'])
            ->middleware('permission:tindakan.create')
            ->name('tindakan.store');
            
        Route::get('/{tindakan}', [TindakanController::class, 'show'])
            ->middleware('permission:tindakan.read')
            ->name('tindakan.show');
            
        Route::get('/{tindakan}/edit', [TindakanController::class, 'edit'])
            ->middleware('permission:tindakan.update')
            ->name('tindakan.edit');
            
        Route::put('/{tindakan}', [TindakanController::class, 'update'])
            ->middleware('permission:tindakan.update')
            ->name('tindakan.update');
            
        Route::delete('/{tindakan}', [TindakanController::class, 'destroy'])
            ->middleware('permission:tindakan.delete')
            ->name('tindakan.destroy');
    });
    
    Route::prefix('pasien')->group(function () {
        Route::get('/', [PasienController::class, 'index'])
            ->middleware('permission:pasien.read')
            ->name('pasien.index');
            
        Route::get('/create', [PasienController::class, 'create'])
            ->middleware('permission:pasien.create')
            ->name('pasien.create');
            
        Route::post('/', [PasienController::class, 'store'])
            ->middleware('permission:pasien.create')
            ->name('pasien.store');
            
        Route::get('/{pasien}', [PasienController::class, 'show'])
            ->middleware('permission:pasien.read')
            ->name('pasien.show');
            
        Route::get('/{pasien}/edit', [PasienController::class, 'edit'])
            ->middleware('permission:pasien.update')
            ->name('pasien.edit');
            
        Route::put('/{pasien}', [PasienController::class, 'update'])
            ->middleware('permission:pasien.update')
            ->name('pasien.update');
            
        Route::delete('/{pasien}', [PasienController::class, 'destroy'])
            ->middleware('permission:pasien.delete')
            ->name('pasien.destroy');
    });
    
    Route::prefix('kunjungan')->group(function () {
        Route::get('/', [KunjunganController::class, 'index'])
            ->middleware('permission:kunjungan.read')
            ->name('kunjungan.index');
            
        Route::get('/create', [KunjunganController::class, 'create'])
            ->middleware('permission:kunjungan.create')
            ->name('kunjungan.create');
            
        Route::post('/', [KunjunganController::class, 'store'])
            ->middleware('permission:kunjungan.create')
            ->name('kunjungan.store');
            
        Route::get('/{kunjungan}', [KunjunganController::class, 'show'])
            ->middleware('permission:kunjungan.read')
            ->name('kunjungan.show');
            
        Route::get('/{kunjungan}/edit', [KunjunganController::class, 'edit'])
            ->middleware('permission:kunjungan.update')
            ->name('kunjungan.edit');
            
        Route::put('/{kunjungan}', [KunjunganController::class, 'update'])
            ->middleware('permission:kunjungan.update')
            ->name('kunjungan.update');
            
        Route::delete('/{kunjungan}', [KunjunganController::class, 'destroy'])
            ->middleware('permission:kunjungan.delete')
            ->name('kunjungan.destroy');
    });
    
    Route::prefix('kunjungan-tindakan')->group(function () {
        Route::get('/', [KunjunganTindakanController::class, 'index'])
            ->middleware('permission:kunjungan-tindakan.read')
            ->name('kunjungan-tindakan.index');
            
        Route::get('/create', [KunjunganTindakanController::class, 'create'])
            ->middleware('permission:kunjungan-tindakan.create')
            ->name('kunjungan-tindakan.create');
            
        Route::post('/', [KunjunganTindakanController::class, 'store'])
            ->middleware('permission:kunjungan-tindakan.create')
            ->name('kunjungan-tindakan.store');
            
        Route::get('/{kunjunganTindakan}', [KunjunganTindakanController::class, 'show'])
            ->middleware('permission:kunjungan-tindakan.read')
            ->name('kunjungan-tindakan.show');
            
        Route::get('/{kunjunganTindakan}/edit', [KunjunganTindakanController::class, 'edit'])
            ->middleware('permission:kunjungan-tindakan.update')
            ->name('kunjungan-tindakan.edit');
            
        Route::put('/{kunjunganTindakan}', [KunjunganTindakanController::class, 'update'])
            ->middleware('permission:kunjungan-tindakan.update')
            ->name('kunjungan-tindakan.update');
            
        Route::delete('/{kunjunganTindakan}', [KunjunganTindakanController::class, 'destroy'])
            ->middleware('permission:kunjungan-tindakan.delete')
            ->name('kunjungan-tindakan.destroy');

        Route::get('/api/tindakan/{tindakan}/tarif', [KunjunganTindakanController::class, 'getTindakanTarif'])
            ->middleware('permission:kunjungan-tindakan.create')
            ->name('kunjungan-tindakan.get-tarif');
    });
    
    Route::prefix('kunjungan-obat')->group(function () {
        Route::get('/', [KunjunganObatController::class, 'index'])
            ->middleware('permission:kunjungan-obat.read')
            ->name('kunjungan-obat.index');
            
        Route::get('/create', [KunjunganObatController::class, 'create'])
            ->middleware('permission:kunjungan-obat.create')
            ->name('kunjungan-obat.create');
            
        Route::post('/', [KunjunganObatController::class, 'store'])
            ->middleware('permission:kunjungan-obat.create')
            ->name('kunjungan-obat.store');
            
        Route::get('/{kunjunganObat}', [KunjunganObatController::class, 'show'])
            ->middleware('permission:kunjungan-obat.read')
            ->name('kunjungan-obat.show');
            
        Route::get('/{kunjunganObat}/edit', [KunjunganObatController::class, 'edit'])
            ->middleware('permission:kunjungan-obat.update')
            ->name('kunjungan-obat.edit');
            
        Route::put('/{kunjunganObat}', [KunjunganObatController::class, 'update'])
            ->middleware('permission:kunjungan-obat.update')
            ->name('kunjungan-obat.update');
            
        Route::delete('/{kunjunganObat}', [KunjunganObatController::class, 'destroy'])
            ->middleware('permission:kunjungan-obat.delete')
            ->name('kunjungan-obat.destroy');

        Route::get('/api/obat/{obat}/tarif', [KunjunganObatController::class, 'getObatTarif'])
            ->middleware('permission:kunjungan-obat.create')
            ->name('kunjungan-obat.get-tarif');
    });
    
    Route::prefix('kunjungan-obat')->name('kunjungan-obat.')->group(function () {
        Route::get('/', [KunjunganObatController::class, 'index'])
            ->middleware('permission:kunjungan-obat.read')
            ->name('index');
            
        Route::get('/create', [KunjunganObatController::class, 'create'])
            ->middleware('permission:kunjungan-obat.create')
            ->name('create');
            
        Route::post('/', [KunjunganObatController::class, 'store'])
            ->middleware('permission:kunjungan-obat.create')
            ->name('store');
            
        Route::get('/{kunjunganObat}', [KunjunganObatController::class, 'show'])
            ->middleware('permission:kunjungan-obat.read')
            ->name('show');
            
        Route::get('/{kunjunganObat}/edit', [KunjunganObatController::class, 'edit'])
            ->middleware('permission:kunjungan-obat.update')
            ->name('edit');
            
        Route::put('/{kunjunganObat}', [KunjunganObatController::class, 'update'])
            ->middleware('permission:kunjungan-obat.update')
            ->name('update');
            
        Route::delete('/{kunjunganObat}', [KunjunganObatController::class, 'destroy'])
            ->middleware('permission:kunjungan-obat.delete')
            ->name('destroy');
    });

    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/{pembayaran}/export-pdf', [PembayaranController::class, 'exportPdf'])
            ->middleware('permission:pembayaran.read')
            ->name('export-pdf');
        Route::get('/export-all-pdf', [PembayaranController::class, 'exportAllPdf'])
            ->middleware('permission:pembayaran.read')
            ->name('export-all-pdf');
        Route::get('/kunjungan-detail', [PembayaranController::class, 'getKunjunganDetail'])
            ->name('kunjungan-detail');
            
        Route::get('/', [PembayaranController::class, 'index'])
            ->middleware('permission:pembayaran.read')
            ->name('index');
            
        Route::get('/create', [PembayaranController::class, 'create'])
            ->middleware('permission:pembayaran.create')
            ->name('create');
            
        Route::post('/', [PembayaranController::class, 'store'])
            ->middleware('permission:pembayaran.create')
            ->name('store');
            
        Route::get('/{pembayaran}', [PembayaranController::class, 'show'])
            ->middleware('permission:pembayaran.read')
            ->name('show');
            
        Route::get('/{pembayaran}/edit', [PembayaranController::class, 'edit'])
            ->middleware('permission:pembayaran.update')
            ->name('edit');
            
        Route::put('/{pembayaran}', [PembayaranController::class, 'update'])
            ->middleware('permission:pembayaran.update')
            ->name('update');
            
        Route::delete('/{pembayaran}', [PembayaranController::class, 'destroy'])
            ->middleware('permission:pembayaran.delete')
            ->name('destroy');
    });

    Route::prefix('admin')->name('admin.')->middleware('permission:admin_dashboard')->group(function () {
        Route::resource('users', UserController::class);
        
        Route::resource('roles', RoleController::class);
        
        Route::resource('permissions', PermissionController::class);
    });
});
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});