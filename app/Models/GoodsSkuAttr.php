<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsSkuAttr extends Model
{
    protected $table = 'goods_sku_attr';

    //获取属性名称
  /*  public function getattrname()
    {
    	return $this->hasOne(GoodsAttr::class,'id','goods_attr_id');
    }*/
}
