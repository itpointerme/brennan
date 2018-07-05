<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Clause;

class Clause extends Model
{
    protected $table = 'clause';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Clause::class);
    }
}
