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
use App\Models\PurchaseOrder;
use App\Models\Goods;

class PurchaseOrderController extends Controller
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
        return Admin::grid(PurchaseOrder::class, function (Grid $grid) {

            $grid->filter(function($filter){
                $filter->like('order_num', trans('purchase.order_num'));
            });

            $grid->model()->orderBy('ID', 'desc');
            $grid->id(trans('purchase.id'))->sortable();
            $grid->order_num(trans('purchase.order_num'));
            $grid->column('users.uname',trans('purchase.uname'));
            $grid->column('users.phone',trans('purchase.phone'));

            $grid->is_tax(trans('purchase.is_tax'))->display(function($is_tax){
                switch ($is_tax){
                    case 0:
                        return "<span class='label label-danger'>不含税</span>";
                        break;
                    case 1:
                        return "<span class='label label-info'>含税</span>";
                        break;
                }
            });
            $grid->total_price(trans('purchase.total_price'));
            $grid->status(trans('purchase.status'))->display(function ($name) {
                switch ($name){
                    case 0:
                        return "<span class='label label-danger'>未确认</span>";
                        break;
                    case 1:
                        return "<span class='label label-info'>已确认</span>";
                        break;
                    case 2:
                        return "<span class='label label-success'>已发货</span>";
                        break;
                    case 3:
                        return "<span class='label label-success'>已完成</span>";    
                }
            });
            $grid->created_at(trans('purchase.created_at'))->sortable();
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
        return Admin::form(PurchaseOrder::class, function (Form $form) {
            $form->tab(trans('purchase.base_info'), function ($form) {
                $form->display('id', trans('goods.id'));
                $form->hidden('id', trans('goods.id'));
                $form->display('askorder.order_num',trans('purchase.ask_num'));
                $form->display('askorder.created_at',trans('purchase.ask_start_time'));
                $form->display('askorder.end_time',trans('purchase.ask_end_time'));
                $form->date('valid_date',trans('purchase.valid_date'));
                $form->text('address',trans('purchase.address'));
                $form->textarea('other_desc',trans('purchase.other_desc'));
                $form->file('path',trans('purchase.path'));
                $form->file('contract',trans('purchase.contract'));
                $form->select('status',trans('purchase.status'))->options([0 => '未确认', 1 => '已确认',2=>'已发货',3=>'已完成']);
            })->tab(trans('purchase.goods_info'), function (Form $form){
                $form->hasMany('purchaseordergoods', '', function (Form\NestedForm $form) {
                    $form->image('goods_img',trans('purchase.cover'))->move('/image')->removable();
                    $form->display('goods_num',trans('purchase.goods_num'));
                    $form->display('unit',trans('purchase.unit'));
                    $form->display('stuff',trans('purchase.stuff'));
                    $form->display('number',trans('purchase.number'));
                    $form->display('take_over_date',trans('purchase.take_over_date'));
                    $form->display('price_one',trans('purchase.price_one'));
                    $form->display('pay_in',trans('purchase.pay_in'));
                    $form->display('osn',trans('purchase.osn'));
                    $form->display('desc',trans('purchase.desc'));
                });
            });

            $form->display('created_at',trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
