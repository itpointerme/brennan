<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class ClauseController extends Controller{

	public function clause()
	{	
		$clause = DB::table('clause')->first();
		$data=DB::table('clause')->where('id','!=','1')->orderBy('id','asc')->get();
		return view('clause',['clause'=>$clause,'data'=>$data]);
	}

	public function pdf($id){
		$clause = DB::table('clause')->where('id',$id)->first();
		return view('pdf',['clause'=>$clause]);
	}

	public function clause_show($id){
		$clause = DB::table('clause')->where('id',$id)->first();
		return view('clause_show',['clause'=>$clause]);
	}

}