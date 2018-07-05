<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name','phone','mobile_phone','city_id','pro_id','area_id','uid','area_code'
    ];

    //获取省份名称
    public function getpro()
    {
    	return $this->hasOne(Province::class, 'id', 'pro_id');
    }

    //获取城市名称
    public function getcity()
    {
    	return $this->hasOne(City::class, 'id', 'city_id');
    }

    //获取区域名称
    public function getarea()
    {
    	return $this->hasOne(Area::class, 'id', 'area_id');
    }

}
