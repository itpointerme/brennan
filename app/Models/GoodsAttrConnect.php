<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsAttrConnect extends Model
{
    protected $table = 'goods_attr_connect';

    public function getattr()
    {
    	return $this->hasOne(GoodsAttr::class,'id','goods_attr_id');
    }
}
