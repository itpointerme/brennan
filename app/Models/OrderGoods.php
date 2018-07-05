<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $table = 'order_goods';

    protected $fillable = ['goods_id','goods_stuff_id','goods_number','client_osn','client_desc`','type','order_id'];

    //获取商品详细信息
    public function getgoodsinfo()
    {
    	return $this->hasOne(Posts::class, 'ID', 'goods_id');
    }

    //获取商品sku详细信息
    public function getgoodskuinfo()
    {
    	return $this->hasOne(GoodsSku::class, 'id', 'sku_id');
    }
}
