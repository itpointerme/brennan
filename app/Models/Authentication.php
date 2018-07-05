<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Authentication;

class Authentication extends Model
{
    protected $table = 'authentication';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Authentication::class);
    }
}
