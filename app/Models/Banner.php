<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Banner;

class Banner extends Model
{
    protected $table = 'banner';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Banner::class);
    }
}
