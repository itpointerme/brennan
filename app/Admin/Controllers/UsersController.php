<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Users;
use App\Models\Type as Category;

class UsersController extends Controller
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

            $content->header(trans('users.title'));
            $content->description(trans('users.title'));

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

            $content->header(trans('users.edit'));
            $content->description(trans('users.edit'));

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

            $content->header(trans('users.add'));
            $content->description(trans('users.add'));

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
        return Admin::grid(Users::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('users', trans('users.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->phone(trans('users.phone'));
            $grid->email(trans('users.email'));
            $grid->uname(trans('users.uname'));
            $grid->type(trans('users.type'))->display(function ($name) {
                if($name <= 0) return "用户";
                return "客服";
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Users::class, function (Form $form) {
            $form->tab(trans('users.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->text('phone',trans('users.phone'));
                $form->password('password',trans('users.password'));
                $form->text('email',trans('users.email'));
                $form->text('uname',trans('users.uname'));
                $form->select('type',trans('users.type'))->options(['0' => '用户', '1' => '客服'])->default('type');
            });
            $form->saving(function (Form $form) {
                $form->password = bcrypt($form->password);
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
