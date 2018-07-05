<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	use ModelTree, AdminBuilder;

    protected $table = 'goods_category';

    //获取所有商品
    public function getgoods()
    {
    	return $this->hasMany(Goods::class,'goods_category_id','id');
    }
}
