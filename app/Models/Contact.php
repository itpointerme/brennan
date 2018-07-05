<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Contact extends Model
{
    protected $table = 'contact';

    //relation for goods_attr
    public function attr()
    {
    	return $this->hasOne(Contact::class);
    }
}
