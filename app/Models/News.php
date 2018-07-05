<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewsAttr;

class News extends Model
{
    protected $table = 'news';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(NewsAttr::class);
    }
}
