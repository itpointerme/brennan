<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderGoods extends Model
{
    protected $table = 'purchase_order_goods';

    protected $fillable = ['goods_num','stuff','unit','pay_in','price_one','number','take_over_date','osn','desc','goods_id','goods_img'];

    public function purchaseorder()
    {
    	return $this->belongsTo(PurchaseOrder::class,'purchase_order_goods_id');
    }
	
}
