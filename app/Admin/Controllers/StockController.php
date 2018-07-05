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
use App\Models\Stock;
use App\Admin\Extensions\Tools\UserGender;


class StockController extends Controller
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

            $content->header(trans('purchase.list'));
            $content->description(trans('purchase.list'));

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

            $content->header(trans('purchase.edit'));
            $content->description(trans('purchase.edit'));

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

            $content->header(trans('purchase.add'));
            $content->description(trans('purchase.add'));

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
        return Admin::grid(Stock::class, function (Grid $grid) {

            $grid->tools(function ($tools) {
                 $tools->append(new UserGender());
            });

            $grid->filter(function($filter){
                $filter->like('goods_num', '布劳宁型号');
            });

            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->goods_num('布劳宁型号');
            $grid->stock_local('本地库存');
            $grid->stock_america('美国库存');

            $grid->created_at('创建时间')->sortable();
            //$grid->updated_at(trans('admin.updated_at'))->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Stock::class, function (Form $form) {
                $form->display('id', '序号');
                $form->hidden('id');
                $form->text('goods_num','布劳宁型号');
                $form->text('stock_local','本地库存');
                $form->text('stock_america','美国库存');
                $form->display('created_at','创建时间');
                $form->display('updated_at', '更新时间');
        });
    }
}
