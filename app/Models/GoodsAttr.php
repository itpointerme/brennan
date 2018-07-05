<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Goods;

class GoodsAttr extends Model
{
    protected $table = 'goods_attr';

    //relation goods goods
    public function goods()
    {
    	 return $this->belongsTo(Goods::class);
    }
}
