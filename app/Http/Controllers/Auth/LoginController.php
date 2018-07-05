<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Cache;
use App\User as Users;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    protected $username = 'phone';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

     public function get_login_code(Request $request)
    {
        $mobile = is_numeric($request->input('mobile'))? (string)($request->input('mobile') + 0) : null;
        if($mobile){
            $this->send($mobile);
        }
    }

    public function send($mobile)
    {
        $code = mt_rand(1111, 9999);
        Cache::put('login_code@'.$mobile, $code, 2);
        if(env('APP_URL') == 'http://www.baidu.com/'){
            $sms = new \PFinal\Aliyun\AliyunSMS();
            $sms->accessKeyId =env('OSSACCESSKEYID');
            $sms->accessKeySecret = env('OSSACCESSKEYSECRET');
            $sms->signName = '布劳宁';
            $sms->templateId = 'SMS_1110110110';
            $sms->templateCodeKey = 'code';
            $bool = $sms->sendCode($mobile, $code);
        }else{
            echo $code;
        }
        
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return response()->json(['code' => 1, 'msg' => 'SUCCESS']);
    }


    public function username()
    {
        return 'phone';
    }

    public function selectpass(Request $request)
    {

        $pass = Users::where('phone',$request->input('phone'))->value('password');

        return Hash::check($request->input('pass') , $pass) ? 1 : 0;
    }
}
