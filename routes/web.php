<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CetakLaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return view('welcome');
});

Route::get('tanda-terima-service/{no_service}', [CetakLaporanController::class, 'tandaTerimaService']);
Route::get('nota-service/{no_service}', [CetakLaporanController::class, 'notaService']);
Route::get('laporan-pengembalian-barang/{dari}/{sampai}/{cabang}/{shift}/{admin}', [CetakLaporanController::class, 'laporanPengembalian']);
Route::get('laporan-arus-kas/{dari}/{sampai}/{cabang}/{shift}/{admin}', [CetakLaporanController::class, 'laporanArusKas']);
Route::get('surat-jalan/{no_surat_jalan}', [CetakLaporanController::class, 'suratJalan']);