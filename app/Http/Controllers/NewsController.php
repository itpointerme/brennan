<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller{

	public function news()
	{	
		
		$news = DB::table('news')->orderBy('id','desc')->paginate(9);

		return view('news',['news'=>$news]);

	}

	public function news_show($id){

		$data=DB::table('news')->where('id',$id)->first();

		$num=$data->num+1;

		DB::table('news')->where('id',$id)->update(array('num'=>"$num"));

		$data2=DB::table('news')->where('id','<',$id)->orderBy('id','desc')->limit(6)->get();

		return view('news_show',['data'=>$data,'data2'=>$data2]);
	}

}