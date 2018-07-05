<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Address;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone','password','email','type','id_card'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * 获取用户地址信息
    */
    public function getaddress()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    /**
    * 获取销售下用户订单
    */
    /*public function getorders()
    {
        return $this->hasMany(Models\Order::class, 'id', 'users_id')->where('enable',0);
    }*/

}
