<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BarangJasaController;
use App\Http\Controllers\Api\MerekController;
use App\Http\Controllers\Api\TipeController;
use App\Http\Controllers\Api\KondisiController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\CabangController;
use App\Http\Controllers\Api\StikerController;
use App\Http\Controllers\Api\RekeningController;
use App\Http\Controllers\Api\KelengkapanController;
use App\Http\Controllers\Api\PenerimaanBarangController;
use App\Http\Controllers\Api\PengerjaanController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\ArusKasController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\DetailPengerjaanController;
use App\Http\Controllers\Api\TeknisiPjController;
use App\Http\Controllers\Api\PengirimanBarangController;
use App\Http\Controllers\Api\PenerimaanPengirimanController;
use App\Http\Controllers\Api\TagihanPartnerController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Api\SandiTransaksiController;
use App\Http\Controllers\Api\ListKelengkapanPenerimaanBarangServiceController;
use App\Http\Controllers\Api\ListPengirimanController;
use App\Http\Controllers\Api\PengajuanPembelianBarangSecondController;
use App\Http\Controllers\Api\LogAktivitasController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\ReviewKepuasanPelangganController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:user-api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('user/my/profile/enc/{id}', [UserController::class, 'getCurrentEncryptedUser']);
Route::put('user/reset-password/{id}', [UserController::class, 'resetPassword']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'getUserById']);
    Route::get('user/name/{name}', [UserController::class, 'getUserByName']);
    Route::get('user/my/profile', [UserController::class, 'getCurrentUser']);
    Route::get('user/role/{role}', [UserController::class, 'getUserByRole']);
    Route::get('user/role/{role}/{cabang}', [UserController::class, 'getUserByRoleAndCabang']);
    Route::get('user/rating-admin/service', [UserController::class, 'getRatingAdmin']);
    Route::get('user/rating-teknisi/service', [UserController::class, 'getRatingTeknisi']);
    Route::post('user', [UserController::class, 'create']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);

    Route::get('bj', [BarangJasaController::class, 'index']);
    Route::get('bj/{id}', [BarangJasaController::class, 'getDataById']);
    Route::get('bj/name/{name}', [BarangJasaController::class, 'getDataByName']);
    Route::get('bj/jenis/{jenis}', [BarangJasaController::class, 'getDataByJenis']);
    Route::post('bj', [BarangJasaController::class, 'create']);
    Route::put('bj/{id}', [BarangJasaController::class, 'update']);
    Route::delete('bj/{id}', [BarangJasaController::class, 'delete']);

    Route::get('merek', [MerekController::class, 'index']);
    Route::get('merek/{id}', [MerekController::class, 'getDataById']);
    Route::get('merek/name/{name}', [MerekController::class, 'getDataByName']);
    Route::get('merek/kategori/{kategori}', [MerekController::class, 'getDataByKategori']);
    Route::post('merek', [MerekController::class, 'create']);
    Route::put('merek/{id}', [MerekController::class, 'update']);
    Route::delete('merek/{id}', [MerekController::class, 'delete']);

    Route::get('tipe', [TipeController::class, 'index']);
    Route::get('tipe/{id}', [TipeController::class, 'getDataById']);
    Route::get('tipe/name/{name}', [TipeController::class, 'getDataByName']);
    Route::get('tipe/merek/{merek}', [TipeController::class, 'getDataByMerek']);
    Route::post('tipe', [TipeController::class, 'create']);
    Route::put('tipe/{id}', [TipeController::class, 'update']);
    Route::delete('tipe/{id}', [TipeController::class, 'delete']);

    Route::get('kondisi', [KondisiController::class, 'index']);
    Route::get('kondisi/{kondisi}', [KondisiController::class, 'getDataById']);
    Route::get('kondisi/name/{name}', [KondisiController::class, 'getDataByName']);
    Route::get('kondisi/keyword/{keyword}', [KondisiController::class, 'getDataBasedOnKeyword']);
    Route::post('kondisi', [KondisiController::class, 'create']);
    Route::put('kondisi/{id}', [KondisiController::class, 'update']);
    Route::delete('kondisi/{id}', [KondisiController::class, 'delete']);

    Route::get('customer', [CustomerController::class, 'index']);
    Route::get('customer/{id}', [CustomerController::class, 'getDataById']);
    Route::get('customer/name/{name}', [CustomerController::class, 'getDataByName']);
    Route::get('customer/like/{keyword}', [CustomerController::class, 'getDataBasedOnKeyword']);
    Route::get('customer/my/profile', [CustomerController::class, 'getCurrentUser']);
    Route::post('customer', [CustomerController::class, 'create']);
    Route::put('customer/{id}', [CustomerController::class, 'update']);
    Route::delete('customer/{id}', [CustomerController::class, 'delete']);

    Route::get('partner', [PartnerController::class, 'index']);
    Route::get('partner/{id}', [PartnerController::class, 'getDataById']);
    Route::get('partner/name/{name}', [PartnerController::class, 'getDataByName']);
    Route::post('partner', [PartnerController::class, 'create']);
    Route::put('partner/{id}', [PartnerController::class, 'update']);
    Route::delete('partner/{id}', [PartnerController::class, 'delete']);

    Route::get('cabang', [CabangController::class, 'index']);
    Route::get('cabang/{id}', [CabangController::class, 'getDataById']);
    Route::get('cabang/name/{name}', [CabangController::class, 'getDataByName']);
    Route::post('cabang', [CabangController::class, 'create']);
    Route::put('cabang/{id}', [CabangController::class, 'update']);
    Route::delete('cabang/{id}', [CabangController::class, 'delete']);

    Route::get('stiker', [StikerController::class, 'index']);
    Route::get('stiker/{id}', [StikerController::class, 'getDataById']);
    Route::get('stiker/name/{name}', [StikerController::class, 'getDataByName']);
    Route::post('stiker', [StikerController::class, 'create']);
    Route::put('stiker/{id}', [StikerController::class, 'update']);
    Route::delete('stiker/{id}', [StikerController::class, 'delete']);

    Route::get('problem', [ProblemController::class, 'index']);
    Route::get('problem/{id}', [ProblemController::class, 'getDataById']);
    Route::get('problem/name/{name}', [ProblemController::class, 'getDataByName']);
    Route::get('problem/keyword/{keyword}', [ProblemController::class, 'getDataBasedOnKeyword']);
    Route::post('problem', [ProblemController::class, 'create']);
    Route::put('problem/{id}', [ProblemController::class, 'update']);
    Route::delete('problem/{id}', [ProblemController::class, 'delete']);

    Route::get('rekening', [RekeningController::class, 'index']);
    Route::get('rekening/{id}', [RekeningController::class, 'getDataById']);
    Route::get('rekening/name/{name}', [RekeningController::class, 'getDataByName']);
    Route::post('rekening', [RekeningController::class, 'create']);
    Route::put('rekening/{id}', [RekeningController::class, 'update']);
    Route::delete('rekening/{id}', [RekeningController::class, 'delete']);

    Route::get('kelengkapan', [KelengkapanController::class, 'index']);
    Route::get('kelengkapan/{id}', [KelengkapanController::class, 'getDataById']);
    Route::get('kelengkapan/name/{name}', [KelengkapanController::class, 'getDataByName']);
    Route::get('kelengkapan/keyword/{keyword}', [KelengkapanController::class, 'getDataBasedOnKeyword']);
    Route::post('kelengkapan', [KelengkapanController::class, 'create']);
    Route::put('kelengkapan/{id}', [KelengkapanController::class, 'update']);
    Route::delete('kelengkapan/{id}', [KelengkapanController::class, 'delete']);

    Route::get('sandi-transaksi', [SandiTransaksiController::class, 'index']);
    Route::get('sandi-transaksi/{id}', [SandiTransaksiController::class, 'getDataById']);
    Route::get('sandi-transaksi/name/{name}', [SandiTransaksiController::class, 'getDataByName']);
    Route::get('sandi-transaksi/transaksi/pengembalian', [SandiTransaksiController::class, 'getDataForPengembalian']);
    Route::post('sandi-transaksi', [SandiTransaksiController::class, 'create']);
    Route::put('sandi-transaksi/{id}', [SandiTransaksiController::class, 'update']);
    Route::delete('sandi-transaksi/{id}', [SandiTransaksiController::class, 'delete']);

    Route::get('penerimaan-barang', [PenerimaanBarangController::class, 'index']);
    Route::get('penerimaan-barang/{no_service_penerimaan}', [PenerimaanBarangController::class, 'getDataById']);
    Route::get('penerimaan-barang/user/{id_admin}', [PenerimaanBarangController::class, 'getDataByIdAdmin']);
    Route::get('penerimaan-barang/cabang/{id_cabang}', [PenerimaanBarangController::class, 'getDataByIdCabang']);
    Route::get('penerimaan-barang/customer/{id_customer}', [PenerimaanBarangController::class, 'getDataByIdCustomer']);
    Route::post('penerimaan-barang', [PenerimaanBarangController::class, 'create']);
    Route::put('penerimaan-barang/{no_service_penerimaan}', [PenerimaanBarangController::class, 'update']);
    Route::post('penerimaan-barang/upload-video/{no_service_penerimaan}', [PenerimaanBarangController::class, 'uploadVideo']);
    Route::delete('penerimaan-barang/{no_service_penerimaan}', [PenerimaanBarangController::class, 'delete']);

    Route::get('pengerjaan', [PengerjaanController::class, 'index']);
    Route::get('pengerjaan/{no_pengerjaan}', [PengerjaanController::class, 'getDataById']);
    Route::get('pengerjaan/{status_pengerjaan}/{id_partner}', [PengerjaanController::class, 'getDataByStatusPengerjaanAndPartner']);
    Route::get('pengerjaan/barang-jasa/teknisi/{id_teknisi}', [PengerjaanController::class, 'getDataByIdTeknisi']);
    Route::get('pengerjaan/no-service/{no_service}', [PengerjaanController::class, 'getDataByNoService']);
    Route::post('pengerjaan', [PengerjaanController::class, 'create']);
    Route::post('pengerjaan/send-email', [PengerjaanController::class, 'sendEmailNotification']);
    Route::put('pengerjaan/{no_pengerjaan}', [PengerjaanController::class, 'update']);
    Route::put('pengerjaan/no-service/{no_service}', [PengerjaanController::class, 'updateByNoService']);
    Route::delete('pengerjaan/{no_service}', [PengerjaanController::class, 'delete']);

    Route::get('pembayaran', [PembayaranController::class, 'index']);
    Route::get('pembayaran/{no_pembayaran}', [PembayaranController::class, 'getDataById']);
    Route::get('pembayaran/no-service/{no_service}', [PembayaranController::class, 'getDataByNoService']);
    Route::get('pembayaran/cabang/{cabang}', [PembayaranController::class, 'getDataByCabang']);
    Route::post('pembayaran', [PembayaranController::class, 'create']);
    Route::put('pembayaran/{no_pembayaran}', [PembayaranController::class, 'update']);
    Route::delete('pembayaran/{no_pembayaran}', [PembayaranController::class, 'delete']);

    Route::get('arus-kas', [ArusKasController::class, 'index']);
    Route::get('arus-kas/{no_bukti}', [ArusKasController::class, 'getDataById']);
    Route::get('arus-kas/laporan/count/{cabang}', [ArusKasController::class, 'getLaporan']);
    Route::get('arus-kas/admin/{id_admin}', [ArusKasController::class, 'getDataByIdAdmin']);
    Route::get('arus-kas/no-service/{no_service}', [ArusKasController::class, 'getDataByNoService']);
    Route::get('arus-kas/no-pembayaran/{no_pembayaran}', [ArusKasController::class, 'getDataByNoPembayaran']);
    Route::get('arus-kas/no-pengembalian/{no_pengembalian}', [ArusKasController::class, 'getDataByNoPengembalian']);
    Route::post('arus-kas', [ArusKasController::class, 'create']);
    Route::put('arus-kas/{no_bukti}', [ArusKasController::class, 'update']);
    Route::delete('arus-kas/{no_bukti}', [ArusKasController::class, 'delete']);
    Route::delete('arus-kas/pengembalian/{no_pengembalian}', [ArusKasController::class, 'deleteForPengembalian']);
    Route::delete('arus-kas/pembayaran/{no_pembayaran}', [ArusKasController::class, 'deleteForPembayaran']);

    Route::get('pengembalian', [PengembalianController::class, 'index']);
    Route::get('pengembalian/{no_pengembalian}', [PengembalianController::class, 'getDataById']);
    Route::get('pengembalian/cabang/{cabang}', [PengembalianController::class, 'getDataByCabang']);
    Route::get('pengembalian/no-service/{no_service}', [PengembalianController::class, 'getDataByNoService']);
    Route::post('pengembalian', [PengembalianController::class, 'create']);
    Route::put('pengembalian/{no_pengembalian}', [PengembalianController::class, 'update']);
    Route::delete('pengembalian/{no_pengembalian}', [PengembalianController::class, 'delete']);
    Route::delete('pengembalian/no-service/{no_service}', [PengembalianController::class, 'deleteByNoService']);

    Route::get('detail-pengerjaan', [DetailPengerjaanController::class, 'index']);
    Route::post('detail-pengerjaan', [DetailPengerjaanController::class, 'create']);
    Route::put('detail-pengerjaan/{no_pengerjaan}', [DetailPengerjaanController::class, 'update']);
    Route::delete('detail-pengerjaan/{no_pengerjaan}', [DetailPengerjaanController::class, 'delete']);

    Route::get('teknisi-pj', [TeknisiPjController::class, 'index']);
    Route::get('teknisi-pj/{no_service}', [TeknisiPjController::class, 'getDataById']);
    Route::get('teknisi-pj/teknisi/{id_teknisi}', [TeknisiPjController::class, 'getDataByTeknisi']);
    Route::post('teknisi-pj', [TeknisiPjController::class, 'create']);
    Route::put('teknisi-pj/{no_service}', [TeknisiPjController::class, 'update']);
    Route::delete('teknisi-pj/{no_service}', [TeknisiPjController::class, 'delete']);

    Route::get('pengiriman-barang', [PengirimanBarangController::class, 'index']);
    Route::get('pengiriman-barang/{no_surat_jalan}', [PengirimanBarangController::class, 'getDataById']);
    Route::get('pengiriman-barang/admin/{id_admin}', [PengirimanBarangController::class, 'getDataByIdAdmin']);
    Route::post('pengiriman-barang', [PengirimanBarangController::class, 'create']);
    Route::put('pengiriman-barang/{no_surat_jalan}', [PengirimanBarangController::class, 'update']);
    Route::delete('pengiriman-barang/{no_surat_jalan}', [PengirimanBarangController::class, 'delete']);

    Route::get('list-pengiriman', [ListPengirimanController::class, 'index']);
    Route::get('list-pengiriman/{no_surat_jalan}', [ListPengirimanController::class, 'getDataById']);
    Route::get('list-pengiriman/no-service/{no_service}', [ListPengirimanController::class, 'getDataByNoService']);
    Route::post('list-pengiriman', [ListPengirimanController::class, 'create']);
    Route::put('list-pengiriman/{no_surat_jalan}', [ListPengirimanController::class, 'update']);
    Route::put('list-pengiriman/no-service/{no_service}', [ListPengirimanController::class, 'updateByNoService']);
    Route::delete('list-pengiriman/{no_surat_jalan}', [ListPengirimanController::class, 'delete']);

    Route::get('penerimaan-pengiriman', [PenerimaanPengirimanController::class, 'index']);
    Route::get('penerimaan-pengiriman/{no_surat_jalan}', [PenerimaanPengirimanController::class, 'getDataById']);
    Route::get('penerimaan-pengiriman/no-service/{no_service}', [PenerimaanPengirimanController::class, 'getDataByNoService']);
    Route::post('penerimaan-pengiriman', [PenerimaanPengirimanController::class, 'create']);
    Route::put('penerimaan-pengiriman/{no_surat_jalan}/{no_service}', [PenerimaanPengirimanController::class, 'update']);
    Route::delete('penerimaan-pengiriman/{no_surat_jalan}/{no_service}', [PenerimaanPengirimanController::class, 'delete']);

    Route::get('tagihan-partner', [TagihanPartnerController::class, 'index']);
    Route::get('tagihan-partner/{no_service}', [TagihanPartnerController::class, 'getDataById']);
    Route::post('tagihan-partner', [TagihanPartnerController::class, 'create']);
    Route::put('tagihan-partner/{no_service}', [TagihanPartnerController::class, 'update']);
    Route::delete('tagihan-partner/{no_service}', [TagihanPartnerController::class, 'delete']);

    Route::get('list-kelengkapan-penerimaan-barang', [ListKelengkapanPenerimaanBarangServiceController::class, 'index']);
    Route::get('list-kelengkapan-penerimaan-barang/{no_service}', [ListKelengkapanPenerimaanBarangServiceController::class, 'getDataByNoService']);
    Route::post('list-kelengkapan-penerimaan-barang', [ListKelengkapanPenerimaanBarangServiceController::class, 'create']);
    Route::put('list-kelengkapan-penerimaan-barang/{no_service}', [ListKelengkapanPenerimaanBarangServiceController::class, 'update']);
    Route::delete('list-kelengkapan-penerimaan-barang/{no_service}', [ListKelengkapanPenerimaanBarangServiceController::class, 'delete']);

    Route::get('pengajuan-pembelian-barang-second', [PengajuanPembelianBarangSecondController::class, 'index']);
    Route::get('pengajuan-pembelian-barang-second/{no_service}', [PengajuanPembelianBarangSecondController::class, 'getDataByNoService']);
    Route::post('pengajuan-pembelian-barang-second', [PengajuanPembelianBarangSecondController::class, 'create']);
    Route::put('pengajuan-pembelian-barang-second/{no_service}', [PengajuanPembelianBarangSecondController::class, 'update']);
    Route::delete('pengajuan-pembelian-barang-second/{no_service}', [PengajuanPembelianBarangSecondController::class, 'delete']);

    Route::get('log-aktivitas', [LogAktivitasController::class, 'index']);
    Route::get('log-aktivitas/{id}', [LogAktivitasController::class, 'getDataById']);
    Route::get('log-aktivitas/user/{user_id}', [LogAktivitasController::class, 'getAllDataByUserId']);
    Route::get('log-aktivitas/user/one-day/{id}', [LogAktivitasController::class, 'getOneDayDataByUserId']);
    Route::post('log-aktivitas', [LogAktivitasController::class, 'create']);

    Route::get('notifikasi', [NotifikasiController::class, 'index']);
    Route::get('notifikasi/user/{role}/{id}', [NotifikasiController::class, 'getDataByUserId']);
    Route::get('notifikasi/role/{role}', [NotifikasiController::class, 'getDataByRole']);
    Route::post('notifikasi', [NotifikasiController::class, 'create']);

    Route::get('review-kepuasan-pelanggan', [ReviewKepuasanPelangganController::class, 'index']);
    Route::get('review-kepuasan-pelanggan/{id}', [ReviewKepuasanPelangganController::class, 'getDataById']);
    Route::get('review-kepuasan-pelanggan/user/{user_id}', [ReviewKepuasanPelangganController::class, 'getDataByUserId']);
    Route::get('review-kepuasan-pelanggan/cabang/{cabang}', [ReviewKepuasanPelangganController::class, 'getDataByCabang']);
    Route::get('review-kepuasan-pelanggan/no-service/{no_service}', [ReviewKepuasanPelangganController::class, 'getDataByNoService']);
    Route::post('review-kepuasan-pelanggan', [ReviewKepuasanPelangganController::class, 'create']);
    Route::put('review-kepuasan-pelanggan/replace/{no_service}', [ReviewKepuasanPelangganController::class, 'update']);
    Route::put('review-kepuasan-pelanggan/update/{no_service}', [ReviewKepuasanPelangganController::class, 'updateWithoutDelete']);
    Route::delete('review-kepuasan-pelanggan/{no_service}', [ReviewKepuasanPelangganController::class, 'delete']);

    Route::post('logout', [AuthController::class, 'logout']);
});