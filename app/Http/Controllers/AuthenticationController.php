<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller{

	public function authentication()
	{	
		$authentication = DB::table('authentication')->first();
		$data=DB::table('authentication')->where('id','!=','1')->orderBy('id','asc')->get();
		$orr=$this->array_group_by($data,'fen');
		return view('authentication',['authentication'=>$authentication,'data'=>$orr]);
	}

	public function authentication_pdf($id){
		$authentication = DB::table('authentication')->where('id',$id)->first();
		return view('pdf',['clause'=>$authentication]);
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