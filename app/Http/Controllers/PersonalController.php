<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Http\Controllers;

use App\Models\OrderGoods;
use App\Models\Province;
use App\Models\GoodsSku;
use App\Models\Address;
use App\Models\Company;
use App\Models\Goods;
use App\Models\Order;
use App\Models\City;
use App\Models\Area;
use App\Models\Collect;
use App\Models\Posts;
use App\Models\ClientOrder;
use App\Models\ClientCategory;
use App\User;
use Auth;

class PersonalController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = $request->user();
            if( $this->user['type'] === 1 ) return redirect('/sale');

            //查询服务我的销售
            $sale = User::where('id',abs($this->user->type))->first();
            //获取公司信息
            $company = Company::where('uid',$this->user->id)->first();
            
            view()->share(['company'=>$company,'user'=>$this->user,'sale'=>$sale]);

            return $next($request);
        });
    }

    public function index()
    {
        return view('personal_index');
    }

    /**
    * 个人基本资料修改
    * @param int type
    */
    public function contacts()
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
        return view('personal_contacts',compact('userInfo'));
    }

    /**
    * 个人基本资料修改
    * @param int type
    */
    public function head()
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

        return redirect()->route('contacts');
    }

    /**
    * 修改密码
    */
    public function password()
    {
       
        if(\Request::ajax()){
            $data = \Request::all();
    
            $oldpassword = $data['oldpassword'];
            $password = $data['password'];
            $password_confirmation = $data['password_confirmation'];

            if (!\Hash::check($oldpassword, $this->user->password))
                return response()->json(['code'=>1, 'msg'=>'原始密码错误']);

            if($password != $password_confirmation)
                return response()->json(['code'=>1, 'msg'=>'两次输入密码不一致']);                

            $this->user->password = bcrypt($password);

            if($this->user->save()) return response()->json(['code'=>0, 'msg'=>'修改成功']);
                        
        }

        return view('personal_password');
    }

    //管理分类
    public function category()
    {
        //获取当前用户分类
        $clientCategory = ClientCategory::where('user_id', $this->user->id)->orderBy('sort','desc')->get()->toArray();

        if(request()->ajax()){
            $id = intval(request()->id);
            $value = addslashes(request()->value);

            if(request()->type == 'add') return ClientCategory::create(['name'=>$value, 'user_id'=>$this->user->id, 'created_at' => date('Y-m-d H:i:s',time()), 'updated_at' => date('Y-m-d H:i:s',time())]);

            if(request()->type == 'del') return ClientCategory::where('id',$id)->delete();
            
            $op = ClientCategory::where('id',$id)->update(['name'=>$value]);
            if($op) return response()->json(['code'=>0, 'msg'=>'更新成功']);
        }
        return view('personal_category',  compact('clientCategory'));
      
    }

    //采购订单列表
    public function porders()
    {
        //获取当前用户所有采购单
        $pushOrderLists = Order::where('users_id', $this->user->id)
                               ->with([
                                     'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                     'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                               ])
                               ->where('type', 1)
                               ->get()
                               ->toArray();
        foreach ($pushOrderLists as $k => $v) {
             //商品总数
             $orderNumAll = 0;
             //商品总价
             $priceAll = 0;
             foreach ($v['getordergoods'] as $key => $value) {
                 $orderNumAll += $value['goods_number'];
                 $priceAll += $value['tax_price_all'];
             }
             $pushOrderLists[$k]['orderNumAll'] = $orderNumAll;
             $pushOrderLists[$k]['priceAll'] = $priceAll;
         } 

        if(request()->ajax()){
           //获取当前用户所有采购单
            $pushOrderLists = Order::where('order_nr', 'like', '%'.request()->keywords.'%')
                                   ->with([
                                         'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                         'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                                   ])
                                   ->where('type', 1)
                                   ->get()
                                   ->toArray();
            foreach ($pushOrderLists as $k => $v) {
                 //商品总数
                 $orderNumAll = 0;
                 //商品总价
                 $priceAll = 0;
                 foreach ($v['getordergoods'] as $key => $value) {
                     $orderNumAll += $value['goods_number'];
                     $priceAll += $value['tax_price_all'];
                 }
                 $pushOrderLists[$k]['orderNumAll'] = $orderNumAll;
                 $pushOrderLists[$k]['priceAll'] = $priceAll;
             }

             return json_encode($pushOrderLists);
        }

        return view('personal_porders',compact('pushOrderLists'));
    }

    /**
    * 新增采购订单 Purchase Orders Add
    */
    public function paorders()
    {
       
        //获取当前用户最后一条已报价询价单的记录         
        $goods = Order::where('users_id', $this->user->id)
                 ->with(['getordergoods.getgoodsinfo.get_parent_attachment.attachment'])
                 ->where('type', 0)
                 ->where('tax', 1)
                 ->where('enable', 0)
                 ->orderBy('created_at', 'desc')
                 ->get()
                 ->toArray();
        $goodsList = array();

        //最后一条询价单 记录
        if(count($goods) > 0){
            foreach($goods['0']['getordergoods'] as $vv){
              $goodsList[] = $vv;
            }
            $goodsList = unique_multidim_array($goodsList, 'goods_id');

            $limit = 5;
            //查询当前用户是否有采购订单 type=1 
            $goods_type_1 = Order::where('users_id', $this->user->id)
                                 ->with([
                                    'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                    'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                                 ])
                                 ->where('type', 1)
                                 ->limit($limit)
                                 ->get()
                                 ->toArray();
            $goodsList_type_1 = array(); 
            foreach ($goods_type_1 as $k => $v) {
                foreach($v['getordergoods'] as $vv){
                    $goodsList_type_1[] = $vv;
                }
            }

            $goodsList_type_1 = unique_multidim_array($goodsList_type_1, 'goods_id');
        }else{
           return view('dont');
        }
        

        if(\Request::ajax()){
            $data = \Request::all();
            //搜索
            if( $data['type'] == 'search' ){
            
                  $goods_type_2 = Order::where('users_id', $this->user->id)
                                 ->with([
                                    'getordergoods.getgoodsinfo'=>function($query) use($data) {
                                          $query->where('post_title', 'like', "%".$data['keywords']."%");
                                    },
                                    'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                    'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                                 ])
                                 ->where('type', 1)
                                 ->get()
                                 ->toArray();
                  $goodsList_type_2 = array();
                  foreach ($goods_type_2 as $k => $v) {
                      foreach($v['getordergoods'] as $vv){
                          $goodsList_type_1[] = $vv;
                      }
                  }
                  $goodsList = unique_multidim_array($goodsList_type_2, 'goods_id');

            }else{
                //下拉加载
                 $goods_type_3 = Order::where('users_id', $this->user->id)
                                      ->with([
                                              'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                              'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                                       ])
                                       ->where('type', 1)
                                       ->offset($data['p']*$limit)
                                       ->limit($limit)
                                       ->get()
                                       ->toArray();
                  $goodsList_type_3 = array();
                  foreach ($goods_type_3 as $k => $v) {
                      foreach($v['getordergoods'] as $vv){
                          $goodsList_type_3[] = $vv;
                      }
                  }
                  $goodsList = unique_multidim_array($goodsList_type_3, 'goods_id');

            }
            return json_encode($goodsList);
        }

        return view('personal_paorders', compact('goodsList', 'goods' ,'goodsList_type_1'));
    }

    /**
    * ajax 添加采购订单
    */
    public function addporder()
    {
        $data = \Request::all();

        if(request()->file('files')){
            //获取附件路径
            $path = request()->file('files')->store('public/images');
            $path = \Storage::url($path);    
        }else{
            $path = '';
        }
        
        //创建采购单
        $pushOrder = Order::create($data);
        $pushOrder->users_id = Auth()->id();
        //客服id
        $pushOrder->client_users_id = abs($this->user->type);
        $pushOrder->order_nr = time().str_pad($pushOrder->id + 1, 8, "0", STR_PAD_LEFT);
        $pushOrder->type = 1;
        $pushOrder->status = 2;
        $pushOrder->appendix_path = $path;
        $pushOrder->save();
        //存入商品信息
        $data_goods = array();
        $data_client = array();
        for($i = 0; $i< count($data['goods_number']); $i++){
            $data_goods[] = [
                'goods_number' => $data['goods_number'][$i],
                'client_osn' => $data['client_osn'][$i],
                'client_desc' => $data['client_desc'][$i],
                'goods_id' => $data['goods_id'][$i],
                'order_id' => $pushOrder->id,
                'created_at' => date('Y-m-d H:i:s',time()),
                'updated_at' => date('Y-m-d H:i:s',time()),
                'tax_price' => $data['tax_price'][$i],
                'tax_price_all' => $data['tax_price'][$i]*$data['goods_number'][$i]
            ];

            $data_client = [
                'goods_id' => $data['goods_id'][$i],
                'user_id'  => $this->user->id,
                'client_osn' => $data['client_osn'][$i],
                'client_desc' => $data['client_desc'][$i],
                'tax_price' => $data['tax_price'][$i],
                'created_at' =>  date('Y-m-d H:i:s',time()),
                'updated_at' =>  date('Y-m-d H:i:s',time())
            ];

            //添加到用户经常采购配件  并且 不重复插入goods_id
            ClientOrder::updateOrInsert(['goods_id'=> $data['goods_id'][$i]], $data_client);
        }

        $orderGoods = OrderGoods::insert($data_goods);

        return redirect()->route('porders');
    }

    /**
    * 询价订单 列表
    */
    public function askorders()
    {
        $askOrderLists = Order::where('users_id', $this->user->id)
                              ->where('enable',0)
                              ->where('type',0)
                              ->orderByRaw('created_at desc')
                              ->get()
                              ->toArray();
        if(request()->ajax()){
            if(request()->del){
                Order::where('id', intval(request()->del))->update(['enable'=>1]);
                return response()->json(['code'=>0]);   
            }
            $res = Order::where('users_id', $this->user->id)
                        ->where('theme', 'like', "%".request()->keywords."%")
                        ->where('enable', 0)
                        ->where('type', 0)
                        ->get()
                        ->toArray();
                return json_encode($res);
        }
        return view('personal_askorders',compact('askOrderLists'));
    }

    /**
    * 询价订单 新增
    */
    public function askaorders()
    {
        $limit = 20;
        //获取当前询价单数据
        $goods = \Cart::content();
        //获取筛选物品
        $goodsList = Goods::with(['getsku','getcategory'])->limit($limit)->get()->toArray();

        if(\Request::ajax()){
            $data = \Request::all();
            if( $data['type'] == 'search' ){
                $goodsList = Goods::with(['getsku','getcategory'])
                                ->orWhere('goods_name', 'like', '%' . $data['keywords'] . '%')
                                ->limit($limit)
                                ->get()
                                ->toArray();
            }else{
                $goodsList = Goods::with(['getsku','getcategory'])
                                ->offset($data['p']*$limit)
                                ->limit($limit)
                                ->get()
                                ->toArray();
            }
            return json_encode($goodsList);
        }

        //获取用户信息 最后一次询价单填写的信息
        $order = Order::where('users_id', $this->user->id)->where('type', 0)->orderBy('created_at', 'desc')->first();
       // dd($order);

        return view('personal_askaorders',compact('goods', 'goodsList', 'order'));
    }

    /**
    * 询价订单详情
    * @param $oid 订单id
    */
    public function askdorders($oid)
    {
        //获取询价单详情
        $askOrderInfo = Order::where('id',$oid)
                            ->where('type', 0)
                            ->with(['getordergoods.getgoodsinfo.get_parent_attachment.attachment'])
                            ->first()
                            ->toArray();

        return view('personal_askdorders',compact('askOrderInfo'));   
    }

    //采购订单详情
    public function pdorders($oid)
    {
        $pushOrderListsDetail = Order::where('id', $oid)
                           ->with([
                                 'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                 'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo'
                           ])
                           ->first()
                           ->toArray();
       
        return view('personal_pdorders', compact('pushOrderListsDetail'));
    }

    /**
    * 添加询价单
    */
    public function addaskorder()
    {
        $data = \Request::all();
        if($data['theme'] == ''){
          $data['theme'] = '无主题';
        }

        if(request()->file('files')){
            //获取附件路径
            $path = request()->file('files')->store('public/images');
            $path = \Storage::url($path);    
        }else{
            $path = '';
        }
        
        //创建询价单
        $askOrder = Order::create($data);
        $askOrder->users_id = Auth()->id();
        //客服id
        $askOrder->client_users_id = abs($this->user->type);
        $askOrder->order_nr = time().str_pad($askOrder->id + 1, 8, "0", STR_PAD_LEFT);
        $askOrder->type = 0;
        $askOrder->status = 0;
        $askOrder->appendix_path = $path;
        //到期日期
        //floor((strtotime($data['quoted_price_end_time'])-time())/86400);
        $askOrder->save();
        //存入商品信息
        $data_goods = array();
        for($i = 0; $i< count($data['goods_number']); $i++){
            $data_goods[] = [
                'goods_number' => $data['goods_number'][$i],
                'client_osn' => $data['client_osn'][$i],
                'client_desc' => $data['client_desc'][$i],
                'goods_id' => $data['goods_id'][$i],
                'order_id' => $askOrder->id,
                'created_at' => date('Y-m-d H:i:s',time())
            ];
        }
        $orderGoods = OrderGoods::insert($data_goods);

        //清空询价单
        \Cart::destroy();

        return redirect()->route('askorders');
    }

    /**
    * 经常采购配件
    */
    public function accessories()
    {
      if(request()->ajax()) return ClientOrder::where('goods_id', request()->gid)->update(['category_id'=>request()->cid]);
      //获取所有 分类
      $category = ClientCategory::where('user_id', $this->user->id)->orderBy('sort', 'desc')->get()->toArray();

      request()->c ? $cid = request()->c : $cid = 0;

      $threeMonthAgo = date("Y-m-d H:i:s",strtotime("-3 month",time()));

      $where = [
          'user_id' => $this->user->id,
      ];

      if($cid > 0) $where['category_id']=$cid;


      $builder = ClientOrder::where($where);

      if(request()->mo == 3){
         $builder->whereDate('created_at', '<=', now()->subMonth(3));
         view()->share(['showIcon'=>3]);
      }else{
         $builder->whereDate('created_at', '>=', now()->subMonth(3));
         view()->share(['showIcon'=>1]);
      }

      if(request()->k){
          $builder->where('client_osn', 'like', "%".request()->k."%");
      }
      
      //显示所有数据  每页显示10条
      $goods = $builder->with('getgoodsinfo.attachment' ,'getgoodsinfo.get_parent_attachment.attachment')  
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
      return view('personal_accessories', compact('goods', 'category'));
    }

    /**
    * 配件收藏夹
    */
    public function collection()
    {
        $data=Collect::where([['uid',$this->user->id]])->with('getgoods')->get()->toArray();
        if($data){
            foreach ($data as $key => $value) {
                $gid[]=$value['gid'];
            }
            foreach ($gid as $key => $value) {
                $goodsInfo = Posts::where("wp_posts.ID", $value)
                                ->with([
                                    'get_imgs.get_goods_img'
                                ])              
                                ->first()
                                ->toArray();
                $img[]=$goodsInfo['get_imgs']['1']['get_goods_img']['guid'];
            }
        }else{
          $img[]='';
        }
                        
        return view('personal_collection',['data'=>$data,'img'=>$img]);
    }


    /**
    * 添加购物车
    */
    public function addcarts()
    {
        $goods_id = request('op');
        $op_array = $goods_id=='' ? array() : explode('-', $goods_id);
        if($goods_id){
                  $order = Order::where('users_id', $this->user->id)
                                      ->with([
                                              'getordergoods.getgoodsinfo.get_parent_attachment.attachment', 
                                              'getordergoods.getgoodsinfo.get_parent_category.get_items.getterminfo',
                                              'getordergoods'=>function($query) use ($op_array) {
                                                  $query->whereIn('goods_id', $op_array);
                                              }
                                       ])
                                       ->where('type', 1)
                                       ->get()
                                       ->toArray();
                  $goodsList_type = array();
                  foreach ($order as $k => $v) {
                      foreach($v['getordergoods'] as $vv){
                          $goodsList_type[] = $vv;
                      }
                  }
                  $goodsList = unique_multidim_array($goodsList_type, 'goods_id');

            return json_encode($goodsList);
           /*foreach ($goods as $k => $v) {
               \Cart::add($v['ID'],$v['post_title'],1,0,$v);
           }
           return response()->json(['code'=>0 ,'msg' => '加入采购单成功']);*/
        }
    }

    /**
    * 公司信息修改
    */
    public function company()
    {
        $comList = Company::where('uid',$this->user->id)->with('getpro', 'getcity', 'getarea')->first();

       // dd($comList->toArray());
        
        if(\Request::ajax()){
            $data = \Request::all();
            if($comList){
                $comList->name = $data['name'];
                $comList->phone = $data['phone'];
                $comList->mobile_phone = $data['mobile_phone'];
                $city = $data['city'] ? $data['city'].'市' : '';
                $comList->city_id = City::where('name',$city)->value('id');
                $province = $this->filtePro($data['pro']);
                $comList->pro_id = Province::where('name',$province)->value('id');
                $comList->area_id = Area::where('name',$data['county'])->value('id');
                $comList->area_code = $data['area_code'];
                $comList->introduction = $data['company_introduction'];
                $comList->address = $data['address'];
                $comList->save();
            }else{
                $city = $data['city'] ? $data['city'].'市' : '';
                $province = $this->filtePro($data['pro']);
                Company::create([
                        'name' => $data['name'],
                        'phone' => $data['phone'],
                        'mobile_phone' => $data['mobile_phone'],
                        'city_id' => City::where('name',$city)->value('id'),
                        'pro_id' => Province::where('name',$province)->value('id'),
                        'area_id' => Area::where('name',$data['county'])->value('id'),
                        'area_code' => $data['area_code'],
                        'introduction' => $data['company_introduction'],
                        'address' => $data['address'],
                        'uid' => $this->user->id
                ]);
            }
            return response()->json(['code'=>0, 'msg'=>'修改成功']);
        }

        return view('personal_company',compact('comList'));
    }


    /**
    * 地址信息管理
    */
    public function address()
    {

        //获取地址栏信息
        $address = Address::where('user_id',$this->user->id)->get();
        if(request('del')){
            Address::where('id',intval(request('id')))->delete();
            return json_encode(array('code'=>0,'msg'=>'删除成功'));
        }
        if(request('submit')){
            $province = $this->filtePro(request('pro'));
            $city = request('city') ? request('city').'市' : '';
            $addressUser = Address::create([
                            'address_name'=>request('address'),
                            'status' => 1,
                            'user_id' => $this->user->id,
                            'mask' => request('mask'),
                            'mobile' =>request('mobile'),
                            'city_id' => City::where('name',$city)->value('id'),
                            'pro_id' => Province::where('name',$province)->value('id'),
                            'area_id' => Area::where('name',request('county'))->value('id'),
                            'name'  => request('name')
                         ]);
            if($addressUser){
                return json_encode(array('code'=>0,'msg'=>'添加成功','id'=>$addressUser->id));die;
            }else{
                return json_encode(array('code'=>1,'msg'=>'添加失败,参数错误'));die;
            }
        }

        return view('personal_address',compact('address'));
    }

    /**
    * 删除购物车商品
    */
    public function delcart()
    {   
        \Cart::remove(request('rowid'));
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }

    /**
    * 过滤省市
    * @param string pro 省份名称
    */
    public function filtePro($pro)
    {
        switch ($pro) {
                case '北京':
                    $province = $pro.'市';
                    break;
                case '天津':
                    $province = $pro.'市';
                    break;
                case '上海':
                    $province = $pro.'市';
                    break;
                case '重庆':  
                    $province = $pro.'市';
                    break;
                case '香港':
                    $province = $pro;
                    break;
                case '澳门':
                    $province = $pro;
                    break;  
                default:
                    $province = $pro.'省';
                    break;
            }

        return $province;    
    }

    //删除询价单收藏
    public function del_collect()
    {
        \DB::table('collect')->where('id',request('id'))->delete();
        echo json_encode(array('code'=>"1"));
    }
}
