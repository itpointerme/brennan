<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Year;

class Year extends Model
{
    protected $table = 'year';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Year::class);
    }
}
