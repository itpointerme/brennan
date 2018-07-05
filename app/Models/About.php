<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\About;

class About extends Model
{
    protected $table = 'about';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(About::class);
    }
}
