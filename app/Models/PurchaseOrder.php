<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
	
	public function users()
	{
		return $this->hasOne(Users::class,'id','uid');
	}

	public function askorder()
	{
		return $this->hasOne(AskOrder::class,'id','ask_order_id');
	}

	public function purchaseordergoods()
	{
		return $this->hasMany(PurchaseOrderGoods::class,'id');
	}
}
