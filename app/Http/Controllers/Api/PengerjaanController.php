<?php

namespace App\Http\Controllers\Api;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengerjaan;
use App\Models\Partner;
use App\Models\Customer;

class PengerjaanController extends Controller
{
    public function index()
    {
        // Pengerjaan::with('penerimaan', 'partner', 'detailPengerjaan', 'teknisi')->orderBy('no_pengerjaan', 'desc')->get()
        $pengerjaan = DB::select("SELECT 
            pengerjaan.no_pengerjaan, 
            penerimaan_barang.no_service_penerimaan, 
            cabang.nama_cabang,
            penerimaan_barang.jenis_penerimaan,
            barang_jasa.nama_bj, 
            penerimaan_barang.merek, 
            penerimaan_barang.tipe, 
            penerimaan_barang.problem, 
            penerimaan_barang.kondisi, 
            penerimaan_barang.permintaan, 
            penerimaan_barang.keterangan, 
            pengerjaan.status_pengerjaan,
            (SELECT name FROM users WHERE teknisi_pj.id_teknisi = users.id) AS teknisi, 
            (SELECT name FROM users WHERE id = penerimaan_barang.id_customer) AS customer, 
            (SELECT nama FROM partner WHERE id = pengerjaan.id_partner) AS partner,
            penerimaan_barang.tempo FROM `pengerjaan` 
            LEFT JOIN penerimaan_barang ON pengerjaan.no_service = penerimaan_barang.no_service_penerimaan 
            LEFT JOIN teknisi_pj ON penerimaan_barang.no_service_penerimaan = teknisi_pj.no_service 
            LEFT JOIN barang_jasa ON penerimaan_barang.id_bj = barang_jasa.id
            LEFT JOIN cabang ON penerimaan_barang.id_cabang = cabang.id"
        );

        return response()->json([
            'status' => 'OK',
            'total_data' => count($pengerjaan),
            'data' => $pengerjaan
        ], 200);
    }

    public function getDataById($no_pengerjaan)
    {
        $pengerjaan = Pengerjaan::with('penerimaan', 'partner', 'detailPengerjaan', 'teknisi')->where('no_pengerjaan', $no_pengerjaan)->first();
        if($pengerjaan) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengerjaan
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByNoService($no_service)
    {
        $pengerjaan = Pengerjaan::with('penerimaan', 'partner', 'detailPengerjaan', 'teknisi')->where('no_service', $no_service)->first();
        if($pengerjaan) {
            return response()->json([
                'status' => 'OK',
                'data' => $pengerjaan
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function getDataByStatusPengerjaanAndPartner($status_pengerjaan, $id_partner)
    {
        $pengerjaan = Pengerjaan::with('penerimaan')
                                ->where('id_partner', $id_partner)
                                ->orWhere('status_pengerjaan', $status_pengerjaan)
                                ->get();
        return response()->json([
            'status' => 'OK',
            'data' => $pengerjaan
        ], 200);
    }

    public function getDataByIdTeknisi($id_teknisi)
    {
        $pengerjaan = DB::select("SELECT penerimaan_barang.*, pengerjaan.status_pengerjaan, pengerjaan.no_pengerjaan, partner.nama AS partner, cabang.nama_cabang, customer.nama, barang_jasa.nama_bj FROM `teknisi_pj` 
        LEFT JOIN pengerjaan ON teknisi_pj.no_service = pengerjaan.no_service 
        LEFT JOIN penerimaan_barang ON teknisi_pj.no_service = penerimaan_barang.no_service_penerimaan 
        LEFT JOIN partner ON pengerjaan.id_partner = partner.id 
        LEFT JOIN cabang ON penerimaan_barang.id_cabang = cabang.id 
        LEFT JOIN customer ON penerimaan_barang.id_customer = customer.id 
        LEFT JOIN barang_jasa ON penerimaan_barang.id_bj = barang_jasa.id 
        WHERE teknisi_pj.id_teknisi = '$id_teknisi'");

        return response()->json([
            'status' => 'OK',
            'data' => $pengerjaan
        ], 200);
    }

    public function create(Request $request)
    {
        $cabang = Auth::user()->cabang;
        $cabang = $cabang['nama_cabang'];
        $cabang = "TSC $cabang";
        $partner = Partner::where('nama', $cabang)->first();

        $input = $request->all();
        $input['id_partner'] = $partner['id'];
        $pengerjaan = Pengerjaan::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil ditambahkan',
            'data' => $pengerjaan
        ], 200);
    }

    public function update(Request $request, $no_pengerjaan)
    {
        $pengerjaan = Pengerjaan::where('no_pengerjaan', $no_pengerjaan)->first();
        if($pengerjaan) {
            $input = $request->all();
            $pengerjaan->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $pengerjaan
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function updateByNoService(Request $request, $no_service)
    {
        $pengerjaan = Pengerjaan::where('no_service', $no_service)->first();
        if($pengerjaan) {
            $input = $request->all();
            $pengerjaan->fill($input)->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil diupdate',
                'data' => $pengerjaan
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function delete($no_service)
    {
        $pengerjaan = Pengerjaan::where('no_service', $no_service)->first();

        if($pengerjaan) {
            $pengerjaan->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Not Found'
            ], 404);
        }
    }

    public function sendEmailNotification(Request $request)
    {
        require base_path("vendor/autoload.php");
        $user = Customer::find($request->id);
        $mail = new PHPMailer(true);     

        if($user) {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'ssl://mail.twincom.co.id';                 
            $mail->SMTPAuth = true;
            $mail->Username = env('EMAIL_ADDRESS');         
            $mail->Password = env('EMAIL_PASSWORD');        
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                      
            $mail->Port = 465;                              
    
            $mail->setFrom(env('EMAIL_ADDRESS'), 'Twincom Service Center');
            $mail->addAddress($request->email);
    
            $mail->addReplyTo(env('EMAIL_ADDRESS'), 'Twincom Service Center');
    
            $mail->isHTML(true);                
    
            $mail->Subject = 'Pemberitahuan';
            $mail->Body    = 'Hai, ' . $request->name . '. Barang anda dengan nomor service ' . $request->no_service . ' telah selesai dikerjakan. Silahkan datang ke Twincom ' . $request->place . ' untuk mengambilnya. Terimakasih.';
            $send = $mail->send();

            if($send) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Email berhasil dikirimkan',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => $mail->ErrorInfo,
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email tidak terdaftar!'
            ], 401);
        }
    }
}
