<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller{

	public function contact()
	{	
		$about=DB::table('about')->where('id','1')->first();
		$contact=DB::table('contact')->orderBy('id','asc')->get();
		$distribution=DB::table('distribution')->orderBy('id','asc')->get();
		$orr=$this->array_group_by($distribution,'fen');
		return view('contact',['contact'=>$contact,'about'=>$about,'distribution'=>$orr]);
	}

	function array_group_by($arr, $key){
	    $grouped = [];
	    foreach ($arr as $value) {
	        $grouped[$value->$key][] = $value;
	    }
	    if (func_num_args() > 2) {
	        $args = func_get_args();
	        foreach ($grouped as $key => $value) {
	            $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
	            $grouped[$key] = call_user_func_array('array_group_by', $parms);
	        }
	    }
	    return $grouped;
	}


}