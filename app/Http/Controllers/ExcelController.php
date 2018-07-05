<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class ExcelController extends Controller
{
    public function importExport(Request $request){
    	\DB::beginTransaction();
    	try{
			if($request->hasFile('file')){
	    		\Excel::load($request->file('file')->getRealPath(), function($reader) {
		 			$results = $reader->toArray();
		 			$data = array();
		 			foreach ($results as $k => $v) {
		 				$data['goods_num'] = $v['number'];
		 				$data['stock_local'] = $v['stock_l'];
		 				$data['stock_america'] = $v['stock_a'];
		 				$data['created_at'] = date('Y-m-d H:i:s', time());
		 				$data['updated_at'] = date('Y-m-d H:i:s', time());
		 				Stock::updateOrInsert(['goods_num'=>$v['number']],$data);
		 			}
				});
				\DB::commit();
    		}
    		return back();
    	}catch(\Exception $e){
    		\DB::rollback();
    		return back()->withInput()->withErrors($e->getMessage());
    	}
    }
    
}
