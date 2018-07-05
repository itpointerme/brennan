<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'wp_posts';

    public $timestamps = false;

    protected $primaryKey = 'ID';

	//获取商品附件信息
    public function attachment()
    {
    	return $this->hasMany(Posts::class, 'post_parent', 'ID')->where('post_type', 'attachment');
    }

    //获取商品形状
    public function get_ter_taxonomy_shape()
    {
    	$option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'pa_shape')->get()->toArray();

    	return $this->hasMany(TermRelationships::class, 'object_id', 'ID')
			    	->select(['object_id', 'term_taxonomy_id'])
			    	->whereIn('term_taxonomy_id', $option);
    }

    //获取商品连接
	public function get_ter_taxonomy_connect()
    {
    	$option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'pa_connections')->get()->toArray();

    	return $this->hasMany(TermRelationships::class, 'object_id', 'ID')
    				->select(['object_id', 'term_taxonomy_id'])
    				->whereIn('term_taxonomy_id', $option);
    }

    //获取商品类别
    public function get_category()
    {
    	$option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'product_cat')->get()->toArray();
    	return $this->hasMany(TermRelationships::class, 'object_id', 'ID')
    				->select(['object_id', 'term_taxonomy_id'])
    				->whereIn('term_taxonomy_id', $option);
    }

    //获取商品下的sku 和sku属性
    public function get_sku()
    {
    	return $this->hasMany(Posts::class, 'post_parent', 'ID')
    				->leftJoin('wp_postmeta as a', 'post_id', '=', 'ID')
    				->where('a.meta_key', '_variation_description');
    }

    //获取商品下的材质
   /* public function get_material()
    {
    	$option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'pa_material')->get()->toArray();

    	return $this->hasMany(TermRelationships::class, 'object_id', 'ID')
    				->select(['object_id', 'term_taxonomy_id'])
    				->whereIn('term_taxonomy_id', $option);	
    }*/

    //获取商品对应的图片
    public function get_imgs()
    {
    	return $this->hasMany(Postmeta::class, 'post_id', 'ID')->where('meta_key', '_thumbnail_id')->orWhere('meta_key', '_product_image_gallery');
    }

    //获取商品对应材质
    public function get_stuff()
    {
    	return $this->hasMany(Postmeta::class, 'post_id', 'ID')->where('meta_key', '_sku');	
    }

    //获取父级的商品图片
    public function get_parent_attachment()
    {
    	return $this->hasOne(Posts::class, 'ID', 'post_parent')->where('post_type', 'product');
    }

    //获取父级的商品分类
    public function get_parent_category()
    {
        $option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'product_cat')->get()->toArray();
        return $this->hasMany(TermRelationships::class, 'object_id', 'post_parent')
                    ->select(['object_id', 'term_taxonomy_id'])
                    ->whereIn('term_taxonomy_id', $option);
    }

    //获取cad信息
    public function getcad()
    {
        $option = TermTaxonomy::select(['term_id'])->where('taxonomy', 'pa_cad')->get()->toArray();

        return $this->hasMany(TermRelationships::class, 'object_id', 'ID')
                    ->select(['object_id', 'term_taxonomy_id'])
                    ->whereIn('term_taxonomy_id', $option);
    }

    //获取商品库存信息
    public function get_stock()
    {
        return $this->hasOne(Stock::class, 'goods_num', 'post_title');
    }

    //获取该商品是否被收藏
    public function get_collect()
    {
        return $this->hasOne(Collect::class, 'gid', 'ID');
    }
}
