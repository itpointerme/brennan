<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\ShapeConnection;
use App\Models\Type;
use App\Models\Goods;
use App\Models\Terms;
use App\Models\Posts;
use Auth;

class IndexController extends Controller{

	public function index()
	{
		$banner=DB::table('banner')->orderBy('id', 'desc')->get();
		//广告位
		$advert=DB::table('advert')->orderBy('id', 'asc')->get();
		//新闻
		$news=DB::table('news')->orderBy('id', 'desc')->limit(4)->get();

		//获取分类信息
		$category = Terms::leftJoin('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							->select(['wp_terms.term_id', 'wp_terms.name', 'wp_term_taxonomy.term_taxonomy_id'])
							->where('wp_term_taxonomy.taxonomy', 'product_cat')
							->limit(10)
							->get()
							->toArray();

		//获取形状信息
		$shape = Terms::leftJoin('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							->select(['wp_terms.term_id', 'wp_terms.name', 'wp_term_taxonomy.term_taxonomy_id'])
							->where('wp_term_taxonomy.taxonomy', 'pa_shape')
							->limit(10)
							->get()
							->toArray();

		//获取连接信息
		$connect = Terms::leftJoin('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
							->select(['wp_terms.term_id', 'wp_terms.name', 'wp_term_taxonomy.term_taxonomy_id'])
							->where('wp_term_taxonomy.taxonomy', 'pa_connections')
							->limit(10)
							->get()
							->toArray();

		//获取商品 
		$goods = Posts::leftJoin('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
						->whereIn('wp_term_relationships.term_taxonomy_id', [8,9,50,51])
						->with('attachment')
						->limit(8)
						->get()
						->toArray();
		
		return view('index',compact('banner', 'advert', 'news', 'category', 'shape', 'connect', 'goods'));
	}

	public function aba()
	{
		echo '123';
	}

}