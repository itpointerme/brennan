<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Stock;
use App\User;
use Auth;
use DB;

class SaleCenterController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
                $this->user = $request->user();
                return $next($request);
            });
    }

    public function index()
    {
        return view('sale');
    }

    public function myCustomer()
    {

        if(request()->ajax()){
            //获取客户信息
            $user = User::where('uname', "like", "%".request()->keywords."%" )
                        ->with(['getaddress'=>function($query) {
                                $query->with(['getcityname', 'getprovincename', 'getareaname']);
                                $query->where('is_default', '=', 1);
                        }])
                        ->get()
                        ->toArray();
            return  json_encode($user);
        }
        //获取我的客户信息
        $myCustomers = User::where('type', -$this->user->id)
                            ->with(['getaddress'=>function($query) {
                                $query->with(['getcityname', 'getprovincename', 'getareaname']);
                                $query->where('is_default', '=', 1);
                            }])
                            ->get()
                            ->toArray();


        return view('sale_myCustomer',compact('myCustomers'));
    }

    /**
    * 管理询价单
    */
    public function askOrders()
    {
        $builder = new Order();

        if(request()->k) 
            $builder = $builder->where('theme', 'like', '%'.request()->k.'%');
        //获取我的客户的询价单信息
        $askOrders = $builder->where('client_users_id',$this->user->id)
                             ->where('enable',0)
                             ->where('type',0)
                             ->get()
                             ->toArray();

        return view('sale_askOrders',compact('askOrders'));
    }

   
    /**
    * 询价单详情 
    */
    public function askOrderDetail($oid)
    {
        if(request()->submit){
           $tax_price_all = request()->tax_price_all;
           $tax_price = request()->tax_price;
           $id = request()->id;
           for($i=0; $i < count(request()->tax_price_all); $i++){
                $data_goods[] = [
                'id' => $id[$i],
                'tax_price' => $tax_price[$i],
                'tax_price_all' => $tax_price_all[$i],
                'updated_at' => date('Y-m-d H:i:s',time())
                ];
           }
           if($this->updateBatch('order_goods',$data_goods)){
              //更新订单 报价状态
              if(Order::where('id',$oid)->update(['status'=>1,'tax'=>1])) return redirect('/aorders');
           };
        }
        $askOrderInfo = Order::where('id',$oid)
                             ->with([
                                'getordergoods.getgoodsinfo.get_parent_attachment.attachment',
                                'getordergoods.getgoodsinfo.get_stock'
                            ])
                             ->first()
                             ->toArray();

      //  dd($askOrderInfo);                             

        return view('sale_askOrderDetail',compact('askOrderInfo'));
    }

    /**
    * 我的客户提交的采购订单
    */
    public function Orders()
    {
        $builder = new Order();
        if(request()->k) 
                $builder = $builder->where('order_nr', 'like', '%'.request()->k.'%');
        $orders = $builder->where('client_users_id',$this->user->id)
                        ->with([
                             'getordergoods.getgoodsinfo',
                             'getuserinfo'
                        ])
                        ->where('enable',0)
                        ->where('type',1)
                        ->get()
                        ->toArray();
        
        foreach ($orders as $k => $v) {
             //商品总数
             $orderNumAll = 0;
             //商品总价
             $priceAll = 0;
             foreach ($v['getordergoods'] as $key => $value) {
                 $orderNumAll += $value['goods_number'];
                 $priceAll += $value['tax_price_all'];
             }
             $orders[$k]['orderNumAll'] = $orderNumAll;
             $orders[$k]['priceAll'] = $priceAll;
        }
        
        return view('sale_orders', compact('orders'));
    }
    
    /**
    * 采购单 详情
    */
    public function orderDetail($oid)
    {
         $orderDetail = Order::where('id', $oid)
                             ->with([
                                   'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                   'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                             ])
                             ->first()
                             ->toArray();
   
        return view('sale_orderDetail', compact('orderDetail'));
    }

    /*
    * 库存查询
    */
    public function stock()
    {
        //获取库存
        $builder = new Stock();

        if(request()->k)
           $builder = $builder->where('goods_num', 'like', '%'.request()->k.'%');
         
        $stock = $builder->get();
        return view('sale_stock', compact('stock'));
    }

    public function saleData()
    {
        $userInfo = $this->user;
        if(\Request::ajax()){
            $data = array();
            switch (\Request::get('type')) {
                case 1://基本信息
                    $data['uname'] = addslashes(\Request::input('uname'));
                    $data['id_card'] = addslashes(\Request::input('id_card'));
                    $data['sex'] = intval(\Request::input('sex'));
                    break;
                case 2://邮箱发送验证码
                    $email = \Request::get('email');
                    $content = str_random( random_int(20, 30) );
                    \Cache::put('mail_code@'.$email, $content, 3);
                    \Mail::send('test', ['content'=>$content], function ($message) use($email){ 
                        $message->to([$email])->subject('验证码信息');
                    });
                    return response()->json(['code'=>0,'msg'=>'发送成功请及时打开邮箱接收']);
                    break;    
                case 3://邮箱验证
                    if(\Request::get('code') != \Cache::get('mail_code@'.\Request::get('email'))){
                            return response()->json(['code'=>1,'msg'=>'邮箱验证码错误']);
                    }
                    $data['email']=\Request::get('email');
                    break;    
                case 4://手机验证
                    break;    
                case 5://微信绑定
                    $data['wechat'] = addslashes(\Request::input('wechat'));
                    break;    
            }
            User::where('id',$userInfo->id)->update($data);
            return response()->json(['code'=>0]);
        }
        return view('sale_data',compact('userInfo'));
    }

    public function password()
    {
        return view('sale_password');
    }
    /**
    * 更新询价单
    */
     public function updateBatch($tableName = "", $multipleData = array()){  
      
            if( $tableName && !empty($multipleData) ) {  
      
                // column or fields to update  
                $updateColumn = array_keys($multipleData[0]);  
                $referenceColumn = $updateColumn[0]; //e.g id  
                unset($updateColumn[0]);  
                $whereIn = "";  
      
                $q = "UPDATE ".$tableName." SET ";   
                foreach ( $updateColumn as $uColumn ) {  
                    $q .=  $uColumn." = CASE ";  
      
                    foreach( $multipleData as $data ) {  
                        $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";  
                    }  
                    $q .= "ELSE ".$uColumn." END, ";  
                }  
                foreach( $multipleData as $data ) {  
                    $whereIn .= "'".$data[$referenceColumn]."', ";  
                }  
                $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";  
      
                // Update    
                return DB::update(DB::raw($q));  
      
            } else {  
                return false;  
            }  
      
        }

    /**
    * 个人基本资料修改
    * @param int type
    */
    public function heads()
    {
        $userInfo = $this->user;
        $data = array();
        $data['uname'] = addslashes(\Request::input('uname'));
        $data['id_card'] = addslashes(\Request::input('id_card'));
        $data['sex'] = intval(\Request::input('sex'));
        if(request()->file('files')){
            //获取附件路径
            $path = request()->file('files')->store('public/images');
            $path = \Storage::url($path);    
        }else{
            $path = '';
        }
        $data['head'] = $path;
        User::where('id',$userInfo->id)->update($data);

        return redirect()->route('saledata');
    }

}
