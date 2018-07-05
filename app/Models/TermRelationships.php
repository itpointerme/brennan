<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermRelationships extends Model
{
    protected $table = 'wp_term_relationships';
    
    //获取属性 
    public function get_items()
    {
    	return $this->hasOne(TermTaxonomy::class, 'term_taxonomy_id', 'term_taxonomy_id')->select(['term_taxonomy_id', 'taxonomy', 'count', 'term_id']);
    }
    //获取商品图片
    public function get_goods_img()
    {
    	return $this->hasMany(Posts::class, 'post_parent', 'object_id')->where('post_type', 'attachment');
    }
}
