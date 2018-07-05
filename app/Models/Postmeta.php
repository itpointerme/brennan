<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    protected $table = 'wp_postmeta';
    
    //获取属性对应商品图片
    public function get_goods_img()
    {
    	return $this->hasOne(Posts::class, 'ID', 'meta_value');
    }

    //获取商品材质信息
    public function get_material()
    {
    	return $this->hasOne(Pressureratings::class, 'PartNum', 'meta_value');
    }
}
