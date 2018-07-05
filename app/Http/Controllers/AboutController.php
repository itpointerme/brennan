<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller{

	public function about()
	{	
		$about=DB::table('about')->where('id','1')->first();
		$year=DB::table('year')->orderBy('id','desc')->get();

		return view('about',['about'=>$about,'year'=>$year]);
	}


}