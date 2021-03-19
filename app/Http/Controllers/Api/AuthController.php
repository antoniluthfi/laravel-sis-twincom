<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\User;
use App\Models\Customer;
use Validator;

class AuthController extends Controller
{
    public $successStatus = 200;
    
    public function login(Request $request)
    {
        if($request->role === 'user') {
            if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password, 'status_akun' => 1])) {
                $user = Auth::guard('web')->user();                
                $success['user'] = $user;
                $success['token'] = $user->createToken('sis', ['karyawan'])->accessToken;

                return response()->json([
                    'success' => $success, 
                ], $this->successStatus);
            } else {
                return response()->json([
                    'error' => 'unauthorized'
                ], 401);
            }
        } elseif($request->role === 'customer') {
            if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'status_akun' => 1])) {
                $user = Auth::guard('customer')->user();
                $success['token'] = $user->createToken('sis', ['customer'])->accessToken;
                $success['user'] = $user;
    
                return response()->json([
                    'success' => $success, 
                ], $this->successStatus);
            } else {
                return response()->json([
                    'error' => 'unauthorized'
                ], 401);
            }
        }
    } 

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'alamat' => 'required',
            'nomorhp' => 'required',
            'cab_penempatan' => 'required',
            'status_akun' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'error' => $validator->errors()
            ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['jabatan'] = 'karyawan';
        $user = User::create($input);

        return response()->json([
            'status' => 'OK',
            'message' => 'User berhasil didaftarkan',
            'data' => $user
        ], $this->successStatus);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->OauthAcessToken()->delete();

            return response()->json([
                'message' => 'Successfully logout'
            ], 200);
        }
    }

    public function forgotPassword(Request $request)
    {
        require base_path("vendor/autoload.php");
        $user = User::where('email', $request->email)->first();
        if(!$user) {
            $user = Customer::where('email', $request->email)->first();
        }

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
    
            $mail->Subject = 'Reset Password';
            $mail->Body    = 'Silahkan reset password anda melalui link berikut ini: ' . $request->url . '/' . Crypt::encrypt($user['id']);
            $send = $mail->send();

            if($send) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Silahkan cek verifikasi password pada email anda',
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