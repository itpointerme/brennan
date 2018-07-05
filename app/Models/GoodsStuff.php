<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsStuff extends Model
{
    protected $table = 'goods_stuff';

    //获取材质名称
    public function getname()
    {
    	return $this->hasOne(Stuff::class,'id','stuff_id');
    }
}
