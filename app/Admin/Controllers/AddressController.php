<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Address;
use App\User;

class AddressController extends Controller
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

            $content->header(trans('address.list'));
            $content->description(trans('address.list'));

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

            $content->header(trans('address.edit'));
            $content->description(trans('address.edit'));

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

            $content->header(trans('address.add'));
            $content->description(trans('address.add'));

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
        return Admin::grid(Address::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('list', trans('address.list'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();

            $grid->user_id()->display(function ($user_id) {
                   return User::where('id',$user_id)->value('uname');
            });
            
            $grid->name(trans('address.name'));
            $grid->mobile(trans('address.mobile'));
            $grid->address_name(trans('address.address_name'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Address::class, function (Form $form) {
            $form->tab(trans('address.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->text('name',trans('address.name'));
                $form->text('mobile',trans('address.mobile'));
                $form->text('tel',trans('address.tel'));
                $form->text('address_name',trans('address.address_name'));
                $form->radio('status',trans('address.status'))->options(['1' => '启用', '2'=> '不启用'])->default('status');
                $form->text('mask',trans('address.mask'));
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
