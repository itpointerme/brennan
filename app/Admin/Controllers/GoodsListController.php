<?php
// +----------------------------------------------------------------------
// | 上海谷铂软件 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Author: itpointerme <itpointerme@163.com>
// +----------------------------------------------------------------------
namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Posts;
use App\Models\TermTaxonomy as Category;
use App\Models\ShapeConnection;

class GoodsListController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('goods.sub'));
            $content->description(trans('goods.sub'));

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header(trans('goods.edit'));
            $content->description(trans('goods.edit'));

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('goods.add'));
            $content->description(trans('goods.add'));

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Posts::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('goods.title'));
                $filter->like('post_date', '时间筛选');
            });

            $grid->model()->where('post_type', '=', 'product');
            
           // $grid->model()->orderBy('ID', 'desc');

            $grid->ID(trans('goods.id'))->sortable();

            $grid->attachment('商品图片')->display(function ($attachment) {
                $count = count($attachment);
                if($count > 0){
                    return "<img src= {$attachment['0']['guid']} style='width:50px;height:50px;'></img>";
                }else{
                    return "无图片";
                }
            });

            $grid->post_title(trans('posts.post_title'));

            $grid->post_date(trans('posts.post_date'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Posts::class, function (Form $form) {
            if(request()->route()->parameters){
                $id = request()->route()->parameters()['goodslist'];
            }

            $id= '';
            

            //dd($id);
            $form->tab(trans('goods.base_info'), function ($form) use($id) {
                $form->display('ID', trans('goods.id'));
                $form->text('post_title',trans('goods.title'));

                $category = Category::where('taxonomy', 'product_cat')->with('getterminfo')->get()->toArray();
                $category = array_pluck($category, 'getterminfo.name', 'getterminfo.term_id');

                $shape = Category::where('taxonomy', 'pa_shape')->with('getterminfo')->get()->toArray();
                $shape = array_pluck($shape, 'getterminfo.name', 'getterminfo.term_id');

                $connection = Category::where('taxonomy', 'pa_connections')->with('getterminfo')->get()->toArray();
                $connection = array_pluck($connection, 'getterminfo.name', 'getterminfo.term_id');

               // $goods = Posts::with('get_category')->where('ID', $id)->first()->toArray();

                //获取分类信息
                $form->select('get_category.0.term_taxonomy_id',trans('goods.catid'))->options($category);

                //获取形状信息
                $form->select('get_ter_taxonomy_shape.0.term_taxonomy_id',trans('形状'))->options($shape);

                //获取连接信息
                $form->select('get_ter_taxonomy_connect.0.term_taxonomy_id',trans('连接'))->options($connection);

                //获取图片地址
               // $form->image('goods_img',trans('goods.cover'))->move('/image')->removable();

                //$form->file('file',trans('goods.file'))->move('/file')->rules('mimes:zip,tar')->removable();

                $form->textarea('post_content',trans('goods.goods_remark'));

                $form->hidden('post_date')->default(date('Y-m-d H:i:s', time()));
                $form->hidden('post_date_gmt')->default(date('Y-m-d H:i:s', time()));
                $form->hidden('post_type')->default('product');
               
                //$form->select('status',trans('goods.status'))->options([0 => '上架', 1 => '下架']);

            })->tab(trans('goods.attr'), function (Form $form) use($id) {
                
                $form->hasMany('get_sku', '商品下sku', function (Form\NestedForm $form) {
                     $form->text('post_title', '商品型号');
                     $form->textarea('meta_value', '商品属性');
                });

            })->tab(trans('goods.img'), function (Form $form) use($id) {

                $form->hasMany('attachment', '商品相册', function (Form\NestedForm $form) {
                     $form->text('guid', '图片路径');
                });

            });
            $form->display('created_at',trans('admin.updated_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
