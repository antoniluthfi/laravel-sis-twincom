<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenerimaanBarang;
use App\Models\Pengembalian;
use App\Models\ArusKas;
use App\Models\PengirimanBarang;
use PDF;

class CetakLaporanController extends Controller
{
    public function pdfGeneratorNota($nama_pdf, $title, $file, $data)
    {
        $pdf = PDF::loadView($file, ['data' => $data], [], [
            'mode'                 => '',
            'format'               => [140, 235],
            'default_font_size'    => '12',
            'default_font'         => 'sun-exta',
            'margin_left'          => 2,
            'margin_right'         => 2,
            'margin_top'           => 2,
            'margin_bottom'        => 2,
            'margin_header'        => 1,
            'margin_footer'        => 1,
            'orientation'          => 'L',
            'title'                => $title,
            'author'               => 'Antoni Luthfi',
            'watermark'            => '',
            'show_watermark'       => false,
            'watermark_font'       => 'sans-serif',
            'display_mode'         => 'real',
            'watermark_text_alpha' => 0.1,
            'custom_font_dir'      => '',
            'custom_font_data' 	   => [],
            'auto_language_detection'  => false,
            'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            'pdfa' 			=> false,
            'pdfaauto' 		=> false,
            'custom_font_data' => [
                'sun-exta' => [
                    'R' => 'Sun-ExtA.ttf',
                    'sip-ext' => 'sun-extb',
                ],
                'sun-extb' => [
                    'R' => 'Sun-ExtB.ttf',
                ],
            ]
        ]);
        return $pdf->stream("$nama_pdf.pdf");
    }

    public function pdfReportGenerator($nama_pdf, $title, $file, $data, $tambahan)
    {
        if($tambahan['sampai'] === 'x') {
            $sampai = '';
        }
        $pdf = PDF::loadView($file, ['data' => $data, 'dari' => $tambahan['dari'], 'sampai' => $tambahan['sampai'], 'nama_admin' => $tambahan['nama_admin'], 'dataCount' => $tambahan['dataCount']], [], [
            'mode'                 => '',
            'format'               => 'A4',
            'default_font_size'    => '12',
            'default_font'         => 'sans-serif',
            'margin_left'          => 2,
            'margin_right'         => 2,
            'margin_top'           => 2,
            'margin_bottom'        => 2,
            'margin_header'        => 1,
            'margin_footer'        => 1,
            'orientation'          => 'P',
            'title'                => $title,
            'author'               => 'Antoni Luthfi',
            'watermark'            => '',
            'show_watermark'       => false,
            'watermark_font'       => 'sans-serif',
            'display_mode'         => 'real',
            'watermark_text_alpha' => 0.1,
            'custom_font_dir'      => '',
            'custom_font_data' 	   => [],
            'auto_language_detection'  => false,
            'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            'pdfa' 			=> false,
            'pdfaauto' 		=> false,
        ]);
        return $pdf->stream("$nama_pdf.pdf");
    }

    public function pdfSuratJalanGenerator($data)
    {
        $pdf = PDF::loadView('surat-jalan', ['data' => $data], [], [
            'mode'                 => '',
            'format'               => [140, 235],
            'default_font_size'    => '12',
            'default_font'         => 'sun-exta',
            'margin_left'          => 2,
            'margin_right'         => 2,
            'margin_top'           => 2,
            'margin_bottom'        => 2,
            'margin_header'        => 1,
            'margin_footer'        => 1,
            'orientation'          => 'L',
            'title'                => 'Surat Jalan',
            'author'               => 'Antoni Luthfi',
            'watermark'            => '',
            'show_watermark'       => false,
            'watermark_font'       => 'sans-serif',
            'display_mode'         => 'real',
            'watermark_text_alpha' => 0.1,
            'custom_font_dir'      => '',
            'custom_font_data' 	   => [],
            'auto_language_detection'  => false,
            'temp_dir'               => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
            'pdfa' 			=> false,
            'pdfaauto' 		=> false,
            'custom_font_data' => [
                'sun-exta' => [
                    'R' => 'Sun-ExtA.ttf',
                    'sip-ext' => 'sun-extb',
                ],
                'sun-extb' => [
                    'R' => 'Sun-ExtB.ttf',
                ],
            ]
        ]);
        return $pdf->stream("surat_jalan.pdf");
    }

    public function tandaTerimaService($no_service)
    {
        $data = DB::select("SELECT 
            penerimaan_barang.*, 
            pengerjaan.status_pengerjaan, 
            partner.nama AS partner, 
            (SELECT users.name FROM users WHERE users.id = penerimaan_barang.id_admin) AS admin, 
            (SELECT customer.nama FROM customer WHERE customer.id = penerimaan_barang.id_customer) AS customer, 
            (SELECT customer.nomorhp FROM customer WHERE customer.id = penerimaan_barang.id_customer) AS customer_nomorhp, 
            (SELECT customer.id FROM customer WHERE customer.id = penerimaan_barang.id_customer) AS customer_id, 
            (SELECT users.name FROM users WHERE users.id = teknisi_pj.id_teknisi) AS teknisi, 
            (SELECT barang_jasa.nama_bj FROM barang_jasa WHERE barang_jasa.id = penerimaan_barang.id_bj) AS barang_jasa, 
            (SELECT cabang.nama_cabang FROM cabang WHERE cabang.id = penerimaan_barang.id_cabang) AS cabang FROM penerimaan_barang 
            LEFT JOIN teknisi_pj ON penerimaan_barang.no_service_penerimaan = teknisi_pj.no_service 
            LEFT JOIN pengerjaan ON penerimaan_barang.no_service_penerimaan = pengerjaan.no_service 
            LEFT JOIN partner ON pengerjaan.id_partner = partner.id WHERE penerimaan_barang.no_service_penerimaan = '$no_service'"
        );
        // dd($data);
        $this->pdfGeneratorNota('tanda_terima_service', 'Tanda Terima Service', 'tanda-terima-service', $data[0]);
    }

    public function notaService($no_service)
    {
        $data = Pengembalian::with('penerimaan', 'detailPengerjaan', 'pengerjaan', 'admin')->where('no_service', $no_service)->first();
        $this->pdfGeneratorNota('nota-service', 'Nota Service', 'nota-service', $data);
    }

    public function laporanPengembalian($dari, $sampai, $cabang, $shift, $admin)
    {
        $data2 = [
            'nama_admin' => $admin,
            'dari' => $dari,
            'sampai' => $sampai,
            'dataCount' => ''
        ];

        if($sampai === 'x') {
            $sampai = "$dari 23:59:59";
            $dari = "$dari 00:00:00";
        } else {
            $sampai = "$sampai 23:59:59";
        }

        $data = ArusKas::with('penerimaan', 'pengerjaan', 'admin', 'detailPengerjaan', 'pj')
                        ->whereBetween('created_at', [$dari, $sampai])
                        ->where('no_service', '>', '0')
                        ->where('cabang', $cabang);
        if($shift != 'x') {
            $data = $data->where('shift', $shift);
        }
                            
        $data = $data->get();
        $this->pdfReportGenerator('laporan.pdf', 'Laporan Pengambalian Dan Pembayaran Barang Service', 'laporan-pengembalian', $data, $data2);
    }

    public function laporanArusKas($dari, $sampai, $cabang, $shift, $admin)
    {
        if($sampai === 'x') {
            $sampai = "$dari 23:59:59";
            $dari = "$dari 00:00:00";
        } else {
            $sampai = "$sampai 23:59:59";
        }

        $dataCount = DB::select(
            "SELECT COUNT(arus_kas.id_sandi) AS count_sandi, 
                arus_kas.*,
                sandi_transaksi.* FROM arus_kas 
            LEFT JOIN sandi_transaksi ON arus_kas.id_sandi = sandi_transaksi.id 
            GROUP BY sandi_transaksi.jenis_transaksi, arus_kas.cabang, arus_kas.id_sandi
            HAVING arus_kas.cabang = '$cabang'
            AND (arus_kas.created_at BETWEEN '$dari' AND '$sampai')
            ORDER BY sandi_transaksi.jenis_transaksi ASC"
        );
        // dd($dataCount[1]->count_sandi);

        $data2 = [
            'nama_admin' => $admin,
            'dari' => $dari,
            'sampai' => $sampai,
            'dataCount' => $dataCount
        ];

        $data = ArusKas::with('penerimaan', 'pengerjaan', 'admin', 'detailPengerjaan', 'pj', 'transaksi')
                        ->whereBetween('created_at', [$dari, $sampai])
                        ->where('cabang', $cabang);
        if($shift != 'x') {
            $data = $data->where('shift', $shift);
        }

        $data = $data->get();
        $this->pdfReportGenerator('laporan_arus_kas.pdf', 'Laporan Arus Kas', 'laporan-arus-kas', $data, $data2);
    }

    public function suratJalan($no_surat_jalan)
    {
        $data = PengirimanBarang::with('list_pengiriman')->where('no_surat_jalan', $no_surat_jalan)->first();
        $this->pdfSuratJalanGenerator($data);
    }
}
