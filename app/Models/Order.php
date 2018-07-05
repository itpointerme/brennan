<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = ['id','theme','supplement','appendix_path','appendix_path','order_askcol','company_name','user_name','phone','mobile','email','type','order_sn','status','tax','quoted_price_end_time','term_of_validity','users_id','client_users_id','address','gender','area'];

    public function getordergoods()
    {
    	return $this->hasMany(OrderGoods::class, 'order_id' ,'id');
    }

    //获取用户信息
    public function getuserinfo()
    {
    	return $this->hasOne(Users::class, 'id', 'users_id');
    }
}
