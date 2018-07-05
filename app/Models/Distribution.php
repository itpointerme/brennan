<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Distribution;

class Distribution extends Model
{
    protected $table = 'distribution';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Distribution::class);
    }
}
