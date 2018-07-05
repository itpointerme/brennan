<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Http\Controllers;

use App\Models\TermRelationships;
use App\Models\Terms;
use App\Models\Posts;
use App\Models\Cad;
use App\Models\TermTaxonomy;
use Cart;
use DB;
use Auth;

class ProductsController extends Controller{

	/**
	* 商品列表页
	* @param intval cid category_id
	* @param intval p  页码值
	* @param string o  其他参数
	**/
	public function index($cid = 8 , $p = 1 , $op = '')
	{
		$limit = 12;
		$offset = $p;

		$p > 1 ? $offset = intval(($p-1)*$limit) : $offset = 0;

		$op_array = $op=='' ? array() : explode('-', $op);

		array_push($op_array, $cid);

		$where = array(
			0 => ['wp_term_relationships.term_taxonomy_id', '=', $cid],
		);

		//查询所有分类
		$category = Terms::leftJoin('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							->select(['wp_terms.term_id', 'wp_terms.name', 'wp_term_taxonomy.term_taxonomy_id'])
							->whereIn('wp_terms.term_id', TermRelationships::select('term_taxonomy_id')->distinct()->get())
							->where('wp_term_taxonomy.taxonomy', 'product_cat')
							->get()
							->toArray();
		//查询每个分类下的商品
		

		//获取分类筛选商品
		$goods = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						->where($where)
						->with('attachment')
						->when(count($op_array), function($collection) use ($op_array) {
							$array_manys = array();
							$where  = '';
							foreach ($op_array as $kop => $vop) {
								//查找object id 并获取重复id
								$array_manys[$kop] = TermRelationships::where('term_taxonomy_id', $vop)->pluck('object_id')->toArray();
							}
							if(count($array_manys) > 1){
								$result = call_user_func_array('array_intersect', $array_manys);
								$collection->whereIn('object_id',$result);
							}
						})
						->offset($offset)
						->limit($limit)
						->get()
						->toArray();
					
		//获取商品总数 
		$count = 	Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						 ->where($where)
						 ->when(count($op_array), function($collection) use ($op_array) {
								$array_manys = array();

								$where  = '';
								foreach ($op_array as $kop => $vop) {
									//查找object id 并获取重复id
									$array_manys[$kop] = TermRelationships::where('term_taxonomy_id', $vop)->pluck('object_id')->toArray();
								}

								if(count($array_manys) > 1){
									$result = call_user_func_array('array_intersect', $array_manys);
									$collection->whereIn('object_id',$result);
								}
						 })
						 ->count();
		//总页数
	    $pageNum = (int)ceil($count/$limit);

		// 查询单条分类下的名称
		$goodsCategory = Terms::where('term_id' ,$cid)->first()->toArray();

		//查询当前分类下商品 形状
		$allShapes =  Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						   ->select(['wp_posts.ID'])
						   ->where($where)
						   ->with('get_ter_taxonomy_shape.get_items.getterminfo')
						   ->get()
						   ->toArray();	
		$allShape = array();

		foreach ($allShapes as $k => $v) {
				foreach ($v['get_ter_taxonomy_shape'] as $ka => $va) {
						$allShape [] = $va['get_items'];
				}
		}

		$allShape = unique_multidim_array($allShape, 'term_id');

		//获取分类下所有商品形状的总数

		foreach ($allShape as $kk => $val) {
			$ops = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						 		->where('wp_term_relationships.term_taxonomy_id', $val['term_id'])
						 		->pluck('wp_posts.ID');

			$count = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
					 	  ->whereIn('wp_posts.ID', $ops)
					 	  ->where('wp_term_relationships.term_taxonomy_id', $cid)
				     	  ->count();
			$allShape[$kk]['scount'] = $count;	     	  
		}

	
		//查询当前分类下所有商品连接
		$connects = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						->select(['wp_posts.ID'])
						->where($where)
						->with('get_ter_taxonomy_connect.get_items.getterminfo')
						->get()
						->toArray();

		$connect = array();
		foreach ($connects as $k => $v) {
				foreach ($v['get_ter_taxonomy_connect'] as $ka => $va) {
						$connect [] = $va['get_items'];
				}
		}

		$connect = unique_multidim_array($connect, 'term_id');

		foreach ($connect as $kk => $val) {
			$ops = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						 		->where('wp_term_relationships.term_taxonomy_id', $val['term_id'])
						 		->pluck('wp_posts.ID');

			$count = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
					 	  ->whereIn('wp_posts.ID', $ops)
					 	  ->where('wp_term_relationships.term_taxonomy_id', $cid)
				     	  ->count();
			$connect[$kk]['scount'] = $count;	     	  
		}

		return view('products',compact('category','cid','goods','goodsCategory','allShape','count','pageNum','p','op','op_array','connect'));
	}

	/**
	* 商品详情页
	* @param intval id goods id
	*/
	public function detail($id)
	{
		//获取单个商品信息

		$goodsInfo = Posts::where("wp_posts.ID", $id)
						->with([
							'get_sku', 
							'attachment', 
							'get_category.get_items.getterminfo', 
							'get_ter_taxonomy_connect.get_items.getterminfo', 
							'get_ter_taxonomy_shape.get_items.getterminfo',
							'get_imgs.get_goods_img',
							'get_sku.get_stock',
							'get_collect'
						])	
						->first()
						->toArray();
		$r = '';
		$rv = '';
		if(!empty($goodsInfo['get_sku'])){
			//获取sku的名称
			$res_array = $goodsInfo['get_sku']['0']['meta_value'];
			$strlen = strlen($res_array);
			$change = strpos($res_array, "\n");  //\n之前的字符长度
			$_res = substr($res_array, -$strlen, $change);  //从头开始截取到指字符位置。
			//获取sku的属性key
			$search_k = '/<b>(.*?)<\/b>/is';
			preg_match_all($search_k,$res_array,$r,PREG_SET_ORDER);
			//获取sku的属性值
			$search_v = '/<td>(.*?)<\/td>/is';

			preg_match_all($search_v,$res_array,$r_v,PREG_SET_ORDER );
		}

		//获取购物车数据 sku_id 封装成数组
		$content = \Cart::content()->toArray();
		//获取当前id下的sku_id
		$sku_ids = Posts::where('post_parent', '=', $id)->pluck('ID')->toArray();

		$cart = array();
		$cart_count = 0;
		if(count($content)>0){
			foreach($content as $k=> $v){
				$cart[] = $v['id'];
				if(in_array($v['id'], $sku_ids)) $cart_count++;
			}
		}

		//获取当前分类下的购物车id

		return view('goods_detail',compact('goodsInfo', 'r', 'cart', 'cart_count'));
	}

	/**
	* 添加至询价单
	*/
	public function card()
	{
		//获取型号id
		$skus_id = request('data');
		if($skus_id){
			//查询商品
			$goods = Posts::whereIn('ID', $skus_id)->with('get_parent_attachment.attachment')->get()->toArray();
			foreach ($goods as $k => $v) {
				Cart::add($v['ID'],$v['post_title'], 1, 0, $v);	
			}
			return response()->json(['code'=>0 ,'msg' => '加入询价单成功']);	
		}else{
			$carts = Cart::content();
			dd($carts);
			return view('cart');
		}
	}

	/**
	* 查找配件 形状
	* @param intval cid category id
	*/
	public function shape()
	{
		//获取所有形状
		$shape = TermTaxonomy::leftJoin('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							 ->where('wp_term_taxonomy.taxonomy', 'pa_shape')
							 ->with('get_goods.get_goods_img')
							 ->get()
							 ->toArray();

		//dd($shape);
		//通过object_id 获取
		return view('shape', compact('shape'));

	}

	/**
	* 查找配件 连接
	* @param sid 形状id
	*/
	public function connect($sid)
	{
		/*$goods = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
					  ->where('wp_term_relationships.term_taxonomy_id' ,$cid)
					  ->with(['get_ter_taxonomy_connect.get_items.getterminfo', 'attachment'])
					  ->get()
					  ->toArray();			  
		foreach ($goods as $key => $value) 
		{
			$goods[$key] = $value['get_ter_taxonomy_connect']['0'];
			$goods[$key]['attachment'] = $value['attachment'];
		}

		//获取分类下商品形状 连接
		$connect = unique_multidim_array($goods, 'term_taxonomy_id');

		//获取形状信息
		$shape = Terms::where('term_id', $sid )->first()->toArray();*/
		$shape = Terms::where('term_id', $sid )->first()->toArray();
		//获取当前形状下商品的图片信息 当做形状图片
		$connect = TermTaxonomy::leftJoin('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							 ->where('wp_term_taxonomy.taxonomy', 'pa_connections')
							 ->with('get_goods.get_goods_img')
							 ->get()
							 ->toArray();
		//dd($connect);

		$shapeImages = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
									  ->where('wp_term_relationships.term_taxonomy_id' ,$sid)
									  ->with(['attachment'])
									  ->first()
									  ->toArray();



		return view('connect', compact('connect', 'shape', 'sid', 'shapeImages'));
	}

	/**
	* 查找配件 材质
	* @param cid 分类id
	* @param sid 形状id
	* @param conid 连接id
	*/
	public function stuff($cid, $sid, $conid)
	{
		//暂时无数据  不进行编写

		//wp_postmeta 对应postid 表里的 _sku 的值对应 pressureratings 里的PartNum  查出来 商品的材质 Material

		//获取当前分类下所有商品
		$goods = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
					  ->where('wp_term_relationships.term_taxonomy_id' ,$cid)
					  ->with(['attachment', 'get_stuff.get_material'])				  
					  ->get()
					  ->toArray();	

		foreach ($goods as $key => $value) 
		{
			$goods[$key] = $value['get_stuff']['0'];
		}


		//获取分类下商品形状 连接
		$stuff = unique_multidim_array($goods, 'post_id');
			  
		dd($stuff);			  
		//连接形式
		$connection = ShapeConnection::where('id', $conid)->first()->toArray();
		//获取所有材质
		$stuff = Stuff::get()->toArray();
		return view('stuff', compact('connection', 'cid', 'sid', 'conid', 'stuff'));
	}

	/**
	* 查找配件 结果
	* @param sid 形状id
	* @param conid 连接id
	* @param stuffid 材质id
	*/
	public function selectResult($sid, $conid)
	{
		//获取商品
		//获取分类筛选商品
		$op_array = array(
			$sid, $conid
		);
		$goods = Posts::with('attachment')
					  ->when(count($op_array), function($collection) use ($op_array) {
							$array_manys = array();
							$where  = '';
							foreach ($op_array as $kop => $vop) {
								$array_manys[$kop] = TermRelationships::where('term_taxonomy_id', $vop)->pluck('object_id')->toArray();
							}
							if(count($array_manys) > 1){
								$result = call_user_func_array('array_intersect', $array_manys);
								$collection->whereIn('ID',$result);
							}
						})
					 ->get()
					 ->toArray();		 
        //获取形状信息
		$shape = Terms::where('term_id', $sid )->first()->toArray();
		//获取当前形状下商品的图片信息 当做形状图片
		$shape['images'] = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
									  ->where('wp_term_relationships.term_taxonomy_id' ,$sid)
									  ->with(['attachment'])
									  ->first()
									  ->toArray();	

        //获取连接信息
		$connect = Terms::where('term_id', $conid)->first()->toArray();
		//获取当前形状下商品的图片信息 当做形状图片
		$connect['images'] = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
									  ->where('wp_term_relationships.term_taxonomy_id' ,$conid)
									  ->with(['attachment'])
									  ->first()
									  ->toArray();

		return view('selectresult',compact('goods', 'shape', 'connect'));
	}

	/**
	* 获取更多商品(index)
	* @param intval p 页码
	*/
	public function ajaxGoods()
	{
		$limit = 24;
		$p = request()->p;
		$p >= 1 ? $p = intval($p*$limit) : $p = 0;

		$goods = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						->whereIn('wp_term_relationships.term_taxonomy_id', [8,9,50,51])
						->where('wp_posts.post_type', 'product')
						->with('attachment')
						->offset($p)
						->limit(8)
						->get()
						->toArray();

		return response()->json($goods);
	}

	/**
	* 搜索商品
	* @param string keywords  关键字
	* @param int p 页码
	*/
	public function searchGoods()
	{
		$goods = Posts::where('wp_posts.post_title', 'like', '%'.addslashes(request()->keywords).'%')
						->with('attachment')
						->where('post_type', 'product')
						->get()
						->toArray();
		if(empty(request()->keywords)) $goods = array();

        return view('goods_search', ['goods'=>$goods]);
	}

	/**
	* 添加收藏
	*/
	public function ajax_add()
	{
	    $id = Auth::id();
	    $data=DB::table('collect')->where([['gid',request('id')],['uid',$id]])->first();
	    if(empty($data)){
	        $map=array('uid'=>$id,'gid'=>request('id'),'created_at'=>time());
	        DB::table('collect')->insert($map);
	        echo json_encode(array('code'=>"1"));
	        exit;
	    }else{
	        echo json_encode(array('code'=>"2"));
	        exit;
	    }
	}

	/**
	* 取消收藏
	*/
	public function ajax_del()
	{
	    DB::table('collect')->where('gid',request('id'))->delete();
	    return response()->json(['code'=>1]);
	}

    /**
    * 删除询价单
    * @param string $rowId session id
    */
    public function askorderdel()
    {
    	//商品id查出rowid
    	$cart = \Cart::content()->toArray();
    	foreach ($cart as $key => $value) {
    		if($value['id']==request('rowid'))
    		{
    			if(\Cart::remove($value['rowId'])){
    				echo '1';
    			}else{
    				echo '2';
    			}
    		}
    	}
    }




	/**
	* ajax 获取cad
	*/
	public function getcad($id)
	{
		$title = Posts::where('ID', $id)->value('post_title');

		$t1 = mb_strpos($title,'-');

		$t2 = mb_strpos($title,'(');

		$title = trim(mb_substr($title,$t1+1,$t2-$t1-1));

		return response()->json(['code'=>0, 'link'=>Cad::where('ItemNumber', $title)->value('Link')]);
	}

	/**
	* 获取商品是否在购物车内
	**/
	public function is_cart()
	{
		$id = request()->id;
		$list = \Cart::content();
		if($list){
			$list = $list->toArray();
			foreach ($list as $k => $v) {
				if($v['id']==$id)	return response()->json(['code'=>0, 'msg'=>'在购物车内']);
				
			}
			return response()->json(['code'=>1, 'msg'=>'不在购物车内']);
		}else{
			return response()->json(['code'=>1, 'msg'=>'购物车没当数据']);
		}
	}

}