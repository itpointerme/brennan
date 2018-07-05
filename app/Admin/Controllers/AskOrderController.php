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
use App\Models\AskOrder;
use App\Models\Goods;

class AskOrderController extends Controller
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

            $content->header(trans('ask.list'));
            $content->description(trans('ask.list'));

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

            $content->header(trans('ask.edit'));
            $content->description(trans('ask.edit'));

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

            $content->header(trans('ask.add'));
            $content->description(trans('ask.add'));

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
        return Admin::grid(AskOrder::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('ask.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id(trans('ask.id'))->sortable();
            $grid->title(trans('ask.title'));
            $grid->order_num(trans('ask.osn'));
            $grid->address(trans('ask.address'));
            $grid->status(trans('ask.status'))->display(function ($name) {
                switch ($name){
                    case 0:
                        return "<span class='label label-danger'>未报价</span>";
                        break;
                    case 1:
                        return "<span class='label label-info'>已报价</span>";
                        break;
                }
            });
            $grid->created_at(trans('admin.created_at'))->sortable();
            $grid->updated_at(trans('admin.updated_at'))->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(AskOrder::class, function (Form $form) {
            $form->tab(trans('ask.base_info'), function ($form) {
                $form->display('id', trans('goods.id'));
                $form->hidden('id', trans('goods.id'));
                $form->text('title',trans('ask.title'));
                $form->text('order_num',trans('ask.osn'));
                $form->date('end_time',trans('ask.end_time'));
                $form->textarea('mask',trans('ask.mask'));
                $form->textarea('desc',trans('ask.desc'));
                $form->file('path',trans('ask.path'));
                $form->text('company_name',trans('ask.company_name'));
                $form->text('username',trans('ask.username'));
                $form->text('phone',trans('ask.phone'));
                $form->text('email',trans('ask.email'));
                $form->text('address',trans('ask.address'));
                $form->select('status',trans('ask.status'))->options([0 => '未报价', 1 => '已报价']);


            })->tab(trans('ask.goods_info'), function (Form $form){
            
                $form->hasMany('askordergoods', '', function (Form\NestedForm $form) {
                        $form->image('goods_img',trans('ask.cover'))->move('/image')->removable();
                        $form->display('goods_num','产品型号');
                        $form->display('pay_in','含税金额');
                        $form->display('osn','客户自编号');
                        $form->display('stuff','材质');
                        $form->display('desc','商品描述');
                        $form->text('quote_price','报价');
                });
               
                //$form->multipleSelect('goods','商品')->options(Goods::all()->pluck('goods_name','id'));

            });

            $form->display('created_at',trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));

            $form->saving(function (Form $form) {
                //回掉获取是否报价  报价所满足条件（所有商品报价）
                $count = count($form->askordergoods);
                $num = 0;
                foreach ($form->askordergoods as $k => $v)
                    if((int)$v['quote_price'] > 0) $num++;
                
                if($count == $num) AskOrder::where('id',$form->id)->update(['status'=>1]);
               
            });

        });
    }
}
