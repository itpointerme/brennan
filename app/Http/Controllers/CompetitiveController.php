<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Posts;

class CompetitiveController extends Controller{

	public function competitive()
	{	
		$webvxout=DB::table('webvxout')->orderBy('id', 'desc')->get();
		return view('competitive',['webvxout'=>$webvxout]);
	}

	public function ajax_competitive()
	{
		$count=DB::table('webxrout')->where([['VendorKey',request('choice')],['ItemNumber','like','%'.request('num').'%']])->count();
		$data=DB::table('webxrout')
				->where([['VendorKey',request('choice')],['ItemNumber','like','%'.request('num').'%']])
				->orderBy('id', 'asc')
				->limit(50)
				->get();
		$text='';
		foreach ($data as $key => $value) {
			$text.='<tr>';
			$text.='<td>'.$value->VendorKey.'</td>';
			$text.='<td>'.$value->ItemNumber.'</td>';
			$text.='<td>'.$value->VendorItem.'</td>';
			//获取该商品的链接
			$part = strstr($value->ItemNumber, '-', True);
			$posts = Posts::where('post_title', 'like', '%'.$part)->first();
			if($posts){
				$text.='<td><a href="'.route('gdetail', ['id'=>$posts->ID]).'">搜索目录</a></td>';
			}else{
				$text.='没有该商品的目录';
			}
			$text.='</tr>';
		}
		echo json_encode(array('msg'=>"ok",'text'=>$text,'count'=>$count),JSON_UNESCAPED_UNICODE);
	}

}