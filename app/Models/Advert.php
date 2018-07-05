<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Advert;

class Advert extends Model
{
    protected $table = 'advert';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Advert::class);
    }
}
