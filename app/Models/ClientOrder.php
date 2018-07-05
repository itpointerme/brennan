<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    protected $table = 'client_order';

    //获取收藏建商品的详细信息
    public function getgoodsinfo()
    {
    	return $this->hasOne(Posts::class, 'ID', 'goods_id');
    }
}
