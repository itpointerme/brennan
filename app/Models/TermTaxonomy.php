<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'wp_term_taxonomy';

    protected $primaryKey = 'term_taxonomy_id';

    //获取属性详细信息
    public function getterminfo()
    {
    	return $this->hasOne(Terms::class, 'term_id', 'term_id')->select(['term_id' ,'name']);
    }

    //获取单条商品详情
    public function get_goods()
    {
    	return $this->hasMany(TermRelationships::class, 'term_taxonomy_id', 'term_id');
    }
}
