<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Address;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = ['address_name','status','sort','user_id','name','mobile','mask','city_id','pro_id','area_id'];


    public function users()
    {
    	return $this->belongsTo(Users::class);
    }

    public function getcityname()
    {
    	return $this->hasOne(City::class,'id','city_id');
    }

    public function getprovincename()
    {
    	return $this->hasOne(Province::class,'id','pro_id');
    }

    public function getareaname()
    {
    	return $this->hasOne(Area::class,'id','area_id');
    }
}
