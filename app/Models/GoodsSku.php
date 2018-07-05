<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsSku extends Model
{
    protected $table = 'goods_sku';

    //获取型号属性
    public function getskuattr()
    {
    	return $this->hasMany(GoodsSkuAttr::class,'goods_sku_id','id');
    }

    public function getgoods()
    {
    	return $this->hasOne(Goods::class,'id','goods_id');
    }

    public function getstuff()
    {
        return $this->hasOne(GoodsStuff::class,'goods_id','goods_id');
    }
}
