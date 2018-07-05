<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GoodsAttr;

class Goods extends Model
{
    protected $table = 'goods';

    //relation for goods_attr
  /*  public function attr()
    {
    	return $this->hasOne(GoodsAttr::class);
    }*/

    //set pictures save data
    public function setPicturesAttribute($pictures)
	{
	    if (is_array($pictures)) {
	        $this->attributes['pictures'] = json_encode($pictures);
	    }
	}

	//get pictures
	public function getPicturesAttribute($pictures)
	{
	    return json_decode($pictures, true);
	}

	public function askorder()
	{
		return $this->belongsToMany(AskOrder::class);
	}

	//获取形状
	public function getshape()
	{
		return $this->hasOne(ShapeConnection::class,'id','shape_connection_id');
	}

	//获取连接
	public function getcon()
	{
		return $this->hasOne(ShapeConnection::class,'id','connection_shape_id');
	}
	//获取属性
	public function getattr()
	{
		return $this->hasMany(GoodsAttrConnect::class,'goods_id','id');
	}
	//获取型号
	public function getsku()
	{
		return $this->hasMany(GoodsSku::class,'goods_id','id');
	}
	//获取产品图片
	public function getimages()
	{
		return $this->hasMany(GoodsImages::class,'goods_id','id');
	}
	//获取分类
	public function getcategory()
	{
		return $this->hasOne(Type::class,'id','goods_category_id');
	}

	//获取商品材质
	public function getstuff()
    {
        return $this->hasOne(GoodsStuff::class,'goods_id','id');
    }
}
