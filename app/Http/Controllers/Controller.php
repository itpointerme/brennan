<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	//获取所有产品分类
        $typePub = \Cache::get('typePub');
        if(!$typePub){
            $typePub = \App\Models\Terms::leftJoin('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
                            ->select(['wp_terms.term_id', 'wp_terms.name', 'wp_term_taxonomy.term_taxonomy_id'])
                            ->whereIn('wp_terms.term_id', \App\Models\TermRelationships::select('term_taxonomy_id')->distinct()->get())
                            ->where('wp_term_taxonomy.taxonomy', 'product_cat')
                            ->get()
                            ->toArray();
            \Cache::put('typePub', $typePub, 30000);                    
        }
        


    	view()->share(compact('typePub'));
    }
}
