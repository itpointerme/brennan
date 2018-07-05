<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Cache;
use Auth;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => 'required|string|min:11',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'phone'=>$data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request){
       $this->validate($request, [
            'code'  => 'required|numeric',
            'phone' => 'required|numeric|min:1',
            'pass'  => 'required',
        ]);

        $mobile     = strval($request->phone);
        $password   = bcrypt($request->pass);
        
        if($request->code!=Cache::get('login_code@'.$mobile))
        {
            return json_encode(array('code'=>2,'msg'=>'验证码不匹配'));
        }

        if($this->matchingUser($mobile))
        {
            return json_encode(array('code'=>1,'msg'=>'手机号重复使用'));
        }else{
            //随机分配客服
            $customerService = User::where('type',1)->pluck('id')->toArray();
            
            $randomElement = $customerService[ array_rand($customerService) ];
            
            $user=User::create(['phone'=>"$mobile",'password'=>"$password",'type'=>"-$randomElement"]);
        }


        if(Auth::loginUsingId($user->id)){
            return json_encode(array('code'=>0,'msg'=>'注册成功'));
        }else{
            return json_encode(array('code'=>1,'msg'=>'注册失败'));
        }
    }

    protected function matchingUser($mobile){

        return User::where('phone',$mobile)->count();

    }
}
